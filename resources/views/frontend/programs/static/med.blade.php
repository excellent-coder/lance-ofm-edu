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
               Candidates who holders Degree/HND in other fields but
               wish to make professional career in School
               Administration and Management, are eligible to apply
               for the award of B.Ed (Educational Administration
                and Management) Degree of our
               partner Universities by Graduate Conversion Course.
            </p>
        </div>
    </div>
    <div class="w-full mt-20 mb-10 lg:mx-32">
        <div class="grid grid-cols-1 mt-20 gap-x-6 gap-y-12 sm:grid-cols-2 md:grid-cols-4" >
            <div>
                <div class="w-full member-card">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                           Med One
                        </h2>
                       <p>1. Statiscal Methods</p>
								<p>2. Educational Research Methods</p>
								<p>3. Managerial Psychology</p>
								<p>4. Concepts and theories of Educational Administration and planning</p>
								<p>5. Human Resources Management in Education</p>
								<p>6. Practicum in Educational Management</p>
								<p>7. Project Management in Education</p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                           MED Two
                        </h2>
                      <p>1. Advanced Psychology of Learning</p>
								<p>2. Supervision of Instructions in Education</p>
								<p>3. Economics of Education</p>
								<p>4. Monitoring/Evaluation in Education Management</p>
								<p>5. Budgeting and Financial Management in Education</p>
								<p>6. Application of Management Information Systems in Education</p>
								<p>7. Educational Statistics for Education Managers</p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                           MED Three
                        </h2>
                      <p>1. Politics of Education</p>
								<p>2. Legal Aspects of Educational Administration</p>
								<p>3. Problems and Issues in Higher Education</p>
								<p>4. Dissertation Project</p>
								<p>5. School Plant Management</p>
								<p>6. Principles of Institutional Administration in Education</p>
								<p>7. Responsibility and Accountability in Education Management</p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <img class="w-full h-56" src="/storage/pages/gcc.jpg" alt="">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                          AFFILIATED UNIVERSITIES
                        </h2>
                      <p>
                          Contact Institute of School Administration and Management (ISAM)
                          for list of Affiliated Universities in Benin, Ghana, UK and USA.
                    </p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 mt-20 gap-x-6 gap-y-12 sm:grid-cols-2 md:grid-cols-4">
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
            <div>
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
