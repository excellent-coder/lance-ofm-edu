@extends('layouts.auth')
@section('content')
<div class="container mt-8 ">
    <h1>
        Hey, {{$member->name}}
        <br>
        click the button below to make payment
    </h1>
    <div class="flex flex-wrap justify-center">
        <table style="border: 2px solid black; padding:10px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="
                    border: 2px solid black;
                    padding:10px;
                    background-color: #601edb;
                    color: white;">Item</th>
                    <th style=" border: 2px solid black;
                    padding:10px;
                    background-color: #601edb;
                    color: white;">Price</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <th style="border: 2px solid black; padding: 5px;">
                    Acceptance Fee
                    </th>
                    <td style="border: 2px solid black; padding: 5px;">
                        {{$total = number_format($member->membership->application_fee, 2) }}
                    </td>
                </tr>

                <tr>
                    <th style="border: 2px solid black; padding: 5px;">
                        Total
                    </th>
                    <td style="border: 2px solid black; padding: 5px;">
                    <b>
                        {{$currency}} {{$total}} </b>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="w-full mt-5 text-center">
            <form action="{{route('payment.mem.induction', $member->id)}}" method="post" @submit.prevent="submit($event)">
        <button type="submit"
            class="w-32 px-4 py-3 antialiased font-semibold text-center text-white transition-all bg-indigo-900 border-2 border-gray-100 rounded-lg shadow-xl hover:bg-yellow-500">
            Pay
        </button>
            </form>
        </div>
    </div>
</div>
@endsection
