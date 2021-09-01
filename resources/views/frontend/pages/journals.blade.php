@extends('layouts.app')
@section('css')

@endsection

@section('content')
<div class="flex flex-wrap w-full mb-4">
    <div class="relative w-full bg-center bg-no-repeat bg-cover h-52"
        style="background-image: url(/storage/pages/awards-banner.jpg)">
        <div class="absolute w-full bottom-1/4">
            <h1 class="text-4xl font-black text-center text-gray-100 top-20">
                Isam Journals
            </h1>
        </div>
    </div>
    <div class="w-full mt-20 mb-10 lg:mx-32">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 md:grid-cols-2">
            @foreach (\App\Models\Journal::where('active', 1)->get() as $j)
                            <div>
                <div class="w-full member-card">
                    {{-- <iframe class="w-full h-72" src="/storage/{{$j->pdf}}#toolbar=1" frameborder="0"></iframe> --}}
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            {{$j->title}}
                        </h2>
                        <div>
                            {!! $j->description !!}
                        </div>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1">
                        <a href="/storage/{{$j->pdf}}" target="_blank">
                                download <i class="fas fa-file-download "></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
@endsection

@section('js')

@endsection
