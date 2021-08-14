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
            <div class="w-4/6 text-xl text-center text-gray-600" style="line-height: 1.8;">
                <p class="lead">Ph.D. in Education by Research via Online Learning is ideal for people engaged in the
                    world of work who cannot attend a traditional university. Institute of School Administration and
                    Management with her accredited international partners: an alternative that helps adult students
                    around the world achieve their academic goals. Surveys conducted over the years have shown that a
                    Ph.D. by research achieved via Online Learning, in a reputable institution, can be as useful as a
                    traditional school. In fact, what is important is the skills and professionalism.
                </p>

                <p class="lead">Doctor of Philosophy (Ph.D.) is the highest academic title awarded by universities in
                    most countries. The Ph.D. usually covers all programs of the entire academic range. As a graduate
                    researcher, students studying for this qualification are usually required to demonstrate competence
                    and mastery of the subject matter for the exam, but also to make new academic contributions to a
                    particular area of human knowledge through original research. The online Ph.D. by research consists
                    of original academic research carried out autonomously by the candidate, in a specific branch of
                    human knowledge culminating in a final Ph.D. thesis.
                </p>

                <p class="lead">The study and research program must be carried out by the student independently. The
                    supervisor will not be a real tutor, but rather a specialized consultant, to whom the student can
                    turn for any assistance. The student can use textbooks and the Internet for his research. Through
                    free and independent research, students acquire highly specialized knowledge and a full mastery of
                    the specific skills that they will develop, argue and defend in their culminating work: the doctoral
                    thesis.
                </p>

            </div>
        </div>
    </div>
    <div class="w-full mt-20 mb-10 lg:mx-32">
        <div class="grid grid-cols-1 mt-20 gap-x-6 gap-y-12 sm:grid-cols-2 md:grid-cols-3">
            <div>
                <div class="w-full member-card">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            PHD One
                        </h2>
                        <p>1. Advance Educational Research Methods</p>
                        <p>2. Statistical Analysis and Quantification in Educational Planning</p>
                        <p>3. Manpower Approach In Educational Planning</p>
                        <p>4. Administration Of Schools</p>
                        <p>5. Seminar: Ph.D. Education Thesis (Part 1)</p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            PHD Two
                        </h2>
                        <p>1. Communication Strategy In Educational Planning</p>
                        <p>2. Evaluation Strategies in Educational Planning and Implementation</p>
                        <p>3. Implementation Of Educational Policy Plans</p>
                        <p>4. Advance Curriculum Theory</p>
                        <p>5. Ph.D. Education Thesis (Part 2)</p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            PHD Three
                        </h2>
                        <p>1. Information & Communication Technology In Education</p>
                        <p>2. Educational Laws And Regulations</p>
                        <p>3. Education Finance</p>
                        <p>4. Ph.D. Education Thesis (Part 3)</p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            PHD Four
                        </h2>
                        <p>1. Oraganisational Theory In Education</p>
                        <p>2. Conceptualization Of Instructional Strategies</p>
                        <p>3. Topical Issues In Educational Administration</p>
                        <p>4. Seminar: Ph.D. Education Thesis (Part 4)</p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            PHD Five
                        </h2>
                        <p>
                            1. Analytical Approach To
                            Educational Planning
                        </p>
                        <p>
                            2. Comparative Studies In Higher
                            Education Systems
                        </p>
                        <p>3. Seminar: Ph.D. Education Thesis (Part 5)</p>
                    </div>
                    <div class="h-8 border-green-600 border-r-1 border-b-1 border-l-1"></div>
                </div>
            </div>
            <div>
                <div class="w-full member-card">
                    <div class="px-4 py-5 border-green-600 border-1">
                        <h2 class="mb-3 text-xl title">
                            PHD Six
                        </h2>
                        <p>1. Ph.D. Education Thesis</p>
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
                            Students are also free to study privately and register for the examinations as independent
                            candidates.
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
