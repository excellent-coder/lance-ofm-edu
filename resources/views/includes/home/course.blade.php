<div class="w-full py-10 bg-gray-200 lg:py-20">
    <div class="flex flex-wrap justify-center w-full mb-8">
        <div class="w-full text-center lg:w-1/2">
            <h1 class="my-3 text-3xl font-semibold text-center text-gray-800">Courses</h1>
            <div class="text-gray-600 ">
                {!! $coursePage->description !!}
            </div>
        </div>
    </div>
    <div class="flex justify-center w-full ">
        <div class=" lg:w-5/6">
            <div class="timeline">
                <div class="timeline__wrap">
                    <div class="timeline__items">
                        @foreach ($courses as $course)
                            <div class="timeline__item">
                                <div class="timeline__content" @if($course->image) style="background-image: url(/storage/{{$course->image}})" @endif>
                                        <h2>{{$course->name}}</h2>
                                    <p>{{$course->excerpt}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-black lg:p-10">
    <div class="grid grid-cols-3 text-white">
        <div>
            <div class="flex w-full bg-yellow-500">
                <span class="block p-4 ml-2 text-6xl text-black bg-white">
                    <i class="flaticon-study"></i>
                </span>
                <div class="p-4 ml-2 text-4xl font-bold">
                    <p class="font-black ">8</p>
                    <h3>Membership Categories</h3>
                </div>
            </div>
        </div>
        <div>
            <div class="flex w-full bg-yellow-500">
                <span class="block p-4 ml-2 text-6xl text-black bg-white">
                    <i class="flaticon-online"></i>
                </span>
                <div class="p-4 ml-2 text-4xl font-bold">
                    <p class="font-black ">6</p>
                    <h3>Courses Categories</h3>
                </div>
            </div>
        </div>
        <div>
            <div class="flex w-full bg-yellow-500">
                <span class="block p-4 ml-2 text-6xl text-black bg-white">
                    <i class="flaticon-years"></i>
                </span>
                <div class="p-4 ml-2 text-4xl font-bold">
                    <p class="font-black ">100</p>
                    <h3>Short Courses</h3>
                </div>
            </div>
        </div>
    </div>
</div>
