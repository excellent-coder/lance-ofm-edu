@extends('layouts.pgs')

@section('content')
    <div class="flex flex-wrap w-full h-screen bg-yellow-100">
        <div class="w-full text-white md:w-1/3 sm:w-3/4">
            @if ($center)
                <div class="p-4 bg-gray-800 shadow-2xl">
                    <h3>
                        Your Exam Center is
                    </h3>
                   <div>
                       <p><strong>Center</strong> {{$center->name}}</p>
                       <p><strong>Address</strong> {{$center->address}}</p>
                   </div>
                </div>
                @else
            <div class="p-4 bg-gray-800 shadow-2xl">
                <h1 class="text-lg font-black text-center">
                    Register For Your {{$auth->level->name}} Level Exam
                </h1>
                <form action="{{route('pgs.exam.register')}}" method="POST" @submit.prevent="submit($event)"
                    class="mt-8 text-gray-800">
                    @csrf
                    <div class="relative mb-4">
                        <i class="absolute left-0 text-lg text-white lg:text-2xl fas fa-user-graduate bottom-2"></i>
                        <div class="block ml-5 md:ml-9">
                            <label class="font-semibold text-white">Choose Center</label>
                            <input type="hidden" name="center" :value="form.m.id" required autocomplete="off" v-if="form.m" />
                            <multi-select v-model="form.m" :options="{{$centers}}" :show-labels="false" label="name"
                                track-by="id" autocomplete="off" :clear-on-select="false" placeholder="Choose Exam Center"
                                required :close-on-select="true" />
                        </div>
                    </div>
                     <div class="relative mb-4 text-white" v-if="form.m">
                         <label class="font-semibold" v-text="'Address'"></label>
                         <p v-text="form.m.address"></p>
                     </div>
                    <div class="text-center ">
                        <button type="submit"
                            class="w-32 px-4 py-3 antialiased font-semibold text-center text-white transition-all border-2 border-gray-100 rounded-lg shadow-xl hover:bg-yellow-500">
                            GO <i class="fas fa-forward "></i>
                        </button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
@endsection
