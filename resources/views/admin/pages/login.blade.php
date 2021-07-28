@extends('layouts.app')
@section('content')
<div class="grid grid-cols-8 px-4 md:px-0">
    <div class="md:col-span-3 md:col-start-3 col-span-8 col-start-1">
    <form @submit.prevent="submit($event)"
    class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="{{route('user.login')}}">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                Email
            </label>
            <input class="
                        shadow
                        appearance-none
                        border
                        rounded
                        w-full
                        py-2
                        px-3
                        text-gray-700
                        leading-tight
                        focus:outline-none
                        focus:shadow-outline
                    " id="email" type="text" name="email" placeholder="Email" />
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                Password
            </label>
            <input class="
                        shadow
                        appearance-none
                        rounded
                        w-full
                        py-2
                        px-3
                        text-gray-700
                        mb-3
                        leading-tight
                        focus:outline-none
                        focus:shadow-outline
                    " id="password" type="password" placeholder="******************" name="password" />
            <p class="text-red-500 text-xs italic">
                Please choose a password.
            </p>
        </div>
        <div class="flex items-center justify-between">
            <button class="
                        bg-blue-500
                        hover:bg-blue-700
                        text-white
                        font-bold
                        py-2
                        px-4
                        rounded
                        focus:outline-none
                        focus:shadow-outline
                    " type="submit">
                Sign In
            </button>
            <a
                    class="
                        inline-block
                        align-baseline
                        font-bold
                        text-sm text-blue-500
                        hover:text-blue-800
                    "
                    href="#"
                >
                    Forgot Password?
                </a>
        </div>
    </form>
    </div>
</div>

@endsection
