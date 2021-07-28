@extends('layouts.app')
@section('content')
<div class="w-full bg-gray-200 min-h-screen">
    <div class="flex w-full h-full justify-center">
        <div class="mt-10 lg:mt-20">
            {!! $action !!}
        </div>
    </div>
</div>

@endsection
