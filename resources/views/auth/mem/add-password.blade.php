@extends('layouts.auth')
@section('content')
<div class="flex flex-wrap justify-center w-full h-screen bg-yellow-100">
    <div class="items-center self-center w-full text-white bg-red-400 md:w-1/3 sm:w-3/4">
        <div class="p-4 bg-gray-800 shadow-2xl">
            <h1 class="text-lg font-black text-center">
              CHOOSE PASSWORD <br>
                <i class="block text-center fas fa-user-graduate"></i>
            </h1>

            <form action="{{route('mem.add-password', $member->id)}}" method="POST" @submit.prevent="submit($event)"
                class="mt-8 text-gray-800">
                @csrf
                <div class="relative mb-4">
                    <i class="absolute left-0 text-lg text-white lg:text-2xl fas fa-user bottom-2"></i>
                    <div class="block ml-5 md:ml-9">
                        <label class="font-semibold text-white times-new-romans">
                           MEMBER ID
                            </label>
                        <input placeholder="Matric No" type="text" readonly value="{{$member->member_id}}" class="h-12 max-w-full p-4">
                        <small class="block text-gray-50">
                            <span class="text-xl font-black ">💡</span>
                            Keep a copy of your member Id as you will need it to Login
                        </small>
                    </div>
                </div>
                <div class="relative mb-4 password">
                    <i class="absolute left-0 text-lg text-white lg:text-2xl fas fa-lock bottom-3"></i>
                    <div class="ml-5 md:ml-9">
                     <label class="font-semibold text-white times-new-romans">
                          Choose Password
                        </label>
                        <input id="admin-login-password" placeholder="password" type="password" required name="password"
                            class="h-12 max-w-full p-4 password">
                        <span class="absolute right-0 text-lg text-gray-500 cursor-pointer opacity-70 bottom-2"
                            @click.prevent="showPass($event, 'admin-login')">
                            <i class="fas fa-eye" style="display: none"></i>
                            <i class="fas fa-eye-slash"></i>
                        </span>
                    </div>
                </div>

                <div class="text-center ">
                    <button type="submit"
                        class="w-32 px-4 py-3 antialiased font-semibold text-center text-white transition-all border-2 border-gray-100 rounded-lg shadow-xl hover:bg-yellow-500">
                        Continue
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
