<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventGoer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Payment;
use App\Mail\EventGoer as EventMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;




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
        return $request->all();
        $valid = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required'
            ]
        );
        if ($valid->fails()) {
            return [
                'message' => 'Some required fields missing',
                'errors' => $valid->errors()->all()
            ];
        }
        if (EventGoer::whereEmail($request->email)->whereEventId($event->id)->first()) {
            return [
                'message' => 'You have already registered for this event',
                'type' => 'info',
                'status' => 200,
            ];
        }
        $eg = new EventGoer();
        $eg->event_id = $event->id;
        $eg->name = $request->name;
        $eg->phone = $request->phone;
        $eg->email = $request->email;

        $guards = ['scs' => "s_c_students", 'pgs' => 'students', 'mem' => 'members'];
        foreach ($guards as $guard => $v) {
            if ($id = auth($guard)->id()) {
                $eg->goer_id = $id;
                $eg->goer = $v;
            } else {
                $eg->goer = 'Guest';
            }
        }


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

        $payment = new Payment();
        $payment->user_id = $eg->id;
        $payment->guard = 'event_goers';

        $payment->amount = $amount;
        $payment->currency =  web_setting('general', 'currency');
        $payment->reason = "Register for $event->title Event";
        do {
            $ref = "ISAM-$code-" . Str::upper(Str::random(10));
        } while (Payment::where('ref', $ref)->first());

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
            'redirect' => route('payment.paid', $payment->id),
            'meta' => [
                'consumer_id' => $eg->id,
                'consumer_mac' => $mac,
                'customer_table' => 'event_goers',
            ],
            'customer' => [
                'email' => $request->email,
                'phone_number' => $request->phone,
                'reason' => $payment->reason,
                'user_id' => $eg->id,
                'name' => "$request->name",
            ],
            'customization' => [
                'title' => "payment for $event->title",
                'description' => Str::limit(strip_tags($event->description)),
                'logo' => asset('storage/' . web_setting('general', 'logo', 'web/logo.png'))
            ],
        ];

        $eg->payment_id = $payment->id;
        $eg->save();

        Mail::to($eg->email, $eg->name)->send(new EventMail($eg, $event));

        return [
            'status' => 200,
            'message' => 'Your application has been submitted successfully',
            'desc' => 'You will be contacted via email',
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
