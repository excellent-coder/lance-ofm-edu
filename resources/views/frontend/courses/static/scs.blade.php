@extends('layouts.app')
@section('css')

@endsection

@section('content')
<div class="flex flex-wrap w-full pb-4 bg-gray-200">
    <div class="relative w-full bg-center bg-no-repeat bg-cover h-72"
        style="background-image: url(/storage/pages/awards-banner.jpg)">
        <div class="absolute w-full bottom-1/4">
            <h1 class="text-4xl font-black text-center text-gray-100 top-20">
                {{$course->name}}
            </h1>
        </div>
    </div>
    <div class="w-full my-10 ">
        <div class="flex justify-center w-full ">
            <p class="w-1/2 text-xl text-center text-gray-700 ">
                Through our team of trained professionals we offer a range of
                certified courses and programs. Our training options include
                the following: Virtual Training, Online Training,
                Onsite Training, Executive Coaching, and Manager Coaching.
            </p>
        </div>
    </div>
    <div class="w-full mt-20 mb-10 lg:mx-32">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 md:grid-cols-2">
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-72" src="/storage/pages/sc.jpg" alt="">
                    <div class="px-4 py-5 text-lg border-green-600 border-1 title">
                        <h4 class="mb-3">
                            <a href="#" title="">Introduction to Education</a>
                        </h4>
                        <h4 class="mb-3">
                            <a href="#" title="">Development of Appropriate Skills in Children</a>
                        </h4>
                        <h4 class="mb-3">
                            <a href="#" title="">Nigerian Peoples and culture</a>
                        </h4>
                        <h4 class="mb-3">
                            <a href="#" title="">History and Philosophy of Science</a>
                        </h4>
                        <h4 class="mb-3">
                            <a href="#" title="">Principles of Economics I</a>
                        </h4>
                        <h4 class="mb-3">
                            <a href="#" title="">Nigerian Legal System</a>
                        </h4>
                        <h4 class="mb-3">
                            <a href="#" title="">Introductory Mathematics Economics I</a>
                        </h4>
                        <h4 class="mb-3">
                            <a href="#" title="">Educational Technology</a>
                        </h4>
                        <h4 class="mb-3">
                            <a href="#" title="">Professionalism in Teaching</a>
                        </h4>
                        <h4 class="mb-3">
                            <a href="#" title="">Communication for Business</a>
                        </h4>
                        <h4 class="mb-3">
                            <a href="#" title="">Computer Appreciation for Managers</a>
                        </h4>
                        <h4 class="mb-3">
                            <a href="#" title="">Introductory Mathematics for Economics II</a>
                        </h4>
                        <h4 class="mb-3">
                            <a href="#" title="">Principle of Economics II</a>
                        </h4>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <div class="px-4 py-5 text-lg border-green-600 border-1 title">
                        <h4 class="mb-3 "><a href="#" title="">History of Education</a></h4>
                        <h4 class="mb-3 "><a href="#" title="">The School Environment and The Child</a></h4>
                        <h4 class="mb-3 "><a href="#" title="">Introduction to Microeconomics</a></h4>
                        <h4 class="mb-3 "><a href="#" title="">Nigerian Economy in Perspective</a></h4>
                        <h4 class="mb-3 "><a href="#" title="">History of Economic thought</a></h4>
                        <h4 class="mb-3 "><a href="#" title="">Economic Development</a></h4>
                        <h4 class="mb-3 "><a href="#" title="">General Teaching Method</a></h4>
                        <h4 class="mb-3 "><a href="#" title="">Sociology of Education</a></h4>
                        <h4 class="mb-3 "><a href="#" title="">Community Development</a></h4>
                        <h4 class="mb-3 "><a href="#" title="">Supervised Teaching Practice</a></h4>
                        <h4 class="mb-3 "><a href="#" title="">Introductory Macroeconomics</a></h4>
                        <h4 class="mb-3 "><a href="#" title="">Politics of Development and Underdevelopment</a></h4>
                        <h4 class="mb-3 "><a href="#" title="">Curriculum Development</a></h4>
                        <h4 class="mb-3 "><a href="#" title="">Philosophy of Education</a></h4>
                        <h4 class="mb-3 "><a href="#" title="">Psychology of learning</a></h4>
                        <h4 class="mb-3 "><a href="#" title="">Educational Laws And Regulations</a></h4>
                        <h4 class="mb-3 "><a href="#" title="">Public Sector Economics</a></h4>
                        <h4 class="mb-3 "><a href="#" title="">Introduction to Economics</a></h4>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <div class="px-4 py-5 text-lg border-green-600 border-1 title">
                        <h4 class="mb-3"><a href="#" title="">General Teaching Methods </a></h4>
                        <h4 class="mb-3"><a href="#" title="">Statistics and Research Methodology</a></h4>
                        <h4 class="mb-3"><a href="#" title="">Administration Of Schools</a></h4>
                        <h4 class="mb-3"><a href="#" title="">Monetary Economics </a></h4>
                        <h4 class="mb-3"><a href="#" title="">Financial Institutions</a></h4>
                        <h4 class="mb-3"><a href="#" title="">Politics of Educational Management</a></h4>
                        <h4 class="mb-3"><a href="#" title="">Management in Education</a></h4>
                        <h4 class="mb-3"><a href="#" title="">Test, Measurement And Evaluation</a></h4>
                        <h4 class="mb-3"><a href="#" title="">Educational Technology</a></h4>
                        <h4 class="mb-3"><a href="#" title="">Advanced Macroeconomics</a></h4>
                        <h4 class="mb-3"><a href="#" title="">Economics Planning</a></h4>
                        <h4 class="mb-3"><a href="#" title="">Comparative Education</a></h4>
                        <h4 class="mb-3"><a href="#" title="">Continuous Assessment</a></h4>
                        <h4 class="mb-3"><a href="#" title="">Advanced Microeconomics</a></h4>
                        <h4 class="mb-3"><a href="#" title="">Comparative Economics System</a></h4>
                        <h4 class="mb-3"><a href="#" title="">Development Administration</a></h4>
                        <h4 class="mb-3"><a href="#" title="">Human Behaviour and Leadership in Schools</a></h4>
                        <h4 class="mb-3"><a href="#" title="">Political Analysis</a></h4>
                        <h4 class="mb-3"><a href="#" title="">Developmental Psychology</a></h4>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-6 mt-20 sm:grid-cols-2 md:grid-cols-4">
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-56" src="/storage/pages/blog_1.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            REQUIREMENTS AND DURATION
                        </h2>
                        <p>While there is no entry requirements for our
                            short courses, Students can start their
                            courses and complete the courses any time.
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
                        <p>These courses are delivered online, there are
                            Recognized Teaching Centres for the ISAM courses in several
                            cities from which students can make a choice.
                            Students are also free to study privately.
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
                        <p>ISAM Examinations for Short Courses are strictly
                            Computer Base and are self placed, Once you
                            Complete your course online,
                            you take your examination and get your certificate.
                        </p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-56" src="/storage/pages/blog_4.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            FEE/HOW TO APPLY
                        </h2>
                        <p>
                            List of fees payable for each course can be
                            downloaded online. For online courses
                            use this Link. For Virtual Training, Onsite
                            Training, Executive Coaching, and Manager Coaching, Contact Us.
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
