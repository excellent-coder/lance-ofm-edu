@extends('layouts.app')
@section('css')

@endsection

@section('content')
<div class="flex flex-wrap w-full mb-4">
    <div class="relative w-full bg-center bg-no-repeat bg-cover h-52"
        style="background-image: url(/storage/pages/awards-banner.jpg)">
        <div class="absolute w-full bottom-1/4">
            <h1 class="text-4xl font-black text-center text-gray-100 top-20">
               Honourary Membership
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
                        <p>Applicants must be undergoing a
                            regular course of study in
                            Educational Related fields
                            in a University, Polytechnic
                            or College of Education.
                        </p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-72" src="/storage/pages/blog_2.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            INDUCTION FEES
                        </h2>
                        <p>
                            Successful candidates will be required to pay
                            <span class="font-semibold ">
                                ₦20,000
                            </span>
                            membership induction fees upon
                            being notified of their admission into
                            membership of the Institute.
                        </p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-72" src="/storage/pages/blog_3.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            MEMBERSHIP FEES
                        </h2>
                        <p>
                            Members will be required to pay
                            <span class="font-semibold"> ₦5,000 </span>
                            annual membership fee yearly.
                        </p>
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
                        <p>Candidates for Membership should download and completed the Application Form for
                            Membership, scan and attached all copies of their certificates, and make payment
                            of N10,000 non-refundable mandatory processing fee into the Institute Bank
                            Account.</p>
                    </div>
                    <div class="h-8 px-4 border-green-600 border-r-1 border-b-1 border-l-1">
                         Click Here to Download Application Form
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
                        <p>Application Form for Membership is always opened
                            throughout the
                            year but the next
                            date of Induction will be
                            communicated to all Accepted Members.
                        </p>
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
                        <p>visit
                            Registrar/Chief Executive, <br>
                            Institute of School Administration and Management<br>
                            50 Olowu Street, Ikeja, Lagos State, Nigeria<br>

                            <b>Website</b>: <a class="font-semibold hover:text-yellow-800" href="https://www.isam.org.ng">
                                https://www.isam.org.ng
                            </a> <br>
                            <b>Email</b>: isam.org.ng@gmail.com, info@isam.org.ng <br>
                            <b>Tel</b>: 08065674312<br>
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
