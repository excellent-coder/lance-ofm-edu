<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\PublicationPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicationPurchaseController extends Controller
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
        $purchase = new PublicationPurchase();
        $purchase->member_id = auth('mem')->id();

        $member = auth('mem')->user();

        $purchase->publication_id = $pub->id;
        $purchase->amount = $pub->price;
        $purchase->currency = web_setting('general', 'currency', 'NGN');

        do {
            $ref = "PUB-" . Str::upper(Str::random(16));
        } while (PublicationPurchase::whereRef($ref)->first());

        $purchase->ref = $ref;

        $mac = exec('getmac');
        $purchase->mac = strtok($mac, ' ');
        $purchase->ip = $request->ip();
        $purchase->reason = "Purchase of $pub->title";

        $purchase->save();

        $p = [
            'public_key' => config('services.rave.public_key'),
            'ref' => $ref,
            'amount' => $purchase->amount,
            'currency' => $purchase->currency,
            'country' => config('msc.country', 'NG'),
            'redirect' => route('mem.pubs.paid', $purchase->id),
            'meta' => ['consumer_id' => auth('mem')->id(), 'consumer_mac' => $mac],
            'customer' => [
                'email' => $member->email,
                'phone_number' => $member->phone,
                'reason' => $purchase->reason,
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






    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PublicationPurchase  $publicationPurchase
     * @return \Illuminate\Http\Response
     */
    public function show(PublicationPurchase $purchase, Publication $pub)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PublicationPurchase  $publicationPurchase
     * @return \Illuminate\Http\Response
     */
    public function edit(PublicationPurchase $publicationPurchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PublicationPurchase  $publicationPurchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PublicationPurchase $publicationPurchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PublicationPurchase  $publicationPurchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(PublicationPurchase $publicationPurchase)
    {
        //
    }
}
