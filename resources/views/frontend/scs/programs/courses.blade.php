@extends('layouts.scs')
@section('title', '| Your Programs')
@section('content')
<div class="flex flex-wrap justify-center w-full">
    <h1 class="w-full my-4">YOUR COURSES</h1>
    <div class="w-full md:w-3/4">
        <div class="grid grid-cols-1 md:grid-cols-3">
            @foreach ($program->sCourses as $item)
            <div class="h-40 md:h-52">
                <a href="{{route('scs.course', $item->slug)}}" class="block">
                    <img src="/storage/{{$item->image??'web/course.svg'}}" class="w-full h-3/4" alt="">
                    {{$item->name}}
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
