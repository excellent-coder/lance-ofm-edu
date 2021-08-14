@extends('layouts.app')
@section('content')
<div class="w-full">
    @include('includes.home.slides')
    @include('includes.home.about')

    <div class="container">
        <div class="flex flex-wrap justify-between w-full home lg:flex-nowrap">
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
        <div class="flex flex-wrap w-full lg:h-screen h-96">
            <div class="w-1/2 bg-gray-500 h-1/2">
                <h1>Mission</h1>
            </div>
            <div class="w-1/2 bg-blue-900 h-1/2">
                <h1>Vision</h1>
            </div>
            <div class="w-1/3 bg-red-700 h-1/2">
                <h1>Aims & Objectives</h1>
            </div>
            <div class="w-1/3 bg-green-500 h-1/2">
                <h1>Core Value</h1>
            </div>
            <div class="w-1/3 bg-pink-400 h-1/2">
                <h1>Online Experience</h1>
            </div>
        </div>
        {{-- news --}}
        <div class="flex w-full lg:h-screen h-1/2">
            <div class="w-1/2 h-full bg-gray-200">
                <h1 class="text-center ">LATEST NEWS</h1>
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
