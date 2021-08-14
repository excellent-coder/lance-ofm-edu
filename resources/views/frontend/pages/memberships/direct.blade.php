@extends('layouts.app')
@section('css')

@endsection

@section('content')
<div class="flex flex-wrap w-full mb-4">
    <div class="relative w-full bg-center bg-no-repeat bg-cover h-52"
        style="background-image: url(/storage/pages/awards-banner.jpg)">
        <div class="absolute w-full bottom-1/4">
            <h1 class="text-4xl font-black text-center text-gray-100 top-20">
                Direct Membership
            </h1>
        </div>
    </div>
    <div class="flex flex-wrap justify-center w-full">
        <p class="w-3/4 text-center ">
            Direct membership is available in five grades,
            namely: Graduate-Member,
            Full-Member, Fellow, Corporate and Foreign.
        </p>
    </div>
    <div class="w-full mt-20 mb-10 lg:mx-32">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-4 md:grid-cols-2">
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-56" src="/storage/pages/blog3.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            Graduate Member
                        </h2>
                        <p>Applicants for selection to this grade must be at least 20 years of age and have little or no
                            working experience. </p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-56" src="/storage/pages/blog3_2.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            Full Member
                        </h2>
                        <p>Applicants for selection to this grade must be at least 25 years of age and have not less
                            than five years working experience in senior administrative function in any Educational
                            organization. </p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-56" src="/storage/pages/blog3_3.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            Fellow
                        </h2>
                        <p>Applicants must be at least 30 years of age and have not less than ten years working
                            experience in senior administrative functions in any Educational organization, five of which
                            must be at the top echelon of executive appointment. </p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-56" src="/storage/pages/blog3_4.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            Corporate Member
                        </h2>
                        <p>Corporate members shall be institutions that want to identify with the ISAM with high level
                            of integrity and vetted by relevant organizations and those institutions or organizations
                            whose activities revolve School Administration and Management.</p>
                    </div>
                    <div class="h-8 px-4 border-green-600 border-r-1 border-b-1 border-l-1">

                    </div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-56" src="/storage/pages/blog3_5.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            Foreign Member
                        </h2>
                        <p>Any Member, Institute or Organizations that processes the above requirements but are not
                            resident or citizen of Nigeria shall be identified as a Foreign Member.</p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-56" src="/storage/pages/blog_1.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            GENERAL QUALIFICATIONS
                        </h2>
                        <p>The general educational requirement is a degree, or HND, or Final Professional Examination
                            Certificate, in any Educational discipline, in addition to practical experience requirement.
                        </p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-56" src="/storage/pages/blog_2.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            INDUCTION FEES
                        </h2>
                        <p>Successful candidates will be required to pay the following membership induction fees upon
                            being notified of their admission into membership: Graduate ₦50,000; Full-Members ₦ 120,000;
                            Fellows ₦ 200,000; Corporate ₦ 250,000; Foreign $ 300. </p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-56" src="/storage/pages/blog_3.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            MEMBERSHIP FEES
                        </h2>
                        <p>Members will be required to pay the following annual membership fees: Graduate ₦8,000;
                            Full-Members ₦ 20,000; Fellows ₦ 30,000; Corporate 50,000; Foreign $ 60. </p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-56" src="/storage/pages/blog_4.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            HOW TO APPLY
                        </h2>
                        <p>Candidates for Membership should download and completed the Application Form for Membership,
                            scan and attached all copies of their certificates, and make payment of N10,000
                            non-refundable mandatory processing fee into the Institute Bank Account.</p>
                    </div>
                    <div class="px-4 py-2 border-green-600  border-r-1 border-b-1 border-l-1">
                        Click Here to Download Application Form
                    </div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-56" src="/storage/pages/blog_5.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            APPLICATION DATE
                        </h2>
                        <p>Application Form for Membership is always opened throughout the year but the next date of
                            Induction will be communicated to all Accepted Members. </p>
                    </div>
                    <div class="h-8 px-4 border-green-600 border-r-1 border-b-1 border-l-1">

                    </div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-56" src="/storage/pages/blog_6.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            MORE INFORMATION
                        </h2>
                        <p>visit
                            Registrar/Chief Executive, <br>
                            Institute of School Administration and Management<br>
                            50 Olowu Street, Ikeja, Lagos State, Nigeria<br>

                            <b>Website</b>: <a class="font-semibold hover:text-yellow-800"
                                href="https://www.isam.org.ng">
                                https://www.isam.org.ng
                            </a> <br>
                            <b>Email</b>: isam.org.ng@gmail.com, info@isam.org.ng <br>
                            <b>Tel</b>: 08065674312<br>
                        </p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-56" src="/storage/pages/blog3_6.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            ACCOUNT DETAILS
                        </h2>
                        <p>
                            Bank: <br>
                            Account Name: Institute of School Administration and Management<br>
                            Account Number: <br>
                        </p>
                    </div>
                    <div class=" h-8border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

@endsection
