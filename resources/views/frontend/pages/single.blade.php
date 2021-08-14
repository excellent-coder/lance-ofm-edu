@extends('layouts.app')
@section('css')
<style>
</style>
@endsection

@section('content')
<div class="flex flex-wrap w-full mb-4">
    <div class="relative w-full bg-center bg-cover bg-no-repea h-52" style="background-image: url(/storage/{{$page->image}})">
        <h1 class="absolute w-full font-black text-center text-black bottom-1/4">
            {{Str::upper($page->title)}}
        </h1>
    </div>
    <div class="w-full px-4 md:px-8">
        <div class=" img-inline">
            {!! $page->description !!}
        </div>
    </div>

</div>
@endsection

@section('js')

@endsection
