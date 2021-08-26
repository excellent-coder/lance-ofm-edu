<?php

namespace App\Http\Controllers;

use App\Models\NotificationCat;
use App\Models\UserTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class NotificationCatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = NotificationCat::all();
        $tables = UserTable::all();
        return view('admin.pages.notifications.categories', compact('categories', 'tables'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $valid = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:notification_cats,name',
                'receivers' => 'required',
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $n = new NotificationCat();
        $n->name = $request->name;
        $n->user_table_ids = implode(',', $request->receivers);
        $n->selector = $request->selector;
        $n->save();

        return [
            'message' => 'Notification Category updated successfully',
            'status' => 200,
            'type' => 'success'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NotificationCat  $notificationCat
     * @return \Illuminate\Http\Response
     */
    public function show(NotificationCat $notificationCat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NotificationCat  $notificationCat
     * @return \Illuminate\Http\Response
     */
    public function edit(NotificationCat $notificationCat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NotificationCat  $notificationCat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NotificationCat $notificationCat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NotificationCat  $notificationCat
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotificationCat $notificationCat)
    {
        //
    }
}
