@extends('layouts.scs')
@section('title', '| Apply For Programs')
@section('content')
<div class="container ">
    <h1 class="text-center ">Register For Programs</h1>
    <p>Check any of the programs you want to apply for</p>
    <form action="{{route('scs.programs.apply')}}" @submit.prevent="submit($event)" method="post">
    <div class="flex flex-wrap justify-start w-full h-full mt-20 text-black">
        @foreach ($programs as $p)
        <div class="w-1/2 checkbox md:w-1/4 lg:w-1/6">
            <input id="{{$p->slug}}" type="checkbox" class="form-check-input form-control filled-in"
                name="programs[]" value="{{$p->id}}">
            <label for="{{$p->slug}}" class="after-white">
                <span class="relative">
                    {{$p->title}}
                </span>
            </label>
        </div>
        @endforeach

        <div class="w-full mt-10 text-left">
             <button type="submit"
                class="w-32 px-4 py-3 antialiased font-semibold text-center text-white transition-all bg-black border-2 border-gray-100 rounded-lg shadow-xl hover:bg-yellow-500">
                submit
            </button>
        </div>
    </div>

    </form>
</div>
@endsection
