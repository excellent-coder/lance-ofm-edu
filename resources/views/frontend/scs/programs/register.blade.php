@extends('layouts.scs')
@section('title', '| Apply For Programs')
@section('content')
 <div class="container ">
        <h1 class="m-4 text-center ">Register For a program</h1>
        <div class="grid grid-cols-1 gap-8 mt-8 lg:grid-cols-4 xl:grid-cols-5 md:grid-cols-3">
            @foreach ($scPrograms as $program)
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-32" src="/storage/{{$program->image}}" alt="{{$program->title}}">
                    <div class="p-1 border border-green-600">
                        <h2 class="text-xl uppercase title">
                            {{$program->title}}
                        </h2>
                        <p>
                            {{ Str::limit(strip_tags($program->excerpt), 200) }}
                        </p>
                        <p class="text-xl font-black text-left text-red-700 ">
                            @if ((int) $program->scs_app_fee)
                            <span>{{$currency}} {{$program->scs_app_fee}} </span>
                            @else
                            <span>Free</span>
                            @endif
                        </p>
                        <p class="text-sm font-black text-left text-red-700 over ">
                            <i class="mr-1 fas fa-map-marker-alt"></i>
                             <span>Online</span>
                        </p>
                    </div>
                    <div class="flex justify-between h-8 border border-b border-r border-green-600">

                      <a href="{{route('scs.program.apply', $program->id)}}" @click.prevent="scsProgram($event, {{$program}}, '{{$currency}}' )" >
                            Apply
                        </a>
                        <a href="{{route('programs.show', $program->slug)}}" target="blank">
                            Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
