@extends('layouts.scs')
@section('title', '| Apply For Programs')
@section('content')
<div class="container ">
    <h1 class="text-center ">Register For Programs</h1>
    <p>Check any of the programs you want to apply for</p>
    <form action="{{route('scs.programs.apply')}}" @submit.prevent="submit($event)" method="post">
        <div class="flex flex-wrap justify-center w-full h-full mt-20 text-black">
            <div class="w-full mb-4 md:w-3/4 xl:w-1/2">
                <div class="relative">
                    <i class="absolute left-0 text-lg text-yellow-600 lg:text-2xl bottom-2 fa fa-book"
                        aria-hidden="true"></i>
                    <div class="block ml-5 md:ml-9">
                        <label class="font-semibold">Choose Another Program</label>
                        <input type="hidden" name="program" :value="form.m.id" autocomplete="off" v-if="form.m" />
                        <multi-select v-model="form.m" :options="{{$programs}}" :show-labels="false" label="title"
                            track-by="id" autocomplete="off" :clear-on-select="false" placeholder="Program" required
                            :close-on-select="true" />
                    </div>
                </div>
                <div class="w-full mt-10 text-right md:mr-8">
                    <button type="submit"
                        class="w-32 px-4 py-3 antialiased font-semibold text-center text-white transition-all bg-black border-2 border-gray-100 rounded-lg shadow-xl hover:bg-yellow-500">
                        submit
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
