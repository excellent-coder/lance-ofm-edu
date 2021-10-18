@extends('layouts.mem')
@section('content')
<div class="dashboard">
    <div class="container ">
        <h1 class="m-4 text-center ">Up comming Events</h1>
        <div class="grid grid-cols-1 gap-8 mt-8 lg:grid-cols-4 xl:grid-cols-5 md:grid-cols-3">
            @foreach ($intrests as $event)
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-32" src="/storage/{{$event->image}}" alt="{{$event->title}}">
                    <div class="p-1 border-green-600 border-1">
                        <h2 class="text-xl uppercase title">
                            {{$event->title}}
                        </h2>
                        <p>
                            {{ Str::limit(strip_tags($event->description), 200) }}
                        </p>
                        <p class="text-xl font-black text-left text-red-700 ">
                            @if ($event->price)
                            <span>{{$currency}} {{$event->price}} </span>
                            @else
                            <span>Free</span>
                            @endif
                        </p>
                        <p class="text-sm font-black text-left text-red-700 over ">
                            <i class="mr-1 fas fa-map-marker-alt"></i>
                             <span>{{$event->address}}</span>
                        </p>
                    </div>
                    <div class="flex justify-between h-8 border-green-600 border-r-1 border-b-1 border-l-1">
                        <a href="{{route('events.show', $event->slug)}}" target="blank">
                            Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
