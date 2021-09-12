@extends('layouts.scs')
@section('title', '| Your Programs')
@section('content')
<div class="container">
    <div class="flex flex-wrap ">
        <h1 class="w-full my-8 font-black text-center text-b">
            TOPIC <br>
            {{$lesson->topic}}
        </h1>
        <div class="w-full">
            <div class="grid grid-cols-1 gap-x-4 gap-y-12 md:grid-cols-3">
                @foreach ($lesson->materials as $m)
                <div class="h-40 md:h-52">
                    @switch($m->type)
                    @case('image')
                    <img src="/storage/{{$m->path}}" alt="{{$m->name}}" class="w-full h-56 ">
                    @break
                    @case('video')
                    <iframe src="/storage/{{$m->path}}" frameborder="0" class="w-full h-56 "></iframe>
                    @break
                    @default
                    <a href="/storage/{{$m->path}}" target="_blank" rel="noopener noreferrer">
                        <img src="/storage/{{$lesson->image}}" alt="{{$lesson->title}}" class="w-full h-56 ">
                    </a>
                    @endswitch
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
