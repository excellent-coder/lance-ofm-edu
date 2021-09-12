@extends('layouts.scs')
@section('title', '| Your Programs')
@section('content')
<div class="container ">
    <div class="flex flex-wrap justify-center w-full">
        <h1 class="w-full my-4">COURSE TO STUDY UNDER {{$program->title}}</h1>
        @if ($program->sCourses->count())
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
            @else
            <h1 class="w-full text-2xl font-bold text-red-600 md:w-1/2 ">
                Unfortunately There are no Course under this program,
                yet Keep checking back to get the lates update
            </h1>
        @endif
    </div>
</div>

@endsection
