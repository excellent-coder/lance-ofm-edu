@extends('layouts.pgs')

@section('css')

@endsection

@section('content')
<div class="flex justify-center w-full h-full">
    <div class="h-auto w-96">
        <p>You are successfully promoted to level {{$level->name}}</p>
        <p>Click the button below to make payment of {{$fee->currency}} {{$fee->amount}}
            for Tution for {{activeSession()->name}} academic session
        </p>
        <p>
            <button
               class="w-32 px-4 py-3 mt-6 antialiased font-semibold text-center text-white transition-all bg-indigo-700 border-2 border-yellow-400 rounded-lg shadow-xl hover:bg-yellow-500 hover:border-indigo-400"
                data-to="{{route('pgs.fee.pay', $fee->id)}}"
                @click.prevent="tuitionFee($event, {{activeSession()}}, {{ $level }}, {{ $fee }})">
                    Pay Now
            </button>
        </p>
    </div>
</div>
@endsection
