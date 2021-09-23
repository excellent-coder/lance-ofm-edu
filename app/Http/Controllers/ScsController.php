<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Scs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\ScsPayment;
use App\Models\ScsProgram;

class ScsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Scs::all();
        return view('admin.pages.scs.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $programs = Program::whereActive(1)
            ->whereIsProgram(1)
            ->where('visibility', '!=', 2)
            ->get();

        return view('apply.scs', compact('programs'));
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
                'email' => 'required|unique:scs,email',
                'first_name' => 'required',
                'last_name' => 'required',
                // 'passport' => 'required|file|image|max:20480',
                'dob' => 'required',
                'terms' => 'required',
                'phone' => 'required',
                'password' => 'required|min:8|max:16',
            ],
            [
                'terms.required' => 'You must agree to our terms',
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some Errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $s = new Scs();

        $s->email = $request->email;

        $s->first_name = $request->first_name;
        $s->last_name = $request->last_name;
        $s->middle_name = $request->middle_name;

        $s->name = "$s->last_name $s->firts_name $s->middle_name";

        $s->phone = $request->phone;
        $s->dob = $request->dob;

        $program = Program::findOrFail($request->program);
        $s->password = bcrypt($request->password);

        if ($request->hasFile('passport')) {
            $passport = $request->file('passport');
            if ($passport->isValid()) {
                $name =  Str::slug("$request->first_name") . "-" . time()
                    . '.' . $passport->getClientOriginalExtension();
                $s->passport = $passport->storeAs('scs/passports', $name);
            }
        }

        $s->save();

        $sp = new ScsProgram();
        $sp->scs_id = $s->id;
        $sp->program_id = $program->id;
        $sp->save();

        $amount = (int) $program->scs_app_fee;

        $payment = new ScsPayment();
        $payment->scs_id = $s->id;
        $payment->amount = $program->scs_app_fee;
        $payment->currency =  web_setting('general', 'currency');
        $payment->reason = "Application For Short Course Studies to study $program->title";
        $payment->scs_program_id = $sp->id;

        do {
            $ref = 'ISAM-REG-SCS-' . Str::upper(Str::random(10));
        } while (ScsPayment::where('ref', $ref)->first());

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
            'redirect' => route('scs.paid', $payment->id),
            'meta' => ['consumer_id' => $s->id, 'consumer_mac' => $mac],
            'customer' => [
                'email' => $request->email,
                'phone_number' => $request->phone,
                'reason' => $payment->reason,
                'user_id' => $s->id,
                'name' => "$request->last_name $request->first_name",
            ],
            'customization' => [
                'title' => web_setting('scs', 'payment_title', 'Title'),
                'description' => web_setting('scs', 'payment_desc', 'Description'),
                'logo' => asset('storage/' . web_setting('general', 'logo', 'web/logo.png'))
            ],
        ];

        $message = "First Step completed";
        $desc = 'Make payment to complete your registration';
        $to = false;
        if ($amount < 1) {
            $p = false;
            $payment->status = 'successful';
            $payment->save();

            $sp->payment_id = $payment->id;
            $sp->save();

            $message = 'You will be redirected shortly';
            $desc = 'You have successfully registered';
            $to = '/scs';
        }

        auth('scs')->login($s);
        return [
            'message' => $message,
            'desc' => $desc,
            'type' => 'success',
            'status' => 200,
            'payment' => $p,
            'to' => $to
        ];
    }

    public function dashboard()
    {
        // return auth('scs')->user()->programs;
        return view('frontend.scs.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Scs  $scs
     * @return \Illuminate\Http\Response
     */
    public function show(Scs $scs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Scs  $scs
     * @return \Illuminate\Http\Response
     */
    public function edit(Scs $scs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Scs  $scs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Scs $scs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Scs  $scs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scs $scs)
    {
        //
    }
}
