@extends('layouts.mem')
@section('content')
<div class="dashboard">
    <div class="container ">
        <div class="grid grid-cols-1 gap-8 mt-8 lg:grid-cols-3 md:grid-cols-2">
            @foreach ($licenses as $l)
            <div>
                <div class="w-full member-card">
                    @if ($l->image)
                    <img class="w-full h-72" src="/storage/{{$l->image}}" alt="{{$l->name}}">
                    @endif
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl uppercase title">
                            {{$l->name}}
                        </h2>
                        <p>
                            {{Str::limit($l->excerpt, 200) }}
                        </p>
                    </div>
                    <div class="flex justify-between h-8 border-green-600 border-r-1 border-b-1 border-l-1">
                        <a href="{{route('mem.license.purchase', $l->slug)}}">
                            purchase
                        </a>
                        <a href="{{route('license.show', $l->slug)}}" target="blank">
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
