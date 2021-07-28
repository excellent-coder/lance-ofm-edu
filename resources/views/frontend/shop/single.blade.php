@extends('layouts.shop')

@section('content')
<x-shop-breadcrumb :section="'product'" :id="$product->id"></x-shop-breadcrumb>
<div class="flex flex-wrap justify-between w-full mt-4">
    <div class="flex w-4/5 bg-white">
        <div class="flex flex-col gallery lg:w-2/5">
            <div class="w-full h-96">
                <div id="splide" class="w-full h-full splide">
                    <div class="w-full h-full splide__track">
                        <ul class="h-full text-2xl text-white splide__list">
                            @foreach ($product->images as $img)
                            <li class="h-full bg-green-500 splide__slide">
                                <img class="w-full h-full " src="/storage/{{$img->image}}" alt="{{$product->title}}">
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap justify-center w-full">
                @foreach ($product->images as $img)
                <img @click="fullImage('/storage/{{$img->image}}')" class="mx-1 cursor-pointer" src="/storage/{{$img->image}}" alt="{{$product->title}}" height="40"
                    width="40">
                @endforeach
            </div>
        </div>
        <div class="w-3/5 px-3">
            <h1 class="text-2xl font-bold text-black ">
                {{Str::title($product->title)}}
            </h1>
            <span>
                <i class="text-xs text-yellow-500 fa fa-star" aria-hidden="true"></i>
                <i class="text-xs text-yellow-500 fa fa-star" aria-hidden="true"></i>
                <i class="text-xs text-yellow-500 fa fa-star" aria-hidden="true"></i>
                <i class="text-xs text-yellow-500 fa fa-star" aria-hidden="true"></i>
                <i class="text-xs text-yellow-500 fa fa-star" aria-hidden="true"></i>
                <span class="text-xs"><a href="#ratings">(20 ratings)</a> </span>
            </span>
            <h2 class="text-2xl font-bold arial">{{$product->f_price}}</h2>
            @if ($product->discount)
            <h5>
                <del class="text-lg opacity-80">{{$product->f_h_price}}</del>
                <span class="p-1 ml-1 text-sm text-red-700 bg-yellow-200 bg-opacity-75">
                    -{{$product->discount}}%</span>
            </h5>
            @endif
            <button
                class="relative block w-full h-10 text-center text-white transition-all bg-yellow-500 hover:bg-yellow-600">
                <i class="absolute fas fa-cart-plus left-3 top-3"></i>
                ADD TO CART
            </button>
        </div>
    </div>
    <div class="w-1/6 px-2 bg-green-300">
        <h2>Delivery Options</h2>
        <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Minus, suscipit maiores iure alias, reiciendis labore
            voluptates ut quisquam impedit molestiae
            ea neque quidem aliquid odit nulla blanditiis dolor,
            nobis delectus!
        </p>
    </div>
</div>
@endsection
@section('js')
<script>
    new Splide("#splide", {
        type: "loop",
        perPage: 1,
        autoplay: true,
        pauseOnHover: false,
    }).mount();

</script>
@endsection
