<?php

namespace App\Http\Controllers;

use App\Models\LicensePayment;
use Illuminate\Http\Request;
use App\Models\Licence;
use Illuminate\Support\Str;

class LicensePaymentController extends Controller
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
    public function create($slug)
    {
        $license = Licence::where('slug', $slug)->firstOrFail();
        return view('frontend.mem.licenses.purchase', compact('license'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Licence $licence)
    {
        $auth = auth('mem')->user();

        $payment = new LicensePayment();
        $payment->member_id = auth('mem')->id();
        $payment->amount = $licence->fee;
        $payment->currency =  web_setting('general', 'currency');
        $payment->reason = "$licence->name membership License purchase";
        $payment->licence_id = $licence->id;
        $payment->duration = $licence->duration;

        do {
            $ref = 'ISAM-LIC-' . Str::upper(Str::random(10));
        } while (LicensePayment::where('ref', $ref)->first());

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
            'redirect' => route('license.paid', $payment->id),
            'meta' => ['consumer_id' => $auth->id, 'consumer_mac' => $mac],
            'customer' => [
                'email' => $auth->email,
                'phone_number' => $auth->phone,
                'reason' => $payment->reason,
                'user_id' => $auth->id,
                'name' => "$auth->last_name $auth->first_name",
            ],
            'customization' => [
                'title' => "purchase $licence->name license",
                'description' => Str::limit($licence->excerpt, 200, '...'),
                'logo' => asset('storage/' . web_setting('general', 'logo', 'web/logo.png'))
            ],
        ];

        return [
            'message' => "First Step completed",
            'desc' => 'Make payment to complete your purchase',
            'type' => 'success',
            'status' => 200,
            'payment' => $p,
            // 'to' => '/scs'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LicensePayment  $licensePayment
     * @return \Illuminate\Http\Response
     */
    public function show(LicensePayment $licensePayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LicensePayment  $licensePayment
     * @return \Illuminate\Http\Response
     */
    public function edit(LicensePayment $licensePayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LicensePayment  $licensePayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LicensePayment $licensePayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LicensePayment  $licensePayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(LicensePayment $licensePayment)
    {
        //
    }

    public function paid(Request $request, LicensePayment $payment)
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
