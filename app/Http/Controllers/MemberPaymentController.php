<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberPayment;
use Illuminate\Http\Request;
use App\Models\MemberRequest;
use Illuminate\Support\Str;
use App\Models\Session;

class MemberPaymentController extends Controller
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


    public function induction(MemberRequest $member)
    {
        if (!$member->approved_at || $member->paidInduction) {
            return view('errors.404');
        }

        $member->name = "$member->first_name $member->last_name";
        return view('frontend.payments.mem.induction', compact('member'));
    }

    public function storeInduction(Request $request, MemberRequest $member)
    {

        $payment = new MemberPayment();
        $payment->member_request_id = $member->id;
        $payment->amount = $member->membership->application_fee;
        $payment->currency =  web_setting('general', 'currency');
        $payment->reason = "Acceptance fee";
        $payment->tag = 'acceptance';

        do {
            $ref = 'ISAM-REG-MEM-' . Str::upper(Str::random(10));
        } while (MemberPayment::where('ref', $ref)->first());

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
            'redirect' => route('mem.induction.paid', $payment->id),
            'meta' => ['consumer_id' => $member->id, 'consumer_mac' => $mac],
            'customer' => [
                'email' => $member->email,
                'phone_number' => $member->phone,
                'reason' => $payment->reason,
                'user_id' => $member->id,
                'name' => "$member->last_name $member->first_name",
            ],
            'customization' => [
                'title' => "Acceptance Fee Payment",
                'description' => "Acceptance Fee Payment",
                'logo' => asset('storage/' . web_setting('general', 'logo', 'web/logo.png'))
            ],
        ];

        return [
            'message' => "Stay On the page to make Your payment",
            'desc' => 'Make payment to complete your registration',
            'type' => 'success',
            'status' => 200,
            'payment' => $p,
            // 'to' => '/scs'
        ];
    }


    public function paidInduction(Request $request, MemberPayment $payment)
    {
        // return $payment->MemberRequest;
        if ($payment->transaction_id) {
            // this payment has been processes,
            // return redirect('/');
        }
        if ($request->tx_ref != $payment->ref) {
            // something is wrong we will come to you later
        }
        $payment->status = $request->status;
        $payment->transaction_id = $request->transaction_id;
        $payment->paid_at = date('Y-m-d H:i:s');
        $payment->save();

        if ($payment->status == 'successful') {
            $member = $payment->MemberRequest;
            // return $member;
            // create a new member
            $s = new Member();
            $s->member_request_id = $member->id;
            $s->name = "$member->last_name $member->first_name $member->middle_name";
            $s->email = $member->email;
            $s->phone = $member->phone;
            $s->membership_id = $member->membership_id;
            $s->passport = $member->passport;
            $session = Session::whereActive(1)->first();
            $year = $session->year ?? date('Y');
            $next = (int) Member::where('membership_id', $member->membership_id)
                ->count() + 1;


            $len = strlen($next);
            if ($len < 4) {
                do {
                    $next = "0" . $next;
                    $len = strlen($next);
                } while ($len < 4);
            }
            $code = $member->membership->code;
            $s->member_id = "MEM/$year/$code/$next";
            $s->save();

            // assign payment to member
            $payment->member_id = $s->id;
            $payment->save();

            $request->session()->flash('paid.next_title', 'Choose Password');
            $request->session()->flash('paid.next', route('mem.add-password', $s->id));
        }

        return view('frontend.payments.member', compact('payment'));
    }

    public function paid(Request $request, MemberPayment $payment)
    {
        return $payment;
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

    public function test(MemberRequest $member)
    {
        // return $member;
        $ap = $member;
        return view('emails.student.approve', compact('student'));
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
     * @param  \App\Models\MemberPayment  $memberPayment
     * @return \Illuminate\Http\Response
     */
    public function show(MemberPayment $memberPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MemberPayment  $memberPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(MemberPayment $memberPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MemberPayment  $memberPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MemberPayment $memberPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MemberPayment  $memberPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(MemberPayment $memberPayment)
    {
        //
    }
}
