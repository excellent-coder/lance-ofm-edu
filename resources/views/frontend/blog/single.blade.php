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
    <div class="w-3/4 ">

        <h1 class="mt-2 mb-3 text-3xl font-black text-black nunito">
            {{Str::ucfirst($post->title)}}
        </h1>
        <div class="text-2xl sharer">
            <div class="flex">
                <span class="pr-4 ">Kindly share this story:</span>
                <div class="flex space-x-2 justify-evenly">
                    <a target="_blank" class="px-3 py-2 text-blue-700 transition-all bg-gray-200 hover:opacity-60"
                        href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}">
                        <i class=" fab fa-facebook-square" aria-hidden="true" aria-labelledby="share on facebook"></i>
                    </a>
                    <a target="_blank" class="px-3 py-2 text-blue-500 bg-gray-200 hover:opacity-60"
                        href="https://twitter.com/share?text={{urlencode($post->title)}}&url={{url()->current()}}">
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
        <div>
            {!! $post->description !!}
        </div>

        <div>
            <ul class="flex justify-start space-x-2">
                <label class="p-2 font-bold text-white bg-yellow-500 ">Tags: </label>
            @foreach ($post->tags as $t)
                <a class="p-2 font-semibold text-black bg-gray-300 " href="{{route('tags.show', $t->slug)}}">{{$t->tag}}</a>
            @endforeach
            </ul>
        </div>
    </div>
    <div class="w-1/4 ">
        <h3 class="text-xl">
            <a href="{{route('posts.latest')}}" class="font-black text-red-600 times-new-romans hover:text-yellow-600">
                Latest Posts
            </a>
        </h3>
        <ul class="flex-wrap list-item">
            @foreach ($posts as $p)
            <li class="py-2 mb-1 text-xl font-semibold border-b-2 border-gray-200 border-solid">
                <a href="{{route('posts.show', $p->slug)}}" class="text-black hover:text-indigo-600">
                    {{Str::limit(Str::title($p->title))}}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection

@section('js')

@endsection
