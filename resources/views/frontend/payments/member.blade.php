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
            Your payment of
           <span class=" arial">
               {{$currency_symbol}}
               </span>
               {{$payment->amount}}
            for
            {{$payment->reason}}
            is
            {{$payment->status}}
            </p>
            <p class="my-4 text-center ">
                 <a class="relative p-3 text-white uppercase bg-transparent border-2 border-yellow-400 hover:text-black bg-scale-in"
                     href="{{session('paid.next', '/')}}">
                     <span class="relative z-10 ">
                         {{session('paid.nex_title', 'Home')}}
                     </span>
                     </a>
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
