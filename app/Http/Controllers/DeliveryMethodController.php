<?php

namespace App\Http\Controllers;

use App\Models\DeliveryMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DeliveryMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveries = DeliveryMethod::all();
        return view('admin.pages.products.deliveries', compact('deliveries'));
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
                'description' => 'required',
                'title' => 'required|max:191',
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $m = new DeliveryMethod();
        $m->title = $request->title;
        $m->description = $request->description;
        $m->save();
        return [
            'item' => $m,
            'type' => 'success',
            'status' => 200,
            'timeout' => 10000,
            'desc' => 'Reload page to see changes',
            'message' => 'Delivery Method added successfully'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeliveryMethod  $deliveryMethod
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryMethod $deliveryMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeliveryMethod  $deliveryMethod
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryMethod $deliveryMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeliveryMethod  $deliveryMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryMethod $method)
    {
        // return $request->all();

        $valid = Validator::make(
            $request->all(),
            [
                'description' => 'required',
                'title' => 'required|max:191',
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $method->title = $request->title;
        $method->description = $request->description;
        $method->save();
        return [
            'item' => $method,
            'type' => 'success',
            'desc' => 'Reload to see changes',
            'status' => 200,
            'timeout' => 10000,
            'message' => 'This Delivery Method updated successfully'
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeliveryMethod  $deliveryMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = trim($request->ids, ',');

        if (empty($ids)) {
            return ['message' => 'nothing to delete'];
        }

        $ids = explode(',', $ids);

        $total =  DeliveryMethod::whereIn('id', $ids)->delete();
        if (!$total) {
            return [
                'type' => 'info',
                'message' => 'Unable to excute the delete command',
                'desc' => 'Reload this page and try again'
            ];
        }

        $desc = $total > 1 ? 'Reload this page to see changes' : '';

        return [
            'message' => "$total " . Str::plural('method', $total) . " Deleted successfuly",
            'status' => 200,
            'desc' => $desc
        ];
    }
}
