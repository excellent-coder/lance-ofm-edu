<?php

namespace App\Http\Controllers;

use App\Mail\Applied;
use App\Mail\AdminApplied;
use App\Mail\ApproveApp;
use App\Mail\RejectApp;
use App\Models\Application;
use App\Models\AppPayment;
use App\Models\Member;
use App\Models\UserCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Membership;
use App\Models\Program;
use App\Models\Payment;
use App\Models\Session;
use App\Models\StudentProgram;
use App\Models\User;
use Illuminate\Support\Facades\App;

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
        $model = "App\Models\\$class";



        switch ($member) {
            case 'member':
                $last = $model::latest('id')->whereNotNull('member_id')
                    ->first();
                $last_id = $last->member_id ?? 0;
                break;
            case 'student':
                $last = $model::latest('id')->whereNotNull('matric_no')
                    ->first();
                $last_id = $last->matric_no ?? 0;
                break;
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
        $memberships = Membership::whereActive('1')->where('parent_id', null)->get();
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
        $applying_for = Str::lower($request->applying_for);

        if ($applying_for != 'member' && $applying_for != 'student') {
            return [
                'message' => "The application status is not recognized",
                'desc' => "Refresh Your browser and try again",
                'reload' => true,
                'status' => 200,
                'type' => 'error'
            ];
        }

        $valid = Validator::make(
            $request->all(),
            [
                'applying_for' => 'required',
                'membership' => 'required',
                'sub_membership' => 'required_if:sub,1',
                'first_name' => 'required',
                'last_name' => 'required',
                'dob' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'passport' => 'required|image',
                'terms' => 'required',
                'pay' => 'required'
            ],
            [
                'terms.required' => 'You must agree to our terms To apply',
                'sub_membership.required_if' => 'Sub membership is Required',
                'pay.required' => 'You must be ready to make payment of
                                    application fee before registration'

            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $membership = $request->membership;
        $item_id = $request->item_id;

        if ($request->sub_membership) {
            $membership = $request->sub_membership;
            $item_id = $request->sub_item_id;
        }
        // return ['--'];
        $applied = Application::where('email', $request->email)
            ->whereNull('rejected_at')
            ->where('applying_for', $applying_for)
            ->where('item_id', $item_id)
            ->first();

        if ($applied) {
            return [
                'message' => "You have already applied for this $membership $applying_for",
                'type' => 'info',
                'desc' => "You will be contacted via $applied->email Once the status
                of your request is updated",
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
        $app->item = $membership;
        $app->ip = $request->ip();
        $app->device = $request->device;

        $app->item_id = $item_id;

        // saving form;
        if ($request->hasFile('certificate')) {
            $cert = $request->file('certificate');
            if ($cert->isValid()) {

                $name =  Str::upper(Str::slug("$request->first_name $request->last_name"))
                    . '-MEMBER-APP-CERT-' . time() . '-.' . $cert->getClientOriginalExtension();
                $app->certificates = $cert->storeAs(
                    "$request->applying_for/certificates",
                    $name
                );
            } else {
                return [
                    'message' => "Please upload avalid certificate",
                    'type' => 'error',
                    'status' => 200
                ];
            }
        }

        // saving documents
        if ($request->hasFile('documents')) {
            $docs = $request->file('documents');
            $docName = [];
            foreach ($docs as $d) {
                if ($d->isValid()) {
                    $name = Str::slug("$request->first_name $request->last_name")
                        . '-' . time()
                        . $d->getClientOriginalName();

                    $docName[] = $d->storeAs(
                        "$request->applying_for/documents",
                        $name
                    );
                }
            }

            $app->documents = implode(',', $docName);
        }

        $passport = $request->file('passport');
        if ($passport->isValid()) {

            $name =  Str::slug("$request->first_name $request->last_name") . "-" . time()
                . '.' . $passport->getClientOriginalExtension();
            $app->passport = $passport->storeAs("$request->applying_for/passports", $name);
        }

        $app->save();

        switch ($applying_for) {
            case 'member':
                $amount = Membership::find($item_id)->application_fee;
                $code = 'MEM';
                break;
            case 'student':
                $amount = Program::find($item_id)->main_student_app_fee;
                $code = 'STU';
                break;
        }

        if ((int) $amount < 1) {
            // no payment needed
            Mail::send(new AdminApplied($app));
            Mail::send(new Applied($app));

            return [
                'status' => 200,
                'message' => 'Your application has been submitted successfully',
                'desc' => 'You will be contacted via email',
                'type' => 'info',
            ];
        }

        $payment = new AppPayment();
        $payment->application_id = $app->id;
        $payment->tag = 'applications';

        $payment->amount = $amount;
        $payment->currency =  web_setting('general', 'currency');
        $payment->reason = "Application for $membership $applying_for";
        do {
            $ref = "ISAM-REG-$code-" . Str::upper(Str::random(10));
        } while (AppPayment::where('ref', $ref)->first());

        $payment->ref = $ref;
        $payment->ip = $request->ip();
        $mac = exec('getmac');
        $payment->mac = strtok($mac, ' ');
        $payment->device = $request->devce;
        $payment->save();


        $p = [
            'public_key' => config('services.rave.public_key'),
            'ref' => $ref,
            'amount' => $payment->amount,
            'currency' => $payment->currency,
            'country' => config('msc.country', 'NG'),
            'redirect' => route('app.paid', $payment->id),
            'meta' => ['consumer_id' => $app->id, 'consumer_mac' => $mac],
            'customer' => [
                'email' => $request->email,
                'phone_number' => $request->phone,
                'reason' => $payment->reason,
                'user_id' => $app->id,
                'name' => "$request->last_name $request->first_name",
            ],
            'customization' => [
                'title' => web_setting('scs', 'payment_title', 'Title'),
                'description' => web_setting('scs', 'payment_desc', 'Description'),
                'logo' => asset('storage/' . web_setting('general', 'logo', 'web/logo.png'))
            ],
        ];

        // Mail::send(new AdminApplied($app));
        // Mail::send(new Applied($app));

        return [
            'status' => 200,
            'message' => 'Your application has been submitted successfully',
            'desc' => 'You will be contacted via email',
            'type' => 'success',
            'payment' => $p,
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
            $app->save();

            if (!$request->reject_reason) {
                return [
                    'message' => "Please Fill reject reason",
                    'errors' => 'To noty the applicant about the rejection'
                ];
            }
            Mail::send(new RejectApp($app));
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

            $new->application_id = $app->id;

            if ($for == 'member') {
                $new->member_id = $request->member_id;
                $new->membership_id = $request->item_id;
            } else {
                $new->program_id = $request->item_id;
                $new->matric_no = $request->member_id;
            }
            $new->accepted_on = $date;

            $new->first_name = $request->first_name;
            $new->last_name = $request->last_name;
            $new->middle_name = $request->middle_name;
            $new->email = $request->email;
            $new->phone = $request->phone;
            $new->password = bcrypt($request->password);
            $new->active = 1;
            $new->image = $app->passport;

            $new->save();

            if ($for == 'student') {
                $sp = new StudentProgram();
                $sp->student_id =  $new->id;
                $sp->program_id = $request->item_id;
                $sp->session_id = Session::where('active', 1)->first()->id;
                $sp->active = 1;
                $sp->save();
            }

            $login = new Application();
            $login->id = $request->member_id;
            $login->password = $request->password;

            Mail::to($app->email, "$app->last_name $app->first_name")
                ->send(new ApproveApp($app, $login));
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
            'status' => 200,
        ];
    }

    public function approve(Request $request, $type, $item)
    {
        $apps = Application::where('applying_for', $type)
            ->whereNull('approved_at')
            ->where('item_id', $item)->get();

        $item_name = $request->category;
        $title = $apps->count()
            . ' Pending approval for '
            . Str::plural('Application', $apps->count())
            . " For $item_name $type";
        return view('admin.pages.applications.index', compact('apps', 'title'));
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
