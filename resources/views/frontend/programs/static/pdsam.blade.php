@extends('layouts.app')
@section('css')

@endsection

@section('content')
<div class="flex flex-wrap w-full pb-4 bg-gray-200">
    <div class="relative w-full bg-center bg-no-repeat bg-cover h-72"
        style="background-image: url(/storage/pages/awards-banner.jpg)">
        <div class="absolute w-full bottom-1/4">
            <h1 class="text-4xl font-black text-center text-gray-100 top-20">
                {{$program->title}}
            </h1>
        </div>
    </div>
    <div class="w-full my-10 ">
        <div class="flex justify-center w-full ">
            <p class="w-1/2 text-xl text-center text-gray-700 ">
                This is the Institute’s School Administrative Management
                Technician Course (SAMTC), with minimum duration of
                four semesters. This comprises SAMTC 1, SAMTC 2,
                SAMTC 3, and SAMTC 4, to be completed strictly in
                that sequence, subject to any exemptions awarded,
                plus Supervised Teaching Practice, Research Project,
                and Career Development and Training (CADET) workshop.
            </p>
        </div>
    </div>
    <div class="w-full mt-20 mb-10 lg:mx-32">
        <div class="grid grid-cols-1 mt-20 gap-x-6 gap-y-12 sm:grid-cols-2 md:grid-cols-4">
            <div>
                <div class="w-full member-card">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            SAMTC One
                        </h2>
                        <p>1. Introduction to Education</p>
                        <p>2. Development of Appropriate Skills in Children</p>
                        <p>3. Nigerian Peoples and culture</p>
                        <p>4. History and Philosophy of Science</p>
                        <p>5. Principles of Economics I</p>
                        <p>6. Nigerian Legal System</p>
                        <p>7. Introductory Mathematics Economics I</p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            SAMTC Two
                        </h2>
                        <p>1. Educational Technology</p>
                        <p>2. Professionalism in Teaching</p>
                        <p>3. Communication for Business</p>
                        <p>4. Computer Appreciation for Managers</p>
                        <p>5. Introductory Mathematics for Economics II</p>
                        <p>6. Principle of Economics II</p>
                        <p>7. Political Analysis</p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            SAMTC Three
                        </h2>
                        <p>1. Developmental Psychology</p>
                        <p>2. History of Education</p>
                        <p>3. The School Environment and The Child</p>
                        <p>4. Introduction to Microeconomics</p>
                        <p>5. Nigerian Economy in Perspective</p>
                        <p>6. History of Economic thought</p>
                        <p>7. Economic Development</p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            SAMTC Four
                        </h2>
                        <p>1. General Teaching Method</p>
                        <p>2. Sociology of Education</p>
                        <p>3. Community Development</p>
                        <p>4. Supervised Teaching Practice</p>
                        <p>5. Introductory Macroeconomics</p>
                        <p>6. Politics of Development and Underdevelopment</p>
                        <p>7. Research Project</p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-56" src="/storage/pages/blog_1.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                           REQUIREMENTS AND DURATION
                        </h2>
                        <p>Senior School Certificate or equivalents with
                            five credits including English Language and
                            Mathematics obtained at two sittings. Candidates
                            who do not have complete credit passes are considered
                            for provisional admission on the condition that they will make up
                            their entry deficiencies before completing the course.
                        </p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-56" src="/storage/pages/sc_1.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                           MODE OF DELIVERY
                        </h2>
                        <p>These courses are delivered online,
                            there are Recognized Teaching Centres
                            for the PDSAM courses in several cities
                            preparing students for the examinations of the
                            Institute, from which the students can make a choice.
                            Students are also free to study privately and register for the examinations as independent candidates.
                            For the full list of study centres, use this link.
                        </p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-56" src="/storage/pages/sc_2.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                          EXAMINATION /DATES/CENTRES
                        </h2>
                        <p>
                            PDSAM Examinations are strictly Computer Base and are held twice
                            each year, in accordance with detailed Time Table for each
                            examination diet to be published or notified to the
                            candidates before the examination. The examinations
                            will be held at the Examination Centre choose by the
                             student during registration.
                            The Examinations are open only to Registered Students.
                        </p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div id="how-to-apply">
                <div class="w-full member-card">
                    <img class="w-full h-56" src="/storage/pages/blog_4.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                          FEE/HOW TO APPLY
                        </h2>
                        <p>
                            List of fees payable for the programmes can
                            be downloaded using this Link. Candidates for
                                Professional Diploma in School Administration and
                                Management should completed the Online Application
                                Form for Professional Diploma in School Administration
                                and Management, upload all copies of their certificates,
                                and make online payment of N5,000 non-refundable mandatory processing fee.
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
