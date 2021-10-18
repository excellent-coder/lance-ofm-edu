@extends('layouts.scs')
@section('title', '| Dashboard')
@section('content')
<div class="container">
    <h1 class="my-4 ">
        Good <span v-text="greeting"></span>
        {{Str::ucfirst($auth->first_name)}}
    </h1>
    <p>Welcome to Isam Short Course Learning Center</p>
    <div class="grid grid-cols-1 mt-8 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($userPrograms as $p)
        <div>
            <div class="w-full h-48 ">
                <a href="{{route('scs.program', $p->slug)}}" class="w-full h-3/4">
                    <img class="w-full h-full" src="/storage/{{$p->image??'web/program.jpg'}}" alt="{{$p->title}}">
                </a>
                <a class="text-xl font-bold text-green-600 hover:text-yellow-600" href="{{route('scs.program', $p->slug)}}">
                    {{$p->title}}
                </a>
                <div>
                    <p>
                        <label>Started</label>
                        {{$p->pivot->start_at}}
                    </p>
                    <p>
                        <label>Ending</label>
                        {{$p->pivot->end_at}}
                    </p>

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
