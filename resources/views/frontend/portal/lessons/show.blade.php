@extends('layouts.portal')

@section('css')

@endsection

@section('content')
<div class="grid w-full h-full grid-cols-1 gap-3 px-1 text-blue-700 bg-gray-300 lg:grid-cols-3 md:grid-cols-2 lg:px-4">

    @foreach ($course->PLessons as $lesson)
        <div class="relative cursor-pointer h-80 bg-indigo-50">
            <a href="{{route('portal.lesson', $lesson->slug)}}">
                <img class="block w-full h-3/5" src="/storage/{{$lesson->image ?? 'web/course.svg'}}" alt="{{$lesson->topic}}">
                <h4 class="text-xl font-semibold text-left">{{$lesson->topic}}</h4>
                <p class="px-2">
                    @php
                        $d = strip_tags($lesson->description);
                    @endphp
                    {{Str::limit($d, 150, '...')}}
                </p>
                <div class="absolute bottom-0 left-0 grid w-full grid-cols-2 gap-4 font-black text-red-700 bg-blue-300 ">
                    <p>Updated On</p>
                    <p>{{$lesson->updated_at}}</p>
                </div>
            </a>
        </div>
    @endforeach
</div>
@endsection
