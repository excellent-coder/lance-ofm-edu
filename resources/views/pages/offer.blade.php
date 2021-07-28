@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('vendor/splide/css/splide.min.css')}}">
@endsection
@section('content')
<div class="container my-4">
    <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="hidden md:block">
            <div id="splide" class="splide pr-4">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($auctions as $a)
                        <li class="splide__slide">
                            <div class="flex w-full flex-wrap h-96">
                                <a title="send offer" class="w-full" style="height: 80%"  class="" href="{{route('offer.create', $a->slug)}}">
                                <img class=" w-full h-full" src="/storage/{{$a->image}}" alt="{{$a->title}}">
                                </a>
                                <p class="text-lg text-red-500 font-bold flex flex-wrap w-full justify-between" style="height: 20%">
                                   <span class="w-3/4 block">
                                       {{$a->title}}
                                   </span>
                                @auth
                                <a title="place bid" target="_blank" href="{{route('auction.show', $a->slug)}}" class=" block c-green text-lg w-1/4">
                                    Place Bid
                                </a>
                                @endauth
                                </p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div>
            <form action="{{route('offer.send')}}" method="post" @submit.prevent="submit($event)">
                <div class="mb-4">
                    <label class="text-gray-700 text-sm font-bold mb-2 required">
                        Username
                    </label>
                    <input class="
                        shadow
                        appearance-none
                        border
                        rounded
                        w-full
                        py-2
                        px-3
                        text-gray-700
                        leading-tight
                        focus:outline-none
                        focus:shadow-outline
                    " type="text" name="username" placeholder="Username" />
                </div>
                <div class="mb-4">
                    <label class="text-gray-700 text-sm font-bold mb-2 required">
                        Email
                    </label>
                    <input class="
                        shadow
                        appearance-none
                        border
                        rounded
                        w-full
                        py-2
                        px-3
                        text-gray-700
                        leading-tight
                        focus:outline-none
                        focus:shadow-outline
                    " type="email" name="email" placeholder="Email" />
                </div>
                <div class="mb-4">
                    <label class="text-gray-700 text-sm font-bold mb-2 required">
                        First Name
                    </label>
                    <input class="
                        shadow
                        appearance-none
                        border
                        rounded
                        w-full
                        py-2
                        px-3
                        text-gray-700
                        leading-tight
                        focus:outline-none
                        focus:shadow-outline
                    " type="text" name="first_name" placeholder="First Name" />
                </div>
                <div class="mb-4">
                    <label class="text-gray-700 text-sm font-bold mb-2 required">
                        Last Name
                    </label>
                    <input class="
                        shadow
                        appearance-none
                        border
                        rounded
                        w-full
                        py-2
                        px-3
                        text-gray-700
                        leading-tight
                        focus:outline-none
                        focus:shadow-outline
                    " type="text" name="last_name" placeholder="Last Name" />
                </div>
                <div class="mb-4">
                    <label class="text-gray-700 text-sm font-bold mb-2 required">
                        Phone
                    </label>
                    <input class="
                        shadow
                        appearance-none
                        border
                        rounded
                        w-full
                        py-2
                        px-3
                        text-gray-700
                        leading-tight
                        focus:outline-none
                        focus:shadow-outline
                    " type="tel" name="phone" placeholder="Email" />
                </div>
                @isset($auction)
                <input type="hidden" name="auction_id" value="{{$auction->id}}">
                <div class="mb-4">
                    <label class="text-gray-700 text-sm font-bold mb-2 required">
                        Auction
                    </label>
                    <input class="
                        shadow
                        appearance-none
                        border
                        rounded
                        w-full
                        py-2
                        px-3
                        text-gray-700
                        leading-tight
                        focus:outline-none
                        focus:shadow-outline
                    " type="text" readonly value="{{$auction->title}}" placeholder="Auction" />
                </div>
                <div class="mb-4">
                    <label class="text-gray-700 text-sm font-bold mb-2 required">
                        The amount you will bid when approved
                    </label>
                    <input class="
                        shadow
                        appearance-none
                        border
                        rounded
                        w-full
                        py-2
                        px-3
                        text-gray-700
                        leading-tight
                        focus:outline-none
                        focus:shadow-outline
                    " type="number" name="price" placeholder="offer amount" />
                </div>
                @endisset
                <div class="mb-4">
                    <label class="text-gray-700 text-sm font-bold mb-2" for="file">
                        Proof document
                    </label>
                    <input class="
                        shadow
                        appearance-none
                        border
                        rounded
                        w-full
                        py-2
                        px-3
                        text-gray-700
                        leading-tight
                        focus:outline-none
                        focus:shadow-outline
                    " id="file" type="file" name="file" placeholder="proof document" />
                </div>
                <div class="my-4 text-center">
                    <button type="submit" class="
                bg-blue-500
                hover:bg-blue-700
                focus:outline-none
                text-white
                font-bold
                p-4
                rounded-full block w-full uppercase">submit offer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('vendor/splide/js/splide.min.js')}}"></script>
<script>
    new Splide("#splide", {
            type: "loop",
            perPage: 1,
            autoplay: true,
            pauseOnHover: false,
        }).mount();
</script>
@endsection
