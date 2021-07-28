<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\UserCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\ElseIf_;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apps = Application::all();
        $title = "All applications";
        // $cats = Application::select(DB::raw('DISTINCT user_category_id'))
        //     ->pluck('user_category_id');

        $cats = UserCategory::all(['id', 'name', 'slug']);

        $cardLinks = $this->cardLinks($cats);
        return view('admin.pages.applications.index', compact('apps', 'cardLinks', 'title'));
    }

    protected function cardLinks($cats = [])
    {

        $cardLinks = [
            [
                'type' => 'route',
                'title' => 'All',
                'icon' => 'book-open',
                'route' => route('admin.applications')
            ]
        ];
        foreach ($cats as $c) {
            $cardLinks[] = [
                'type' => 'route',
                'title' => $c->name,
                'icon' => 'list-alt',
                'route' => route("admin.applications.category", $c->slug)
            ];
        }
        return $cardLinks;
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // return $request->all();

        $valid = Validator::make(
            $request->all(),
            [
                'cat_id' => 'required|integer',
            ],
            [
                'cat_id.required' => 'Please choose the category you are applying for'
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }
        // check if user have applied for this category before
        $cat_id = $request->cat_id;
        $applied = Application::where('user_id', Auth::id())
            ->where('user_category_id', $cat_id)
            ->first();

        if ($applied) {
            return [
                'message' => 'You have already applied for this category',
                'type' => 'info',
                'timeout' => 10000
            ];
        }
        $app = new Application();
        $app->user_category_id = $cat_id;
        $app->user_id = Auth::id();
        $app->save();
        return [
            'status' => 200,
            'message' => 'Your application has been submitted successfully',
            'type' => 'info',
            // 'to' => '/portal'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        //
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
    public function update(Request $request, Application $application)
    {
        //
    }

    public function approve(Request $request, Application $app)
    {
        // if (!$app->user_category_id) {
        //     return [
        //         'status' => 200,
        //         'message' => 'Unable to approve this application',
        //         'desc' => 'The program the user applied for might have been deleted',
        //         'type' => 'info'
        //     ];
        // }
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
