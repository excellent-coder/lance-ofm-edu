@extends('layouts.app')

@section('css')
    <style>
        .animate-bounce-in{
            animation: animate-bounce-in 1s ease;
            transition: all 1s;
            position: relative;
        }
        @keyframes animate-bounce-in{
            from{
                transform: translateY(-100vh);
            }
            to{
                transform: translateY(0);
            }
        }
    </style>
@endsection

@section('content')
    <div class="flex flex-wrap content-center justify-center w-full h-screen">
        <div class="w-1/2">
            <p class="w-full text-center">
                <img class="inline" id="image" src="/storage/web/paid.png" alt="paid" height="40" width="100">
            </p>
            <p class="text-3xl font-semibold text-center text-green-700">
                {{$data->message}}
            </p>
        </div>
    </div>
@endsection
@section('js')
    <script>
        setTimeout(()=>{
            document.getElementById('image').classList.add('animate-bounce-in');
            console.log('done');
        }, 500)
    </script>
@endsection
