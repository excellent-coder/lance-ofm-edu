@extends('layouts.app')
@section('css')

@endsection

@section('content')
<div class="flex flex-wrap w-full mb-4">
    <div class="relative w-full bg-center bg-no-repeat bg-cover h-52"
        style="background-image: url(/storage/pages/awards-banner.jpg)">
        <div class="absolute w-full bottom-1/4">
            <h1 class="text-4xl font-black text-center text-gray-100 uppercase top-20">
                {{$cat->name}} EVENTS
            </h1>
        </div>
    </div>
    <div class="w-full mt-20 mb-10 lg:mx-32">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 md:grid-cols-2">
            @foreach ($cat->events as $e)
            <div>
                <div class="w-full member-card">
                    <a class="block w-full" href="{{route('events.show', $e->slug)}}">
                        <img class="w-full h-56" src="/storage/{{$e->image}}" alt="{{$e->title}}">
                    </a>
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            {{$e->title}}
                        </h2>
                        <p>
                            {{Str::limit(strip_tags($e->description), 200, '...')}}
                        </p>
                    </div>
                    <div class="py-2 text-center border-green-600 border-r-1 border-b-1 border-l-1">
                        <a class="relative block p-3 text-white uppercase bg-transparent border-2 border-yellow-400 hover:text-black bg-scale-in"
                            href="{{route('events.register', $e->slug)}}">
                            <span class="relative z-10 ">
                                Register For This Event
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('js')

@endsection
