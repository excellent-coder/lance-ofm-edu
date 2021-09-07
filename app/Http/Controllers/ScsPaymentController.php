<?php

namespace App\Http\Controllers;

use App\Models\ScsPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScsPaymentController extends Controller
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

    public function paid(Request $request, ScsPayment $payment)
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
     * @param  \App\Models\ScsPayment  $scsPayment
     * @return \Illuminate\Http\Response
     */
    public function show(ScsPayment $payment)
    {
        return $payment->load('student');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ScsPayment  $scsPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(ScsPayment $scsPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ScsPayment  $scsPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ScsPayment $scsPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ScsPayment  $scsPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScsPayment $scsPayment)
    {
        //
    }
}
