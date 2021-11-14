@extends('layouts.auth')
@section('content')
<div class="flex flex-wrap justify-center w-full h-screen bg-yellow-100 bg-center bg-no-repeat bg-cover" style="background-image:url(/storage/static/slider-01.jpg);">
    <div class="items-center self-center w-full text-white bg-red-400 md:w-1/3 sm:w-3/4">
        <div class="p-4 bg-gray-800 shadow-2xl">
            <h1 class="text-lg font-black text-center">
                Login With Your Details<br>
                <i class="block text-center fas fa-user-graduate"></i>
            </h1>

            <form action="{{route('password')}}" method="POST" @submit.prevent="submit($event)" class="mt-8 text-gray-800">
                @csrf
                <div class="relative mb-4">
                    <i class="absolute left-0 text-lg text-white lg:text-2xl fas fa-user-graduate bottom-2"></i>
                    <div class="block ml-5 md:ml-9">
                        <label class="font-semibold text-white">Account Tpe</label>
                        <input type="hidden" name="login_as" :value="form.m.v" required autocomplete="off" v-if="form.m" />
                        <multi-select v-model="form.m" :options='[{v:"Member", k:"Member"}, {v:"Scs",k:"Short Course Student"}, {v:"Student",k:"Main Student"}]' :show-labels="false" label="k" track-by="v" autocomplete="off" :clear-on-select="false" placeholder="Who Are You" required :close-on-select="true" />
                    </div>
                </div>
                <div class="relative">
                    <i class="absolute left-0 text-lg text-white lg:text-2xl fas fa-user bottom-2"></i>
                    <div class="block ml-5 md:ml-9" v-if="form.m && form.m.v=='Scs'">
                        <label class="font-semibold text-white times-new-romans">
                            Email/Username/Matric No.
                        </label>
                        <input placeholder="Email/Username/Matric No" type="text" required name="username" class="h-12 max-w-full p-4">
                    </div>
                    <div class="block ml-5 md:ml-9" v-if="form.m && form.m.v=='Member'">
                        <label class="font-semibold text-white times-new-romans">
                          Email/  Member ID
                        </label>
                        <input placeholder="Email / Member ID" type="text" required name="username" class="h-12 max-w-full p-4">
                    </div>
                    <div class="block ml-5 md:ml-9" v-if="!form.m || form.m.v=='Student'">
                        <label class="font-semibold text-white times-new-romans">
                           Email / Matric No.
                        </label>
                        <input placeholder="Email / Matric No" type="text" required name="username" class="h-12 max-w-full p-4">
                    </div>
                </div>

                <div class="flex justify-end w-full mb-4 font-extrabold">
                    <div class="text-right text-green-200 hover:text-yellow-300">
                        <a href="{{route('login')}}">Login</a>
                    </div>
                </div>
                <div class="text-center ">
                    <button type="submit" class="px-4 py-3 antialiased font-semibold text-center text-white transition-all border-2 border-gray-100 rounded-lg shadow-xl hover:bg-yellow-500">
                        Change Password <i class="fas fa-forward "></i>
                    </button>
                </div>
            </form>
            <div class="flex flex-wrap justify-between w-full my-4">
                <h4 class="w-full mb-2 text-2xl font-bold text-center times-new-romans">
                    Don't Have Accout
                </h4>
                <p class="w-1/2 font-semibold">
                    <a href="{{route('scs.apply')}}" class="text-green-500 hover:text-yellow-400">
                        Register For Short Course
                    </a>
                </p>
                <p class="w-1/2 font-semibold text-right">
                    <a href="{{route('pgs.apply')}}" class="text-green-500 hover:text-yellow-400">
                        Apply For Main Student
                    </a>
                </p>
                <p class="w-full mt-3 text-lg font-semibold text-center">
                    <a href="{{route('mem.apply')}}" class="text-gray-100 hover:text-yellow-400">
                        Apply For Membership
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
