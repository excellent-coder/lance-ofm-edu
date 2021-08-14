@extends('layouts.app')
@section('css')

@endsection

@section('content')
<div class="flex flex-wrap w-full mb-4">
    <div class="relative w-full bg-center bg-no-repeat bg-cover h-52"
        style="background-image: url(/storage/pages/awards-banner.jpg)">
        <div class="absolute w-full bottom-1/4">
            <h1 class="text-4xl font-black text-center text-gray-100 top-20">
                ISAM Awards
            </h1>
            <p class="text-2xl font-semibold text-center text-gray-50">
                Institute Of School Administration And Management Awards
            </p>
        </div>
    </div>
    <div class="w-full bg-gray-100">
        <div class="flex justify-center w-full ">
            <p class="w-full px-2 py-4 text-center lg:w-1/2 lg:py-10">
                With the following awards ISAM fosters
                and encourages promising new researchers,
                and recognizes eminent, long-standing
                career achievements within these areas of
                interest through a generous awards program.
                All of these are awarded to recognise and
                celebrate excellence in School Administration and
                Management. The following award list provides a guidance on eligibility
                criteria for the awards and the nomination required
            </p>
        </div>
        <div class="grid grid-cols-1 p-10 lg:grid-cols-2 lg:gap-4">
            <div>
                <img src="/storage/pages/awards.jpg" class="block w-11/12 mx-auto h-80" alt="">
            </div>
            <div>
                <div class="mb-8 lg:mb-20">
                    <p>
                        <h3>Education Leaders Awards </h3>

                        These Awards are presented annually to Individuals, Professionals, Organisations and
                        Institutions who as demonstrates an outstanding achievement in Education. It is an Outstanding
                        Value Awards for appreciation of the outstanding work done by accomplished
                        Institutions/Organizations/Individuals/Professionals.
                    </p>

                    <p>
                        <h3>Outstanding Achievement Awards </h3>

                        These Awards are presented to educators whose body of work demonstrates a high level of
                        outstanding achievement in the field of School Administration and Management. The nomination
                        should clearly describe the role of the individual's work.
                    </p>

                    <p>
                        <h3>Young Scholar Awards</h3>

                        The Young Scholar Awards are given to educators who will not be older than 40 years of age and
                        who has made significant contributions to the field of School Administration and Management. The
                        nomination should summarize the contributions of the candidate to the field. The nominee must be
                        a member of ISAM.
                    </p>

                    <p class="mt-8">
                        <a href="contact.html"
                            class="relative p-3 text-white uppercase border-2 border-yellow-500 hover:text-black bg-scale-in">
                            <span class="relative z-10">
                                Contact Us for More Information
                            </span>
                        </a>
                    </p>

                </div>
            </div>
            <div>
                <div class="mb-8 lg:mb-20">
                    <h3>Submission of Nominations</h3>
                    <p>

                        The nominator must send a letter of nomination,
                        at least two supporting letters, and a current
                        curriculum vita for the nominee.
                         Previous nominations not awarded will require re-nomination.
                        The nominee cannot be a member of any of the awards committees.
                    </p>
                    <p>For the Student Scholar Award, only a single letter of nomination from the nominee's academic
                        supervisor is required. This letter of nomination should be accompanied by an abstract summary
                        of the nominee's research, using the form that is required for submission of abstracts to the
                        ISAM Congress. If the nominee submits the same abstract for consideration of inclusion in the
                        Congress program, they should check the box on the abstract form that indicates that it has been
                        nominated for the Student Research Award.
                    </p>
                      <p class="mt-8">
                        <a href="contact.html"
                            class="relative p-3 text-white uppercase border-2 border-yellow-500 hover:text-black bg-scale-in">
                            <span class="relative z-10">
                                Contact Us for More Information
                            </span>
                        </a>
                    </p>
                </div>
            </div>
            <div>
                <img src="/storage/pages/awards_2.jpg" class="block w-11/12 mx-auto h-80" alt="">
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

@endsection
