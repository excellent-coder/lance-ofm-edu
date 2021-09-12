@extends('layouts.auth')
@section('content')
<div class="flex justify-center w-full bg-yellow-100">
    <div class="w-full md:w-11/12 lg:w-3/4">
        <div class="p-4 bg-gray-700 shadow-2xl">
            <h1 class="text-lg font-black text-center text-white md:text-3xl lg:text-4xl">
                Apply For Main Student
            </h1>
            <form action="{{route('pgs.apply')}}" method="post" @submit.prevent="submit($event)"
                class="my-8 text-gray-800">
                @csrf
                <div class="grid w-full grid-cols-1 gap-x-12 md:grid-cols-2">
                    <div>
                        <div class="relative mb-4">
                            <label class="font-semibold text-white">Program of study Type</label>
                            <input type="hidden" name="program" :value="form.m.id" autocomplete="off" v-if="form.m" />
                            <multi-select v-model="form.m" :options="{{$programs}}" :show-labels="false" label="title"
                                track-by="id" autocomplete="off" :clear-on-select="false" placeholder="Program Of Study"
                                required :close-on-select="true"/>
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
                            <label class="font-semibold text-white">Certificates</label>
                            <input accept=".pdf,.docx" type="file" name="certificates[]" multiple
                                class="relative h-12 p-4 bg-white">
                        </div>

                    </div>
                    <div>
                        <div class="relative mb-4">
                            <label class="font-semibold text-white">Phone</label>
                            <input placeholder="Phone" type="tel" inputmode="numeric" required name="phone"
                                class="h-12 p-4">
                        </div>
                        <div class="relative mb-4">
                            <label class="font-semibold text-white">Email</label>
                            <input placeholder="Email" type="email" required name="email" class="h-12 p-4">
                        </div>
                        <div class="relative mb-4">
                            <label for="" class="font-semibold text-white">Date of birth</label>
                            <input placeholder="Date of Birth" type="date" min="{{ date('Y')-55 . '-01-01'}}"
                                max="{{date('Y')-13 .'-01-01'}}" required name="dob" class="h-12 p-4 wtk">
                        </div>
                        <div class="relative mb-4">
                            <label class="font-semibold text-white">Upload Your reccent photograph</label>
                            <input type="file" accept="image/*"  name="passport"
                                class="relative h-12 p-4 bg-white">
                        </div>
                        <div class="relative mb-4">
                            <label class="font-semibold text-white">
                                Upload Documents
                            </label>
                            <input type="file" accept=".pdf,.docx" multiple name="documents[]"
                                class="relative h-12 p-4 bg-white">
                        </div>

                    </div>
                </div>
                <div class="grid w-full grid-cols-2 mb-8 text-sm md:font-extrabold">
                    <div>
                        <div class="text-white checkbox">
                            <input id="terms" type="checkbox" class="form-check-input form-control filled-in"
                                name="terms" value="1">
                            <label for="terms" class="after-white">
                                <span class="relative -top-1">
                                    Agree to
                                    <a href="/terms" class="text-green-400 hover:text-yellow-300">terms</a>
                                </span>
                            </label>
                        </div>

                        <div class="text-white checkbox bounce-in" v-if="parseInt(form.fee)">
                            <input id="pay" type="checkbox" class="form-check-input form-control filled-in" name="pay"
                                value="1">
                            <label for="pay" class="after-white">
                                <span class="relative -top-1">
                                    I'M Ready to make payment of
                                    {{$currency}}
                                    <span v-text="form.fee"></span>
                                </span>
                                <span class="block ">
                                    See
                                    <a v-if="form.m" :href="'/programs/'+form.m.slug+'#how-to-apply'" target="_blank"
                                        class="text-green-400 hover:text-yellow-300">
                                        How to Apply
                                    </a>
                                </span>
                            </label>
                        </div>
                        <input type="hidden" name="pay" value="1" v-else>
                    </div>
                    @guest('pgs', 'mem', 'scs')
                    <div class="text-right ">
                        <span class="mr-2 text-white">Already A member</span>
                        <a class="text-green-400 hover:text-yellow-300" href="{{route('login')}}">
                            Login here
                        </a>
                    </div>
                    @endguest
                </div>
                <div class="mb-4 text-center">
                    <button type="submit"
                        class="px-4 py-3 antialiased font-semibold text-center text-white transition-all border-2 border-gray-100 rounded-lg shadow-xl hover:bg-yellow-500">
                        Submit Application <i class="fas fa-forward "></i>
                    </button>
                </div>
                <div class="flex flex-wrap w-full mt-3 text-base font-bold text-green-500">
                    @guest('pgs', 'mem', 'scs')
                    <p class="w-1/2 ">
                        <a href="{{route('scs.apply')}}" class="hover:text-yellow-500">
                            Register For short Course Studies
                        </a>
                    </p>
                    @endguest
                    <p class="w-1/2 @guest('pgs', 'mem', 'scs') text-right @endguest">
                        <a class=" hover:text-yellow-500" href="{{route('mem.apply')}}">
                            Apply For Membership
                        </a>
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
