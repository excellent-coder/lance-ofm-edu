<?php

namespace App\Http\Controllers;

use App\Models\Licence;
use App\Models\MemberLicense;
use App\Models\MemberPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MemberLicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    public function all()
    {
        $licenses = Licence::all();
        return view('frontend.mem.licenses.index', compact('licenses'));
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
    public function store(Request $request, Licence $licence)
    {
        $member = auth('mem')->user();
        if (MemberLicense::where('member_id', $member->id)->where('licence_id', $licence->id)->first()) {
            return ['message' => "You have already purchase this License", 'status' => 200, 'type' => 'success'];
        }

        $payment = new MemberPayment();
        $payment->member_id = $member->id;
        $payment->amount = $licence->fee;
        $payment->currency =  web_setting('general', 'currency', 'NGN');
        $payment->reason = "$licence->name membership License purchase";
        $payment->item_id = $licence->id;
        $payment->item = 'licenses';
        $payment->tag = 'licenses';

        do {
            $ref = 'ISAM-LIC-' . Str::upper(Str::random(10));
        } while (MemberPayment::where('ref', $ref)->first());

        $payment->ref = $ref;
        $payment->ip = $request->ip();
        $mac = exec('getmac');
        $payment->mac = strtok($mac, ' ');
        $payment->save();

        $p = [
            'public_key' => config('services.rave.public_key'),
            'ref' => $ref,
            'amount' => $payment->amount,
            'currency' => $payment->currency,
            'country' => config('msc.country', 'NG'),
            'redirect' => route('mem.license.paid', $payment->id),
            'meta' => ['consumer_id' => $member->id, 'consumer_mac' => $mac],
            'customer' => [
                'email' => $member->email,
                'phone_number' => $member->phone,
                'reason' => $payment->reason,
                'user_id' => $member->id,
                'name' => $member->name,
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
            'payment' => $p
        ];
    }

    public function paid(Request $request, MemberPayment $payment)
    {
        // return $payment;
        if ($payment->transaction_id) {
            // this payment has been processes,
            // return redirect('/');
        }
        if ($request->tx_ref != $payment->ref) {
            // return redirect(404);
        }
        $payment->status = $request->status;
        $payment->transaction_id = $request->transaction_id;
        $payment->paid_at = date('Y-m-d H:i:s');
        // $payment->save();

        if ($payment->status == 'successful') {
            // add new member pevent
            $ml = new MemberLicense();
            $ml->member_id = $payment->member_id;
            $ml->licence_id = $payment->item_id;
            $ml->payment_id = $payment->id;
            $ml->duration = $payment->licence->duration;
            $ml->save();

            $request->session()->flash('paid.next_title', 'My License');
            $request->session()->flash('paid.next', route('mem.license.mine'));
        }

        return view('frontend.payments.member', compact('payment'));
    }

    public function mine()
    {
        $licenses = auth('mem')->user()->licences;
        // return $licenses;
        return view('frontend.mem.licenses.mine', compact('licenses'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MemberLicense  $memberLicense
     * @return \Illuminate\Http\Response
     */
    public function show(MemberLicense $memberLicense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MemberLicense  $memberLicense
     * @return \Illuminate\Http\Response
     */
    public function edit(MemberLicense $memberLicense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MemberLicense  $memberLicense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MemberLicense $memberLicense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MemberLicense  $memberLicense
     * @return \Illuminate\Http\Response
     */
    public function destroy(MemberLicense $memberLicense)
    {
        //
    }
}
