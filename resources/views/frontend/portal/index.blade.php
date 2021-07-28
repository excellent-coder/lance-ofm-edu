@extends('layouts.portal')

@section('content')
<div class="w-full h-full grid grid-cols-3 gap-3 bg-gray-900 px-1 text-blue-700">
    <div class=" h-56 bg-indigo-50 cursor-pointer">
        <h4 class="text-center text-2xl font-semibold">Programms</h4>
        <i class="fas fa-school fa-3x block text-center text-gray-700 my-3"></i>
    </div>
    <div class=" h-56 bg-blue-100 cursor-pointer">
        <h4>Courses</h4>
        <i class="fas fa-chalkboard-teacher fa-3x block text-center text-gray-700 my-3"></i>
    </div>
    <div class=" h-56 bg-yellow-50 cursor-pointer">
        <h4>progress</h4>
        <i class="fas fa-project-diagram fa-3x block text-center text-gray-700 my-3"></i>
    </div>
</div>
@endsection
