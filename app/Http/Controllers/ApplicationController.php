<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Member;
use App\Models\UserCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Membership;
use App\Models\Program;

use function PHPUnit\Framework\returnSelf;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apps = Application::latest('id')->take(100)->get();
        $title = "Last " . $apps->count() . " " . Str::plural('Application', $apps->count());
        // return $apps;

        return view('admin.pages.applications.index', compact('apps', 'title'));
    }

    public function id($member)
    {
        $class = ucfirst($member);

        $last_id = "App\Models\\$class"::latest('id')->first();

        if ($last_id) {
            $last_id = $last_id->id;
        } else {
            $last_id = 0;
        }

        $member_id = $last_id + 1;
        return [
            'member_id' => $member_id,
            'last_id' => $last_id
        ];
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function category($slug)
    {
        $cat = UserCategory::where('slug', $slug)->firstOrFail();
        $title = "applications for $cat->name";
        if ($cat->parent_id) {
            $title = "applicatins for  " . $cat->parent->name . " / " . $cat->name;
        }

        $cats = Application::select(DB::raw('DISTINCT user_category_id'))
            ->pluck('user_category_id');
        $cats = UserCategory::find($cats, ['id', 'name', 'slug']);
        $cardLinks = $this->cardLinks($cats);
        $cats = [$cat];

        return view(
            'admin.pages.applications.index',
            compact('cats', 'title', 'cardLinks')
        );
    }

    /**
     * Show the form for applying for  a new membre
     *
     * @return \Illuminate\Http\Response
     */
    public function memberApply()
    {
        $memberships = Membership::whereActive('1')->get();
        // return $memberships;
        return view('apply.member', compact('memberships'));
    }

    /**
     * Show the form for applying for  a new membre
     *
     * @return \Illuminate\Http\Response
     */
    public function studentApply()
    {
        $programs = Program::whereActive('1')
            ->where('visibility', '<', '3')
            ->whereIsProgram('1')
            ->get();
        // return $programs;
        return view('apply.student', compact('programs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $applying_for = $request->applying_for;

        $valid = Validator::make(
            $request->all(),
            [
                'applying_for' => 'required',
                'membership' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'dob' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'passport' => 'required|image',
                'form' => 'required_if:applying_for,member|file|mimes:pdf,docx',
                'terms' => 'required'
            ],
            ['terms.required' => 'You must agree to our terms To apply']
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $applied = Application::where('email', $request->email)
            ->whereNull('rejected_at')
            ->where('applying_for', $applying_for)
            ->where('item', $request->membership)
            ->first();

        if ($applied) {
            return [
                'message' => 'You have already applied for this Membership',
                'type' => 'info',
                'desc' => "You will be contacted via $applied->email",
                'timeout' => 400000
            ];
        }

        $app = new Application();
        $guards = ['scs' => "Short Course Student", 'pgs' => 'Program Student', 'mem' => 'Member'];
        foreach ($guards as $guard => $v) {
            if ($id = auth($guard)->id()) {
                $app->applicant_id = $id;
                $app->applicant = $v;
            } else {
                $app->applicant = 'Guest';
            }
        }

        $app->first_name = $request->first_name;
        $app->last_name = $request->last_name;
        $app->middle_name = $request->middle_name;
        $app->dob = $request->dob;
        $app->phone = $request->phone;
        $app->email = $request->email;

        $app->applying_for = $applying_for;
        $app->item = $request->membership;
        $app->ip = $request->ip();
        $app->device = $request->device;

        $app->item_id = $request->item_id;

        // saving photo;
        if ($request->hasFile('form')) {
            $form = $request->file('form');
            if ($form->isValid()) {

                $name =  Str::upper(Str::slug("$request->first_name $request->last_name"))
                    . '-MEMBER-APPLICATION' . '.' . $form->getClientOriginalExtension();
                $app->form = $form->storeAs('forms/members', $name);
            } else {
                return [
                    'message' => "Please upload the form you have filled",
                    'type' => 'error',
                    'status' => 200
                ];
            }
        }

        $passport = $request->file('passport');
        if ($passport->isValid()) {

            $name =  Str::slug("$request->first_name $request->last_name") . "-" . time()
                . '.' . $passport->getClientOriginalExtension();
            $app->passport = $passport->storeAs('members/passports', $name);
        } else {
            return [
                'message' => "Please upload your recent passport",
                'type' => 'error',
                'status' => 200
            ];
        }

        $app->save();
        return [
            'status' => 200,
            'message' => 'Your application has been submitted successfully',
            'desc' => 'You will be contacted via email',
            'type' => 'info',
            'to' => '/'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function details(Application $app)
    {
        return $app;
        return view('admin.pages.applications.details', compact('app'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $app)
    {
        // return $request->all();
        $for = Str::lower($request->applying_for);
        $table = $for . 's';

        if ($table != 'members' && $table != 'students') {
            return [
                'message' => "The application status is not recognized",
                'desc' => "Applied for can only be member or student",
                'status' => 200,
                'type' => 'error'
            ];
        }

        $col = $for == 'member' ? 'member_id' : 'matric_no';
        $unique_id = "required_if:approved,1|unique:$table,$col";

        $valid = Validator::make(
            $request->all(),
            [
                'applying_for' => 'required',
                'item' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'dob' => 'required',
                'phone' => 'required',
                'password' => 'required_if:approved,1',
                'email' => "required|unique:$table,email",
                'member_id' => $unique_id
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }


        // update the app status
        $date = date('Y-m-d H:i:s');
        $app->approved_at = $request->filled('approved') ? $date : null;
        $app->rejected_at = $request->filled('rejected') ? $date : null;
        $app->reviewed = $request->filled('reviewed');
        $app->reject_reason = $request->reject_reason;
        if ($app->rejected_at) {
            return [
                "message" => "$request->email has been notified about the rejected offer",
                'type' => 'success',
                'status' => 200,
            ];
            // send emil to applicant that his/application is rejected
        }
        $app->save();

        // save applicant
        if ($app->approved_at) {
            $class = ucfirst($for);
            $class =  "\App\\Models\\$class";


            $new = new $class;

            if ($for == 'member') {
                $new->member_id = $request->member_id;
                $new->membership_id = $request->item_id;
                $new->accepted_on = $date;
            } else {
                $new->program_id = $request->item_id;
                $new->matric_no = $request->member_id;
            }

            $new->first_name = $request->first_name;
            $new->last_name = $request->last_name;
            $new->middle_name = $request->middle_name;
            $new->email = $request->email;
            $new->phone = $request->phone;
            $new->password = bcrypt($request->password);
            $new->active = 1;
            $new->image = $app->passport;

            $new->save();
            return [
                "message" => "New $for added successfully",
                'desc' => "An Email has also been sent to notiy him of the approval",
                'status' => 200,
                'type' => 'success'
            ];
        }

        return [
            "message" => "Application has been updated successfully",
            'type' => 'success',
            // 'status' => 200,
        ];
    }

    public function approve(Request $request, Application $app)
    {
        $status = 'APPROVED';
        if ($app->approved_at) {
            $status = 'UN-APPROVED';
            $add_class = 'fa-times';
            $remove_class = 'fa-check';
            $app->approved_at = NULL;
        } else {
            $app->approved_at = date('Y-m-d H:i:s', time());
            $add_class = 'fa-check';
            $remove_class = 'fa-times';
        }
        $app->save();
        return [
            'status' => 200,
            'type' => 'success',
            'message' => "This application has been $status",
            'add_class' => $add_class,
            'remove_class' => $remove_class,
            'timeout' => 6000,
        ];
        return $app;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = trim($request->ids, ',');

        if (empty($ids)) {
            return ['message' => 'nothing to delete'];
        }

        $ids = explode(',', $ids);

        $total = Application::whereIn('id', $ids)->delete();

        if (!$total) {
            return [
                'type' => 'info',
                'message' => 'Unable to excute the delete command',
                'desc' => 'Reload this page and try again'
            ];
        }

        $desc = $total > 1 ? 'Reload this page to see changes' : '';

        return [
            'message' => "$total " . Str::plural('application', $total) . " Deleted successfuly",
            'status' => 200,
            'desc' => $desc
        ];
    }
}
