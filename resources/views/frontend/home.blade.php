@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/timeline.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/flaticoin/flaticon.css')}}">

@endsection
@section('content')
<div class="w-full">
    @include('includes.home.slides')
    <div class="container">
        <div class="w-full px-4 mx-auto lg:w-5/6">
            @include('includes.home.about')
            <div class="grid w-full my-10 lg:gap-2 gap-y-4 lg:grid-cols-2 animate-on-scroll">
                @if ($benefits)

                <div class="animate-on-scroll">
                    <h3 class="text-base font-bold text-yellow-500 md:text-lg">{{Str::upper($benefits->title)}}</h3>
                    <div>
                        {!! $benefits->description !!}
                    </div>
                    <p class="mb-6 ">
                        <a class="relative p-3 text-white capitalize bg-transparent border-2 border-yellow-400 hover:text-black bg-scale-in"
                            href="{{route('pages.show', $benefits->slug)}}">
                            <span class="relative z-10 ">
                                AND MANY MORE
                            </span>
                        </a>
                    </p>
                </div>
                @endif
                <div class="grid grid-cols-1 animate-on-scroll">
                    <img class="w-full h-60" src="/storage/static/about_02.jpg" alt="">
                    <img class="w-full h-60" src="/storage/static/about_02_2.jpg" alt="">
                </div>
            </div>
            <div class="grid w-full mb-6 lg:grid-cols-2 lg:gap-12">
                <div>
                    @if ($homeImg)
                    <div class="relative grid w-full grid-cols-1 animate-on-scroll">
                        @foreach ($homeImg->active as $himg)
                        <div class="relative h-48">
                            <img class="w-full h-full" src="/storage/{{$himg->src}}" alt="{{$web_title}}">
                            {{-- <a class="absolute top-0 right-0 text-indigo-800" href="{{route('admin.images.edit',$himg->id )}}"
                            target="_blank" rel="noopener noreferrer">
                            <i class="fas fa-pencil-alt fa-2x"></i>
                            </a> --}}
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div>
                    @if ($qualities)
                    <h3 class="text-base font-bold text-yellow-500 md:text-lg">
                        {{Str::upper($qualities->title)}}
                    </h3>
                    <div>
                        {!! $qualities->description !!}
                    </div>
                    <p class="my-6 ">
                        <a class="relative p-3 text-white uppercase bg-transparent border-2 border-yellow-400 hover:text-black bg-scale-in"
                            href="{{route('pages.show', $benefits->slug)}}">
                            <span class="relative z-10 ">
                                contact us for more information
                            </span>
                        </a>
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('includes.home.programs')
</div>

@endsection

@section('js')
<script src="{{asset('js/timeline.min.js')}}"></script>
<script>
    timeline(document.querySelectorAll('.timeline'), {
        forceVerticalMode: 700,
        mode: 'horizontal',
        verticalStartPosition: 'left',
        visibleItems: parseInt('{{ $programs->count() > 4 ? 4 : $programs->count()}}')
    });

</script>
@endsection
