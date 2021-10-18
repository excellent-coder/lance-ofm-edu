@extends('layouts.app')
@section('css')

@endsection

@section('content')
<div class="flex flex-wrap w-full mb-4">
    <div class="relative w-full bg-center bg-no-repeat bg-cover h-52"
        style="background-image: url(/storage/{{$licence->image}})">
        <div class="absolute w-full bottom-1/4">
            <h1 class="text-4xl font-black text-center text-gray-100 top-20">
                {{$licence->name}}
            </h1>
        </div>
    </div>
    <div class="w-full mt-20 mb-10 lg:mx-32">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 md:grid-cols-2">
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-72" src="/storage/pages/blog_1.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            ACCEPTABLE QUALIFICATIONS
                        </h2>
                        <p>
                            Applicants must be Full-Member or Fellow of
                            the Institute of School Administration and Management.
                            Applicants must have paid up their Annual Dues to date.
                        </p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-72" src="/storage/pages/indur.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            LICENCE DURATION
                        </h2>
                        <p>The duration of every licence by the Institute of School Administration and
                            Management is three years and must be renewed every three years.</p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-72" src="/storage/pages/linfee.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            LICENCE FEES
                        </h2>
                        <p>Licence fee is N50,000 for Individual and N120,000 for Corporate Organizations.
                            Renewal is N20,000 for Individual and N50,000 for Corporate Organizations.</p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-72" src="/storage/pages/blog_4.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            HOW TO APPLY
                        </h2>
                        <p>Applicants should download and completed the Application Form for Licence, scan
                            and attached their membership certificates, and make payment of licence fee into
                            the Institute Bank Account.</p>
                    </div>
                    <div class="h-8 px-4 border-green-600 border-r-1 border-b-1 border-l-1">
                        <a href="{{route('mem.license')}}">
                            Click Here to apply For this license
                        </a>
                    </div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-72" src="/storage/pages/blog_5.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            APPLICATION DATE
                        </h2>
                        <p>Application Form is always available throughout the year.</p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-72" src="/storage/pages/blog_6.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            FOR MORE INFORMATION
                        </h2>
                        <p>
                            ISAM<br>
                            50 Olowu Street, Ikeja, Lagos State, Nigeria<br>
                            Website: https://www.isam.org.ng<br>
                            Email: isam.org.ng@gmail.com, info@isam.org.ng <br>
                            Tel: 08065674312<br>
                        </p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

@endsection
