@extends('layouts.shop')
@section('content')
<div class="w-full">
    {{-- <div class="container shop-banner h-96">
        <div id="splide" class="w-full h-full splide">
            <div class="w-full h-full splide__track">
                <ul class="h-full text-2xl text-white splide__list">
                    <li class="h-full bg-green-500 splide__slide">
                        <h1>Something god to be here</h1>
                    </li>
                    <li class="h-full bg-pink-600 splide__slide">
                        <h1>Something god to be here</h1>
                    </li>
                    <li class="h-full bg-red-600 splide__slide">
                        <h1>Something god to be here</h1>
                    </li>
                    <li class="h-full bg-yellow-400 splide__slide">
                        <h1>Something god to be here</h1>
                    </li>
                    <li class="h-full bg-indigo-700 splide__slide">
                        <h1>Something god to be here</h1>
                    </li>
                </ul>
            </div>
        </div>
    </div> --}}
    <div class="grid w-full grid-cols-2 gap-2 my-5 lg:grid-cols-5 lg:gap-4 md:gap-3 md:grid-cols-4">
        @foreach ($products as $p )
        <product-tag
            product="{{$p}}"
            preloader="/storage/{{$msc->preloader}}"
            ></product-tag>
        @endforeach

    </div>
</div>
@endsection
