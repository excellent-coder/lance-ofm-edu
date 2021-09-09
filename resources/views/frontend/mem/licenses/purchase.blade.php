@extends('layouts.mem')
@section('css')
<style>
    .dashboard .profile-img {
        border-radius: 999px
    }

</style>
@endsection
@section('content')
<div class="flex flex-wrap w-full mb-4">
    <div class="relative w-full bg-gray-600 bg-center bg-no-repeat bg-cover h-52"
        style="background-image: url(/storage/{{$license->image}})">
        <div class="absolute w-full bottom-1/4">
            <h1 class="text-4xl font-black text-center text-gray-100 top-20">
                {{$license->name}} License
            </h1>
        </div>
    </div>
    <div class="w-full mt-8 md:w-3/4 ">
        <div>
            {!! $license->description !!}
        </div>
    </div>
    <div class="w-full mt-8 text-center md:w-1/4 md:text-left">
        <form action="{{route('mem.license.purchase', $license->id)}}" method="post" @submit.prevent="submit($event)">
            @csrf
            <button type="submit"
                class="w-32 px-4 py-3 antialiased font-semibold text-center text-white transition-all bg-indigo-800 border-2 border-gray-100 rounded-lg shadow-xl hover:bg-yellow-500">
                purchase <i class="fas fa-forward "></i>
            </button>
        </form>
    </div>
</div>
@endsection
