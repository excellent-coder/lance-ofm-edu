@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="capitalize font-semibold text-2xl md:text-4xl">
        fair home bid... the quick and fair way for buyers to win their dream home
    </h1>
    <div class=" text-center">
        <p>
            select an auction and see what others are offering and put your OWN Bid
        </p>
        <p>
            You will know the outcome <u>immediately</u> With no wonders or secnd guessing...
            Invest 30 minutes not Days!
        </p>
    </div>

    <div class="flex w-full flex-wrap mt-4 mb-8 content-center gap-y-2">
        @foreach ($auctions as $a)
        <div class="w-1/2 md:w-1/3 lg:w-1/4 h-56">
            <div class="px-1 w-full h-52">
                <a href="{{route('auction.show', $a->slug)}}" class="w-full h-full block">
                    <img class="w-full h-3/4" src="/storage/{{$a->image}}" alt="{{$a->title}}">
                    <div class=" w-full h-1/3">
                        <div class=" w-full h-full">
                            <h3 class="text-pink-600 text-left">{{$a->title}}</h3>
                            <h3 class=" text-green-800 text-left font-black">
                                <b>min bid:</b> ${{number_format($a->min_bid)}}
                            </h3>
                        </div>
                    </div>
                </a>
                <a href="{{route('offer.create', $a->slug)}}">
                    Request To Bid
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
