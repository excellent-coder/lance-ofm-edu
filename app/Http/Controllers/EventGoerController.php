<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventGoer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Payment;
use App\Mail\EventGoer as EventMail;
use App\Models\MemberPayment;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\TryCatch;

class EventGoerController extends Controller
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
    public function store(Request $request, Event $event)
    {
        // return $request->all();
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);

        if (EventGoer::whereEmail($request->email)->whereEventId($event->id)->first()) {
            return [
                'message' => 'You have already registered for this event',
                'type' => 'info',
                'status' => 200,
            ];
        }

        $member = auth('mem')->user();

        $eg = new EventGoer();
        $eg->event_id = $event->id;
        $eg->member_id = $member->id;

        $eg->name = $request->name;
        $eg->phone = $request->phone;
        $eg->email = $request->email;
        $eg->save();

        $amount = $event->price;
        $code = 'EVENT';


        if ((int) $amount < 1) {
            // no payment needed
            Mail::send(new EventMail($eg, $event));

            return [
                'status' => 200,
                'message' => 'You have successfully registered for this event',
                'desc' => 'You will be notified via email',
                'type' => 'info',
            ];
        }

        $payment = new MemberPayment();
        $payment->member_id = $member->id;

        $payment->amount = $event->price;
        $payment->currency =  web_setting('general', 'currency', 'NGN');
        $payment->reason = "Register for $event->title Event";

        do {
            $ref = "ISAM-$code-" . Str::upper(Str::random(10));
        } while (MemberPayment::where('ref', $ref)->first());

        $payment->ref = $ref;
        $payment->ip = $request->ip();
        $mac = exec('getmac');
        $payment->mac = strtok($mac, ' ');

        $payment->item = 'events';
        $payment->item_id = $event->id;

        $payment->save();

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
                'email' => $request->email,
                'phone_number' => $request->phone,
                'reason' => $payment->reason,
                'member_id' => $member->id,
                'name' => "$request->name",
            ],
            'customization' => [
                'title' => "payment for $event->title",
                'description' => Str::limit(strip_tags($event->description)),
                'logo' => asset('storage/' . web_setting('general', 'logo', 'web/logo.png'))
            ],
        ];

        try {
            Mail::to($eg->email, $eg->name)->send(new EventMail($eg, $event));
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventGoer  $eventGoer
     * @return \Illuminate\Http\Response
     */
    public function show(EventGoer $eventGoer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EventGoer  $eventGoer
     * @return \Illuminate\Http\Response
     */
    public function edit(EventGoer $eventGoer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventGoer  $eventGoer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventGoer $eventGoer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventGoer  $eventGoer
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventGoer $eventGoer)
    {
        //
    }
}
