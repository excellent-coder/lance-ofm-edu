<?php

namespace App\Http\Controllers;

use App\Models\DeliveryMethod;
use App\Models\DeliveryPrice;
use Illuminate\Http\Request;
use App\Models\ProductCat;

class DeliveryPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prices = DeliveryPrice::all();
        $methods = DeliveryMethod::all();
        $supers = ProductCat::where('super_parent_id', null)
            ->where('parent_id', null)
            ->get();
        return view(
            'admin.pages.products.delivery-price',
            compact('prices', 'methods', 'supers')
        );
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
        $request->validate(['delivery_method' => 'required']);
        $dp = new DeliveryPrice();
        $dp->delivery_method_id = $request->delivery_method;
        $dp->product_cat_id = $request->product_at;
        $dp->product_id = $request->product;

        $dp->city_id = $request->city;
        $dp->state_id = $request->sate;
        $dp->price = $request->price;

        $dp->save();

        // $to = $request->modal ? false : route('admin.courses');
        return [
            'message' => "Delivery Price Added successfuly",
            'status' => 200,
            'type' => 'success',
            // 'to' =>
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeliveryPrice  $deliveryPrice
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryPrice $deliveryPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeliveryPrice  $deliveryPrice
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryPrice $deliveryPrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeliveryPrice  $deliveryPrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryPrice $deliveryPrice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeliveryPrice  $deliveryPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryPrice $deliveryPrice)
    {
        //
    }
}
