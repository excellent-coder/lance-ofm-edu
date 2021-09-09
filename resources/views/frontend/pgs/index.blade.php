@extends('layouts.pgs')

@section('content')
<div class="grid w-full h-full grid-cols-3 gap-3 px-1 text-blue-700 bg-gray-900">
    <div class="h-56 cursor-pointer  bg-indigo-50">
        <h4 class="text-2xl font-semibold text-center">Programms</h4>
        <i class="block my-3 text-center text-gray-700 fas fa-school fa-3x"></i>
    </div>
    <div class="h-56 bg-blue-100 cursor-pointer ">
        <h4>Courses</h4>
        <i class="block my-3 text-center text-gray-700 fas fa-chalkboard-teacher fa-3x"></i>
    </div>
    <div class="h-56 cursor-pointer  bg-yellow-50">
        <h4>progress</h4>
        <i class="block my-3 text-center text-gray-700 fas fa-project-diagram fa-3x"></i>
    </div>
</div>
@endsection
