@extends('layouts.app')
@section('css')

@endsection

@section('content')
<div class="flex flex-wrap w-full mb-4">
    <div class="relative w-full bg-center bg-no-repeat bg-cover h-52"
        style="background-image: url(/storage/pages/awards-banner.jpg)">
        <div class="absolute w-full bottom-1/4">
            <h1 class="text-4xl font-black text-center text-gray-100 top-20">
                Donate
            </h1>
        </div>
    </div>
    <div class="w-full mt-20 mb-10 lg:mx-32">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 md:grid-cols-2">
            <div>
                <div class="w-full member-card">
                    <div class="px-4 py-5 text-white bg-gray-700 border-gray-200 border-1">
                        <h2 class="mb-3 text-5xl font-semibold text-center">
                            Unrestricted General Contribution
                        </h2>
                        <p>
                            Providing general support for the mission and work of ISAM to the benefit of our
                            membership and the global School Administration and Management community. ISAM works
                            tirelessly to foster the development of School Administration and Management to solve
                            real-world problems through publications, research, and
                            community.
                        </p>
                    </div>
                    <div class="h-8 border-gray-200 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <div class="px-4 py-5 text-white bg-gray-700 border-gray-200 border-1">
                        <h2 class="mb-3 text-5xl font-semibold text-center">
                            ISAM Official Journal
                        </h2>
                        <p>
                            Journal of School Administration and Management (JSAM) is a peer-reviewed, open access
                            journal that provides rapid publication of articles in all areas of School
                            Administration and Management and related disciplines. The objective of this journal is
                            to provide a veritable platform for scientists and researchers all over the world to
                            promote, share, and discuss a variety of innovative ideas and developments in all
                            aspects of School Administration and Management. The Journal welcomes the submission of
                            manuscripts that meet the general criteria of significance and scientific excellence.
                            Papers will be published shortly after acceptance. All articles published in JSAM are
                            peer-reviewed.
                        </p>
                    </div>
                    <div class="h-8 border-gray-200 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <div class="px-4 py-5 text-white bg-gray-700 border-gray-200 border-1">
                        <h2 class="mb-3 text-5xl font-semibold text-center">
                            ISAM Students Travel Fund
                        </h2>
                        <p>
                            Institute Of School Administration and Management (ISAM) Student Travel Awards are
                            here to help students gain the experience and exposure that comes from attending and
                            presenting at Institute Of School Administration and Management (ISAM) Conferences.
                            Travel awards are intended to help students defray costs of their attendance, like
                            travel and registration fees, which may be restrictive to students.
                        </p>
                    </div>
                    <div class="h-8 border-gray-200 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
        </div>
        <div class="grid gap-5 mt-8 lg:grid-cols-4 sm:grid-cols-2 md:grid-cols-3">
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-56" src="/storage/pages/donate_1.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            Your support will helps ISAM
                        </h2>
                        <p>Strengthen and enhance the global landscape of School Administration and Management
                                through strategic international initiatives.
                                </p>
                            <p>Foster productive networking, collaboration, mentorship and recognition opportunities
                                leading to invaluable career advancement for members and innovative research
                                cooperation.
                                </p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <p>Increase student interest and awareness of School Administration and Management-related
                                careers through resources and information.
                                </p>
                            <p>Promote the discipline by recognizing and publicizing important developments and novel
                                applications in the field.
                                </p>
                            <p>Further engage people from underrepresented groups in School Administration and
                                Management fields.
                                 </p>
                            <p>Maintain a presence in Lagos-Nigeria, where we work with policymakers and actively
                                advocate for funding while also keeping our membership aware and knowledgeable on policy
                                issues
                                </p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
             <div>
                <div class="w-full member-card">
                    <img class="w-full h-56" src="/storage/pages/donate_2.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            Ways to Give
                        </h2>
                        <p>Each year, donors will be recognized in SIAM News and in our Annual Meeting program.</p>
                            <p>
                                <h3>Online</h3>Don’t want to bother with snail mail? No problem! Donate with your credit
                                card online.
                            </p>
                            <p>
                                <h3>Cash or Cheque</h3>Please make cheques payable to Institute of School Administration
                                and Management and send to our office. If you are donating in honor of someone or
                                sponsoring a specific project, please write that in the memo of your cheque.
                            </p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
             <div>
                <div class="w-full member-card">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <p>
                                <h3>Stocks, Securities, or Other Assets</h3>We are able to accept donations in the form
                                of stocks, securities, or other assets like personal property and royalties, which may
                                have favorable tax benefits to you.
                            </p>
                            <p>
                                <h3>Real Estate</h3>ISAM considers gifts of real property on a case-by-case basis in
                                accordance with its gift policies. Such donations may include residences, vacation
                                homes, business or commercial property (developed or undeveloped).
                            </p>
                            <p>
                                <h3>Tribute Giving</h3>Family members, friends, and colleagues can be honored or
                                remembered with a tribute gift. Such gifts are an expression of respect and goodwill
                                that greatly benefit the School Administration and Management community.
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
