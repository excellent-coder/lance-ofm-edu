<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberEvent;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\MemberPayment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Exception;
use App\Mail\EventGoer as EventMail;



class MemberEventController extends Controller
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
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Event $event)
    {
        if (MemberEvent::where('event_id', $event->id)->where('member_id', auth('mem')->id())->first()) {
            return  [
                'message' => 'You have already registered for this event',
                'status' => 200,
                'type' => 'success'
            ];
        }

        $member = auth('mem')->user();

        $payment = new MemberPayment();
        $payment->member_id = $member->id;

        $payment->amount = $event->price;
        $payment->currency =  web_setting('general', 'currency', 'NGN');
        $payment->reason = "Register for $event->title Event";

        do {
            $ref = "EVENT-" . Str::upper(Str::random(10));
        } while (MemberPayment::where('ref', $ref)->first());

        $payment->ref = $ref;
        $payment->ip = $request->ip();
        $mac = exec('getmac');
        $payment->mac = strtok($mac, ' ');

        $payment->item = 'events';
        $payment->item_id = $event->id;

        $payment->save();

        if ((int) $payment->amount < 1) {
            // no payment needed
            try {
                Mail::send(new EventMail($member, $event));
            } catch (Exception $e) {
            }



            return [
                'status' => 200,
                'message' => 'You have successfully registered for this event',
                'desc' => 'You will be notified via email',
                'type' => 'info',
            ];
        }

        $p = [
            'public_key' => config('services.rave.public_key'),
            'ref' => $ref,
            'amount' => $payment->amount,
            'currency' => $payment->currency,
            'country' => config('msc.country', 'NG'),
            'redirect' => route('mem.event.paid', $payment->id),
            'meta' => [
                'consumer_id' => $member->id,
                'consumer_mac' => $mac,
            ],
            'customer' => [
                'email' => $member->email,
                'phone_number' => $member->phone,
                'reason' => $payment->reason,
                'member_id' => $member->id,
                'name' => "$member->name",
            ],
            'customization' => [
                'title' => "payment for $event->title",
                'description' => Str::limit(strip_tags($event->description)),
                'logo' => asset('storage/' . web_setting('general', 'logo', 'web/logo.png'))
            ],
        ];

        try {
            Mail::to($member->email, $member->name)->send(new EventMail($member, $event));
        } catch (Exception $e) {
            //    return $e->getMessage()
        }

        return [
            'status' => 200,
            'message' => 'You have successfully applied for this event',
            'desc' => "However you  need to pay $payment->currency $payment->amount bfore your application will be successful",
            'type' => 'success',
            'payment' => $p,
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
            $me = new MemberEvent();
            $me->member_id = auth('mem')->id();
            $me->event_id = $payment->item_id;
            $me->payment_id = $payment->id;
            $me->save();


            $request->session()->flash('paid.next_title', 'DASHBOARD');
            $request->session()->flash('paid.next', route('mem'));
        }

        return view('frontend.payments.member', compact('payment'));
    }

    public function events()
    {
        $intrests = auth('mem')->user()->events;
        // return $intrests;
        return view('frontend.mem.events.intrested', compact('intrests'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MemberEvent  $memberEvent
     * @return \Illuminate\Http\Response
     */
    public function show(MemberEvent $memberEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MemberEvent  $memberEvent
     * @return \Illuminate\Http\Response
     */
    public function edit(MemberEvent $memberEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MemberEvent  $memberEvent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MemberEvent $memberEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MemberEvent  $memberEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(MemberEvent $memberEvent)
    {
        //
    }
}
