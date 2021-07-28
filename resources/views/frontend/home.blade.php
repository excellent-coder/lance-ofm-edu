@extends('layouts.app')
@section('content')
<div class="w-full">
    <div class="home-medai">
        {{-- if(vide) --}}
        {{-- <video class="home-bg-video" src="{{asset('storage/web/home-bg.webm')}}" autoplay="autoplay"></video> --}}
        {{-- if(image) --}}
        <img src="{{asset('storage/web/DSC_0805.JPG')}}" class="home-bg-video">
        <h1>Home media title</h1>
    </div>
    <div>
        {{-- motto --}}
        <h1 class="text-3xl">school motto</h1>
        <div>
            <p>motto description</p>
        </div>
    </div>
    <div class="container">
        <div class="w-full flex home flex-wrap lg:flex-nowrap justify-between">
            <div class="card-circle">
                <div>
                    news
                </div>
            </div>
            <div class="card-circle">
                <div>
                    gallery
                </div>
            </div>
            <div class="card-circle">
                <div>
                    board of directors
                </div>
            </div>
            <div class="card-circle">
                <div>
                    Events
                </div>
            </div>
        </div>
    </div>
    <div class="w-full">
        <div class="flex w-full lg:h-screen h-96 flex-wrap">
            <div class="w-1/2 bg-gray-500 h-1/2">
                <h1>Mission</h1>
            </div>
            <div class="w-1/2 bg-blue-900 h-1/2">
                <h1>Vision</h1>
            </div>
            <div class="w-1/3 h-1/2 bg-red-700">
                <h1>Aims & Objectives</h1>
            </div>
            <div class="w-1/3 h-1/2 bg-green-500">
                <h1>Core Value</h1>
            </div>
            <div class="w-1/3 h-1/2 bg-pink-400">
                <h1>Online Experience</h1>
            </div>
        </div>
        {{-- news --}}
        <div class=" flex w-full lg:h-screen h-1/2">
        <div class="w-1/2 h-full bg-gray-200">
        <h1 class=" text-center">LATEST NEWS</h1>
            {{-- latest news --}}

            <a href="/all-news">
            view all news
        <i class="fa fa-chevron-right" aria-hidden="true"></i>
        <i class="fa fa-chevron-right" aria-hidden="true"></i>
        <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </a>
        </div>
        <div class="w-1/2 h-full bg-red-300">
        {{-- important featured news --}}

        </div>

        </div>
    </div>
    <div>

    </div>
</div>

@endsection
