@extends('layouts.scs')
@section('title', '| Your Programs')
@section('content')
<div class="container flex flex-wrap ">
    <h1 class="w-full my-8 font-black text-center text-b">
        LESSON FOR {{$course->name}}
        </h1>
    <div class="w-full md:w-3/4">
        <div class="grid grid-cols-1 md:grid-cols-3">
            @foreach ($course->sLessons as $item)
            <div class="h-40 md:h-52">
                <a href="{{route('scs.lesson', $item->slug)}}" class="block text-xl font-bold text-blue-800 hover:text-yellow-600">
                    <img src="/storage/{{$item->image??'web/course.svg'}}" class="w-full h-3/4" alt="">
                    {{$item->topic}}
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
