@php
    $auth = auth('pgs')->user();
@endphp
<div class="w-full">
    <div class="flex flex-wrap justify-center pt-5 bg-indigo-800 pb-11 -mt-9 lg:-mt-0">
        <img src="{{asset('storage/'.($auth->image))}}" alt="{{$auth->first_name}}"
            class="profile-img">
        <div class="w-full text-center ">
            <p class="text-2xl font-bold text-center text-blue-300 cursor-pointer user-name">
                {{"$auth->last_name $auth->first_name"}}
                <br>
                <span class="mt-4 text-xl times-new-romans">LEVEL 1</span>
            </p>
            <a href="{{route('pgs.profile.edit')}}" class="inline-block px-3 py-2 font-medium text-white border-2 border-opacity-75 shadow-md rounded-3xl mt-7 focus:bg-blue-700 focus:text-red-200 hover:bg-yellow-200 hover:text-green-800">
                update profile
            </a>
        </div>
    </div>
    <div class="flex flex-wrap w-full">
        <nav class="w-full">
            <ul class="collapse-nav">
                <li class="sidebar-item">
                    <a href="{{route('home')}}" class="sidebar-link">
                        <i class="sidebar-icon fas fa-home"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{route('dashboard')}}" class="sidebar-link">
                        <i class="sidebar-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="sidebar-item has-children">
                    <a href="#" class="sidebar-link">
                        <i class="sidebar-icon fa fa-chalkboard-teacher"></i>
                        <p>
                            {{$program->title}}
                        </p>
                    </a>
                    <ul class="nav-children">
                        @foreach ($program->PCourses as $s)
                        <li class="nav-item">
                            <a href="{{route('pgs.course', $s->slug)}}" class="sidebar-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>{{$s->name}}</p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                 <li class="sidebar-item">
                    <a href="{{route('logout')}}" class="sidebar-link">
                        <i class="text-red-500 sidebar-icon fas fa-power-off"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
