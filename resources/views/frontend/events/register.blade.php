@extends('layouts.auth')
@section('content')
<div class="flex flex-wrap justify-center w-full h-screen bg-yellow-100">
    <div class="items-center self-center w-full text-white bg-red-400 md:w-1/3 sm:w-3/4">
        <div class="p-4 bg-indigo-800 shadow-2xl">
            <h1 class="text-lg font-black text-center">
             Register for This Event <br>
             <span class="block my-2 capitalize">
                 {{$event->title}}
                 </span>
            </h1>

            <form action="{{route('events.register', $event->id)}}" method="POST" @submit.prevent="submit($event)"
                class="mt-8 text-gray-800">
                @csrf
                <div class="relative mb-4">
                    <i class="absolute left-0 text-lg text-white lg:text-2xl fas fa-user bottom-2"></i>
                    <div class="block ml-5 md:ml-9">
                        <label class="text-white">Full Name</label>
                        <input placeholder="Name" type="text" required name="name" class="h-12 max-w-full p-4">
                    </div>
                </div>
                <div class="relative mb-4">
                    <i class="absolute left-0 text-lg text-white lg:text-2xl fas fa-envelope bottom-2"></i>
                    <div class="block ml-5 md:ml-9">
                        <label class="text-white">Email</label>
                        <input placeholder="Email" type="text" required name="email" class="h-12 max-w-full p-4">
                    </div>
                </div>
                <div class="relative mb-4">
                    <i class="absolute left-0 text-lg text-white lg:text-2xl fas fa-phone bottom-2"></i>
                    <div class="block ml-5 md:ml-9">
                        <label class="text-white">Phone</label>
                        <input placeholder="Phone" type="tel" required name="phone" class="h-12 max-w-full p-4">
                    </div>
                </div>
                <div class="relative mb-4 text-white">
                    <label>This event cost {{$currency. ' '. number_format($event->price, 2) }}</label>
                    <small class="block ">You will be promted to make payment otherwise you wont be allowed to attenf this event</small>
                </div>

                <div class="text-center ">
                    <button type="submit"
                        class="w-32 px-4 py-3 antialiased font-semibold text-center text-white transition-all border-2 border-gray-100 rounded-lg shadow-xl hover:bg-yellow-500">
                        GO <i class="fas fa-forward "></i>
                    </button>
                </div>
            </form>
                <div class="mt-4 text-center">
                    <a href="/" type="submit"
                        class="w-32 px-4 py-3 antialiased font-semibold text-center text-white transition-all border-2 border-gray-100 rounded-lg shadow-xl hover:bg-yellow-500">
                        Home <i class="fas fa-home "></i>
                    </a>
                </div>
        </div>
    </div>
</div>
@endsection
