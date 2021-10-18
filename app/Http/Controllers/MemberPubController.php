<?php

namespace App\Http\Controllers;

use App\Models\MemberPayment;
use App\Models\MemberPub;
use Illuminate\Http\Request;
use App\Models\Publication;
use Illuminate\Support\Str;

class MemberPubController extends Controller
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
    public function store(Request $request, Publication $pub)
    {
        $payment = new MemberPayment();
        $payment->member_id = auth('mem')->id();

        $member = auth('mem')->user();

        $payment->amount = $pub->price;
        $payment->currency = web_setting('general', 'currency', 'NGN');

        do {
            $ref = "PUB-" . Str::upper(Str::random(16));
        } while (MemberPayment::whereRef($ref)->first());

        $payment->ref = $ref;

        $mac = exec('getmac');
        $payment->mac = strtok($mac, ' ');
        $payment->ip = $request->ip();
        $payment->reason = "Purchase of $pub->title";
        $payment->tag = 'publications';
        $payment->item = 'publications';
        $payment->item_id = $pub->id;

        $payment->save();

        $p = [
            'public_key' => config('services.rave.public_key'),
            'ref' => $ref,
            'amount' => $payment->amount,
            'currency' => $payment->currency,
            'country' => config('msc.country', 'NG'),
            'redirect' => route('mem.pubs.paid', $payment->id),
            'meta' => ['consumer_id' => auth('mem')->id(), 'consumer_mac' => $mac],
            'customer' => [
                'email' => $member->email,
                'phone_number' => $member->phone,
                'reason' => $payment->reason,
                'user_id' => $member->id,
                'name' => $member->name,
            ],
            'customization' => [
                'title' => "Purchase $pub->title",
                'description' => "Purchase $pub->title",
                'logo' => asset('storage/' . web_setting('general', 'logo', 'web/logo.png'))
            ],
        ];

        return [
            'message' => "Stay On the page to make Your payment",
            'desc' => "Make payment to download this $pub->title",
            'type' => 'success',
            'status' => 200,
            'payment' => $p,
            // 'to' => '/scs'
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
        $payment->save();

        if ($payment->status == 'successful') {
            // add new member pub
            $mp = new MemberPub();
            $mp->member_id = auth('mem')->id();
            $mp->publication_id = $payment->item_id;
            $mp->payment_id = $payment->id;
            $mp->save();


            $request->session()->flash('paid.next_title', 'DOWNLOAD NOW  <i class="fas fa-download "></i>');
            $request->session()->flash('paid.next', route('mem.pubs.paid-download', $mp->id));
        }

        return view('frontend.payments.member', compact('payment'));
    }

    public function download(MemberPub $mpub)
    {
        // return $mpub;
        if ($mpub->member_id !== auth('mem')->id()) {
            return view('errors.419');
        }
        $pub = $mpub->publication;
        // return $pub;
        $name = Str::upper($pub->slug . '-' . time()) . '.' . pathinfo($pub->docs, PATHINFO_EXTENSION);
        return response()->download(public_path("storage/$pub->docs"), $name);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MemberPub  $memberPub
     * @return \Illuminate\Http\Response
     */
    public function show(MemberPub $memberPub)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MemberPub  $memberPub
     * @return \Illuminate\Http\Response
     */
    public function edit(MemberPub $memberPub)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MemberPub  $memberPub
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MemberPub $memberPub)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MemberPub  $memberPub
     * @return \Illuminate\Http\Response
     */
    public function destroy(MemberPub $memberPub)
    {
        //
    }
}
