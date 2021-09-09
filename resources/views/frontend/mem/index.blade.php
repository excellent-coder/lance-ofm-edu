@extends('layouts.mem')
@section('css')
    <style>
        .dashboard .profile-img{
            border-radius: 999px
        }
    </style>
@endsection
@section('content')
<div class="flex w-full px-4 dashboard">
<div class="w-full text-center md:text-left">
    <img class="inline border-2 border-gray-600 profile-img md:w-52 md:h-52 w-28 h-28" src="/storage/{{$auth->image}}" alt="{{"$auth->last_name, $auth->first_name"}}">
    <h4 class="text-lg font-bold text-blue-700 md:text-xl ">{{"$auth->last_name $auth->first_name $auth->middel_name"}}</h4>
    <h4 class="text-lg font-bold text-red-600 md:text-xl ">{{$auth->membership->name}} Member</h4>
</div>
</div>
@endsection
