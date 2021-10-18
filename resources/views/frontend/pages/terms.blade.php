@extends('layouts.app')
@section('css')

@endsection

@section('content')
<div class="flex flex-wrap w-full mb-4">
    <div class="relative w-full bg-center bg-no-repeat bg-cover h-72"
        style="background-image: url(/storage/pages/awards-banner.jpg)">
        <div class="absolute w-full bottom-1/4">
            <h1 class="text-4xl font-black text-center text-gray-100 top-20">
                Terms of service
            </h1>
        </div>
    </div>
    <div class="w-full bg-gray-100">
        <div class="container text-center">
            <h1>Do you have suggestions or questions for ISAM?</h1>
            <p class="text-lg text-gray-700 " style="line-height: 1.5;">
                Fill out the form below or give us a call. Thank you!<br>

                Office Address: 50 Olowu Street, Ikeja, Lagos, Nigeria<br>

                Office phone: +234-806-567-43, 08065674312<br>
                Email: isam.org.ng@gmail.com, info@isam.org.ng
            </p>
        </div>
    </div>
</div>
@endsection

@section('js')

@endsection
