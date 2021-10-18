@extends('layouts.shop')
@section('content')
<div class="w-full">
    <div class="w-full h-96">
        <carousel-slide id="carousel" style="height:100%;">
            <div class="bg-black slider-item" role="option">
                <div class="flex flex-col justify-center px-5 text-center slider-caption md:px-10 lg:px-20">
                    <h1 class="w-full mb-3 text-2xl font-semibold text-right text-white lg:text-6xl md:text-3xl">
                        <span class="text-yellow-500 ">
                            Institute Of School
                        </span>
                        <span>
                            Administration
                            <br>
                            And Management
                        </span>
                    </h1>
                    <p class="text-base font-semibold text-right text-white lg:text-2xl md:text-xl">
                        institute of School Administration and Management is a
                        professional and examining
                        body registered by <br> Federal Government CAMA of 2021.
                    </p>
                    <div class="flex flex-wrap justify-center w-full mt-4 lg:justify-end">
                        <a href="contact"
                            class="p-2 mr-3 text-xl font-semibold text-gray-900 transition-all bg-yellow-500 border-2 border-white hover:text-yellow-500 hover:bg-white">
                            CONTACT US
                        </a>
                        <a href="contact"
                            class="p-2 text-xl font-semibold text-gray-900 transition-all bg-yellow-500 border-2 border-white hover:text-yellow-500 hover:bg-white">
                            READ MORE
                        </a>
                    </div>
                </div>
            </div>
        </carousel-slide>
    </div>
    <div class="grid w-full grid-cols-2 gap-2 my-5 lg:grid-cols-5 lg:gap-4 md:gap-3 md:grid-cols-4">
        @foreach ($products as $p )
        <product-tag product="{{$p}}" preloader="/storage/{{$msc->preloader}}"></product-tag>
        @endforeach

    </div>
</div>
@endsection
