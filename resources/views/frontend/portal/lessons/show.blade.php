@extends('layouts.portal')

@section('css')

@endsection

@section('content')
<div class="w-full h-full grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-3 bg-gray-300 px-1 text-blue-700">

    @foreach ($lessons as $lesson)
        <div class="h-80 bg-indigo-50 cursor-pointer relative">
            <a href="{{route('portal.lessons', $lesson->slug)}}">
                <img class=" h-3/5 block w-full" src="/storage/{{$lesson->photo}}" alt="{{$lesson->topic}}">
                <h4 class="text-left text-xl font-semibold">{{$lesson->topic}}</h4>
                <p class="px-2">
                    @php
                        $d = strip_tags($lesson->description);
                    @endphp
                    {{Str::limit($d, 150)}}
                </p>
                <div class=" bg-blue-300 text-red-700 font-black grid grid-cols-2 gap-4 absolute bottom-0 left-0 w-full">
                    <p>Updated On</p>
                    <p>{{$lesson->updated_at}}</p>
                </div>
            </a>
        </div>
    @endforeach
</div>
@endsection
