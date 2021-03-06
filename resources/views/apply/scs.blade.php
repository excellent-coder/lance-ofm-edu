@extends('layouts.auth')
@section('title', '| Short Course Studies Application')
@section('content')
<div class="relative flex justify-center w-full bg-yellow-100 bg-center bg-cover" style="background-image:url(/storage/static/slider-01.jpg);">
    <div class="w-full md:w-11/12 lg:w-3/4">
        <div class="p-4 bg-gray-700 shadow-2xl">
            <h1 class="text-lg font-black text-center text-white md:text-3xl lg:text-4xl">
                Register As A short Course Student
            </h1>
            <form action="{{route('scs.apply')}}" method="POST" @submit.prevent="submit($event)"
                class="my-8 text-gray-800">
                @csrf
                <div class="grid w-full grid-cols-1 gap-x-12 md:grid-cols-2">
                     <div class="relative mb-4">
                            <label class="font-semibold text-white">Program of study Type</label>
                            <input type="hidden" name="program" :value="form.m.id" autocomplete="off" v-if="form.m" />
                            <multi-select v-model="form.m" :options="{{$programs}}" :show-labels="false" label="title"
                                track-by="id" autocomplete="off" :clear-on-select="false" placeholder="Program Of Study"
                                required :close-on-select="true"/>
                        </div>
                    <div class="relative mb-4">
                        <label class="font-semibold text-white">Email</label>
                        <input placeholder="Email" type="email" required name="email" class="h-12 p-4">
                    </div>
                    <div class="relative mb-4">
                        <label class="font-semibold text-white">First Name</label>
                        <input placeholder="First Name" type="text" required name="first_name" class="h-12 p-4">
                    </div>
                    <div class="relative mb-4">
                        <label class="font-semibold text-white">Last Name</label>
                        <input placeholder="Last Name" type="text" required name="last_name" class="h-12 p-4">
                    </div>
                    <div class="relative mb-4">
                        <label class="font-semibold text-white">Other Name</label>
                        <input placeholder="Other Name" type="text" name="middle_name" class="h-12 p-4">
                    </div>
                    <div class="relative mb-4">
                        <label class="font-semibold text-white">Phone</label>
                        <input placeholder="Phone" type="tel" inputmode="numeric" required name="phone"
                            class="h-12 p-4">
                    </div>
                    <div class="relative mb-4">
                        <label for="" class="font-semibold text-white">Date of birth</label>
                        <input placeholder="Date of Birth" type="date" required name="dob" class="h-12 p-4 wtk">
                    </div>
                    <div class="relative mb-4 password">
                        <label class="font-semibold text-white">Password</label>
                        <input id="g-password" placeholder="password" type="password" required name="password"
                            class="h-12 p-4 password">
                        <span class="absolute right-0 text-lg text-gray-500 cursor-pointer opacity-70 bottom-2"
                            @click.prevent="showPass($event, 'g')">
                            <i class="fas fa-eye" style="display: none"></i>
                            <i class="fas fa-eye-slash"></i>
                        </span>
                    </div>
                    <div class="relative mb-4">
                        <label class="font-semibold text-white">Passport</label>
                        <input accept="image/*" type="file" required name="passport" class="relative h-12 p-4 bg-white">
                    </div>
                    <div class="relative mb-4" v-if="form.m && parseInt(form.m.scs_app_fee)">
                        <label class="font-semibold text-white">Course Fee <b>{{$currency}}</b> </label>
                        <input type="text" readonly class="relative h-12 p-4 bg-white" :value="form.m.scs_app_fee">
                    </div>
                </div>
                <div class="grid w-full grid-cols-2 mb-8 text-sm md:font-extrabold">
                    <div>
                        <div class="text-white checkbox">
                            <input id="terms" type="checkbox" class="filled-in"
                                name="terms" value="1">
                            <label for="terms" class="after-white">
                                <span class="relative -top-1">
                                    Agree to
                                    <a href="{{route('terms')}}" target="_blank" class="text-green-400 hover:text-yellow-300">terms</a>
                                </span>
                            </label>
                        </div>

                    </div>
                    <div class="text-right ">
                        <span class="mr-2 text-white">Already A member</span>
                        <a class="text-green-400 hover:text-yellow-300" href="{{route('login')}}">
                            Login here
                        </a>
                    </div>
                </div>
                <div class="mb-4 text-center">
                    <button type="submit"
                        class="w-32 px-4 py-3 antialiased font-semibold text-center text-white transition-all border-2 border-gray-100 rounded-lg shadow-xl hover:bg-yellow-500">
                        Register <i class="fas fa-forward "></i>
                    </button>
                </div>
                <div class="flex flex-wrap w-full mt-3 text-base font-bold text-green-500">
                    <p class="w-1/2 ">
                        <a href="{{route('mem.apply')}}" class="hover:text-yellow-500">Apply For membership</a>
                    </p>
                    <p class="w-1/2 text-right">
                        <a class="text-right hover:text-yellow-500" href="{{route('pgs.apply')}}">Apply For Main
                            Student</a>
                    </p>
                    <p class="w-full my-8 text-center text-gray-100">
                        <a class="text-3xl text-right hover:text-yellow-500" href="{{route('home')}}">
                            Go Home
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
