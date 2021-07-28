@extends('layouts.portal')

@section('css')

@endsection

@section('content')
<div class="w-full h-full grid grid-cols-3 gap-3 bg-gray-300 px-1 text-blue-700">

    @foreach ($lessons as $l)
        <div class=" h-80 bg-indigo-50 cursor-pointer my-3">
            <h4 class="text-center text-2xl font-semibold">{{$l->topic}}</h4>
            @if ($l->type =='image')
                    <img src="{{asset("storage/$l->url")}}" alt="" class="h-4/5">
                @elseif ($l->type == 'video')
                    <video src="{{asset("storage/$l->url")}}" class="h-4/5"></video>
                @else
                    <a href="{{asset("storage/$l->url")}}" target="_blank">{{$l->name}}</a>
            @endif
        </div>
    @endforeach
</div>
@endsection
