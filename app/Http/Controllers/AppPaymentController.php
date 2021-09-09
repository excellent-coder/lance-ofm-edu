<?php

namespace App\Http\Controllers;

use App\Models\AppPayment;
use Illuminate\Http\Request;

class AppPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AppPayment  $appPayment
     * @return \Illuminate\Http\Response
     */
    public function show(AppPayment $payment)
    {
        return $payment->load('applicant');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AppPayment  $appPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(AppPayment $appPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AppPayment  $appPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AppPayment $appPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AppPayment  $appPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(AppPayment $appPayment)
    {
        //
    }


    public function paid(Request $request, AppPayment $payment)
    {
        // return $payment;
        if ($payment->transaction_id) {
            // this payment has been processes,
            return redirect('/');
        }
        if ($request->tx_ref != $payment->ref) {
            // something is wrong we will come to you later
        }
        $payment->status = $request->status;
        $payment->transaction_id = $request->transaction_id;
        $payment->paid_at = date('Y-m-d H:i:s');
        $payment->save();

        return view('frontend.payments.member', compact('payment'));
    }
}
