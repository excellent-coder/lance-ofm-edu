@extends('layouts.mem')
@section('content')
<div class="dashboard">
    <div class="container ">
        <div class="grid grid-cols-2 gap-8 mt-8 lg:grid-cols-4 xl:grid-cols-5 md:grid-cols-3">
            @foreach ($pubs as $l)
            <div>
                <div class="w-full member-card h-96">
                    <img class="w-full h-32" src="/storage/{{$l->image}}" alt="{{$l->title}}">
                    <div class="h-56 px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl uppercase title">
                            {{$l->title}}
                        </h2>
                        <p>
                            {{ Str::limit(strip_tags($l->description), 200) }}
                        </p>
                        <p class="text-xl font-black text-left text-red-700 ">
                            @if ($l->price)
                            <span>{{$currency}} {{$l->price}} </span>
                              @if ( array_key_exists($l->id, $memPubs))
                                 <a title="You have paid for this publication" href="{{route('mem.pubs.paid-download', $memPubs[$l->id])}}" class="ml-4 " target="_blank" rel="noopener noreferrer">
                                    <i class="fas fa-download "></i>
                                </a>
                            @endif

                            @else
                            <span>Free</span>
                            <a href="{{route('mem.pubs.download', $l->id)}}" class="ml-4 " target="_blank"
                                rel="noopener noreferrer">
                                <i class="fas fa-download "></i>
                            </a>
                            @endif
                        </p>
                    </div>
                    <div class="flex justify-between h-8 border-green-600 border-r-1 border-b-1 border-l-1">
                        @if ($l->price)
                        @if (array_key_exists($l->id, $memPubs))
                            <a href="{{route('mem.pubs.paid-download', $memPubs[$l->id])}}" class="ml-4 " target="_blank" rel="noopener noreferrer">
                                <i class="fas fa-download "></i>
                            </a>
                        @else
                            <form action="{{route('mem.pubs.purchase', $l->id)}}" @submit.prevent="submit($event)">
                                <button type="submit">
                                    purchase
                                </button>
                            </form>
                        @endif
                        @else
                        <a href="{{route('mem.pubs.download', $l->id)}}" class="ml-4 " target="_blank"
                            rel="noopener noreferrer">
                            <i class="fas fa-download "></i>
                        </a>
                        @endif
                        <a href="{{route('mem.pubs.show', $l->slug)}}" target="blank">
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
