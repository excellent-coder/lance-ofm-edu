@extends('layouts.app')
@section('css')

@endsection

@section('content')
<div class="flex flex-wrap w-full mb-4">
    <div class="relative w-full bg-center bg-no-repeat bg-cover h-72"
        style="background-image: url(/storage/pages/awards-banner.jpg)">
        <div class="absolute w-full bottom-1/4">
            <h1 class="text-4xl font-black text-center text-gray-100 top-20">
                Contact ISAM
            </h1>
        </div>
    </div>
    <div class="w-full bg-gray-100">
        <div class="container text-center">
            <h1>Do you have suggestions or questions for ISAM?</h1>
            <p class="text-lg text-gray-700 " style="line-height: 1.5;">
                Fill out the form below or give us a call. Thank you!<br>

                Office Address: 50 Olowu Street, Ikeja, Lagos, Nigeria<br>

                Office phone: +234-806-567-43, 08065674312<br>
                Email: isam.org.ng@gmail.com, info@isam.org.ng
            </p>
        </div>
        <div class="grid grid-cols-1 md:p-10 lg:grid-cols-2 lg:gap-4">
            <div class="p-4 text-lg text-gray-700 bg-gray-700 lg:p-8">
                <form action="{{route('contact.store')}}" @submit.prevent="submit($event)">
                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                        <div>
                            <input placeholder="First Name" type="text" required name="first_name" class="h-12 p-4">
                        </div>
                        <div>
                            <input placeholder="Last Name" type="text" required name="last_name" class="h-12 p-4">
                        </div>
                        <div>
                            <input placeholder="Your Email" type="email" required name="email" class="h-12 p-4 ">
                        </div>
                        <div>
                            <input placeholder="Your Phone" type="tel" required name="phone" class="h-12 p-4">
                        </div>
                    </div>
                    <div class="mt-8 ">
                        <textarea placeholder="Message" name="message" rows="4" class="p-4 required" required></textarea>
                    </div>
                    <div>
                        <button type="submit"
                            class="w-32 px-4 py-3 mt-6 antialiased font-semibold text-center text-white transition-all border-2 border-gray-100 rounded-lg shadow-xl hover:bg-yellow-500">
                            Send
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

@endsection
