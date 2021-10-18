@extends('layouts.app')
@section('css')
<style>
    .times-new-romans {
        font-family: 'Times New Roman', Times, serif;
    }

    .nunito {
        font-family: Nunito;
    }

</style>
@endsection

@section('content')
<div class="flex flex-wrap w-full px-2 mb-4 md:px-7">
    <div class="relative w-full bg-center bg-cover bg-no-repea h-52"
        style="background-image: url(/storage/{{$event->image}})">
        <h1 class="absolute w-full font-black text-center text-black bottom-1/4">
            {{Str::upper($event->title)}}
        </h1>
    </div>
    <div class="w-full md:w-3/4">
        <h1 class="mt-2 mb-3 text-3xl font-black text-black nunito">
            {{Str::ucfirst($event->title)}}
        </h1>
        <div class="text-2xl sharer">
            <div class="flex flex-wrap">
                <span class="pr-4 ">Kindly share this Event:</span>
                <div class="flex space-x-2 justify-evenly">
                    <a target="_blank" class="px-3 py-2 text-blue-700 transition-all bg-gray-200 hover:opacity-60"
                        href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}">
                        <i class=" fab fa-facebook-square" aria-hidden="true" aria-labelledby="share on facebook"></i>
                    </a>
                    <a target="_blank" class="px-3 py-2 text-blue-500 bg-gray-200 hover:opacity-60"
                        href="https://twitter.com/share?text={{urlencode($event->title)}}&url={{url()->current()}}">
                        <i class="fab fa-twitter-square" aria-hidden="true" aria-labelledby="share on twitter"></i>
                    </a>
                    <a target="_blank" class="px-3 py-2 text-green-500 bg-gray-200 hover:opacity-60"
                        href="https://api.whatsapp.com/send?text={{url()->current()}}">
                        <i class=" fab fa-whatsapp-square" aria-hidden="true" aria-labelledby="share on whatsapp"></i>
                    </a>
                    <a target="_blank" class="px-3 py-2 text-indigo-500 bg-gray-200 hover:opacity-60"
                        href="https://linkedin.com/shareArticle?mini=true&url={{url()->current()}}">
                        <i class="fab fa-linkedin" aria-hidden="true" aria-labelledby="share on linkedin"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="mt-8 ">
            {!! $event->description !!}
        </div>
    </div>
    <div class="w-full md:w-1/4 ">
        <h3 class="text-xl">
            <a href="{{route('posts.latest')}}" class="font-black text-red-600 times-new-romans hover:text-yellow-600">
                Upcoming Events
            </a>
        </h3>
        <ul class="flex-wrap list-item">
            @foreach ($events as $p)
            <li class="py-2 mb-1 text-xl font-semibold border-b-2 border-gray-200 border-solid">
                <a href="{{route('events.show', $p->slug)}}" class="text-black hover:text-indigo-600">
                    {{Str::limit(Str::title($p->title))}}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="w-full my-5">
        <a @click.prevent="registerEvent($event, '{{auth('mem')->id()}}', {{$event}}, '{{$currency}}')" class="relative p-3 text-white uppercase bg-transparent border-2 border-yellow-400 hover:text-black bg-scale-in"
            href="{{route('events.register', $event->slug)}}">
            <span class="relative z-10 ">
                Register For This Event
            </span>
        </a>
    </div>
</div>
@endsection

@section('js')

@endsection
