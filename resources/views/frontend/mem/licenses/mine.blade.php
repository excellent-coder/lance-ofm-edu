@extends('layouts.mem')
@section('content')
<div class="dashboard">
    <div class="container ">
        <h1 class="m-4 text-center ">My Licences</h1>
        <div class="grid grid-cols-1 gap-8 mt-8 lg:grid-cols-3 md:grid-cols-2">
            @foreach ($licenses as $l)
            <div>
                <div class="w-full border border-green-600 member-card">
                    @if ($l->image)
                    <img class="w-full h-72" src="/storage/{{$l->image}}" alt="{{$l->name}}">
                    @endif
                    <div class="px-4 py-5">
                        <h2 class="mb-3 text-xl uppercase title">
                            {{$l->name}}
                        </h2>
                        <p>
                            {{Str::limit($l->excerpt, 200) }}
                        </p>
                    </div>
                    <div class="flex justify-between h-8 border-t border-green-600">
                        @if($l->expeired)
                            <a href="{{route('mem.license.purchase', $l->id)}}" @click.prevent="purchaseLicense($event, {{$l}}, '{{$currency}}' )" >
                                Renew
                            </a>
                        @endif
                        <a href="{{route('license.show', $l->slug)}}">
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
