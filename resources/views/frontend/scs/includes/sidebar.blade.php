<div class="w-full">
    <div class="flex flex-wrap justify-center pt-5 bg-indigo-800 pb-11 -mt-9 lg:-mt-0">
        <img src="{{asset('storage/'.(Auth::user('scs')->dp ?? 'web/profile.jpg'))}}" alt="{{Auth::user()->name}}"
            class="profile-img">
        <div class="w-full text-center ">
            <p class="text-2xl font-bold text-center text-blue-300 cursor-pointer user-name">
                {{auth('scs')->user()->first_name }}
            </p>
            <a href="{{route('portal.profile.edit')}}" class="inline-block px-3 py-2 font-medium text-white border-2 border-opacity-75 shadow-md rounded-3xl mt-7 focus:bg-blue-700 focus:text-red-200 hover:bg-yellow-200 hover:text-green-800">
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
                    <a href="/portal" class="sidebar-link">
                        <i class="sidebar-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{route('scs.programs.apply')}}" class="sidebar-link">
                        <i class="sidebar-icon fas fa-home"></i>
                        <p>Apply For Program</p>
                    </a>
                </li>
                <li class="sidebar-item has-children">
                    <a href="#" class="sidebar-link">
                        <i class="sidebar-icon fa fa-street-view"></i>
                        <p>
                         All  Programs
                        </p>
                    </a>
                    <ul class="mt-3 nav-children">
                        @foreach ($programs as $p)
                        <li class="nav-item">
                            <a href="{{route('portal.application.create', $p->slug)}}" class="sidebar-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>{{$p->abbr}}</p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                <li class="sidebar-item has-children">
                    <a href="#" class="sidebar-link">
                        <i class="sidebar-icon fa fa-street-view"></i>
                        <p>
                         Your Programs
                        </p>
                    </a>
                    <ul class="mt-3 nav-children">
                        @foreach ($userPrograms as $up)
                        @php
                         if($up->visibility == 2 || !$up->active){
                             continue;
                         }
                        @endphp
                        <li class="nav-item">
                            <a href="{{route('scs.program', $up->slug)}}" class="sidebar-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>{{$up->abbr}}</p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
