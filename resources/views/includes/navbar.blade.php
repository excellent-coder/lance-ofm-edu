<nav class="z-50 flex items-center justify-between p-3 bg-gray-800 md:pr-10 main-nav" id="main-nav">
    <a href="{{route('home')}}">
        <img class="w-11/12" src="/storage/{{web_setting('general', 'logo')}}" />
    </a>
    <div class="block pr-4 text-white lg:hidden">
        <button
            class="flex items-center px-3 py-2 text-teal-200 border border-teal-400 rounded hover:text-white hover:border-white"
            @click.prevent="toggleNav('navbar')">
            <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <title>Menu</title>
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
            </svg>
        </button>
    </div>
    <div class="w-full bg-gray-800 lg:flex lg:justify-end" id="navbar">
        <span class="absolute text-white cursor-pointer left-4 hover:text-yellow-500 top-2 lg:hidden" @click.prevent="toggleNav('navbar')">
            <i class="fas fa-times"></i>
            <span class="sr-only">Hide Menu</span>
        </span>

        <li class="mt-10 nav-item lg:mt-0">
            <a href="#">
                About
            </a>
            <ul class="left-0 p-2 text-gray-900 bg-white sub-menu">
                <a class="dropdown-item" href="{{route('static-pages.about')}}">About Isam</a>
                <a class="dropdown-item" href="{{route('static-pages.journals')}}">Isam Jornal</a>
                <a class="dropdown-item" href="{{route('static-pages.awards')}}">Isam Awards</a>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#">
                Memberships
            </a>
            <ul class="left-0 p-2 text-gray-900 bg-white sub-menu">
                <a class="dropdown-item" href="{{route('static-pages.memberships.student')}}">
                    Student Membership
                </a>
                <a class="dropdown-item" href="{{route('static-pages.memberships.associate')}}">
                    Associate Membership
                </a>
                <a class="dropdown-item" href="{{route('static-pages.memberships.direct')}}">
                    Direct Membership
                </a>
                <a class="dropdown-item" href="{{route('static-pages.memberships.honourary')}}">
                    Honourary Membership
                </a>
                <a class="text-green-600 dropdown-item" href="{{route('mem.apply')}}">
                    Apply For Membership
                </a>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#">
               Programs
            </a>
            <ul class="left-0 p-2 text-gray-900 bg-white sub-menu">
                @foreach ($navPrograms as $nc)
                <a class="dropdown-item" href="{{route('programs.show', $nc->slug)}}">
                    {{$nc->abbr}}
                </a>
                @endforeach
                <a class="dropdown-item" href="{{route('pgs.apply')}}">
                    Apply For Main Student
                </a>
                @guest('scs')
                <a class="dropdown-item" href="{{route('scs.apply')}}">
                    Register For Short Course Student
                </a>
                @endguest
            </ul>
        </li>
        <li class="nav-item">
            <a href="#">
                Licences
            </a>
            <ul class="left-0 p-2 text-gray-900 bg-white sub-menu">
                <a class="dropdown-item" href="/licences/administrator">Licenced School Administrator</a>
                <a class="dropdown-item" href="/licences/manager">Licenced School Manager</a>
                <a class="dropdown-item" href="/licences/consultant">Licenced School Consultant</a>
                <a class="dropdown-item" href="/licences/supplier">Licenced School Supplier</a>
                <a class="dropdown-item" href="/licences/teacher">Licenced School Teacher</a>
            </ul>
        </li>
        <li class="nav-item">
            <a href="{{route('shop')}}">
                Shop
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('static-pages.donate')}}">
                Donate
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('static-pages.contact')}}">
                Contact
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('events.index')}}">
                Events
            </a>
        </li>
        @guest('scs', 'pgs', 'mem')
        <li class="nav-item">
            <a href="login">
                login
            </a>
             <ul class="left-0 p-2 text-gray-900 bg-white sub-menu">
                <a class="dropdown-item" href="{{route('login')}}">Membership</a>
                <a class="dropdown-item" href="{{route('login')}}">Program</a>
                <a class="dropdown-item" href="{{route('login')}}">Short Course</a>
            </ul>
        </li>
        <li class="nav-item">
            <a href="javascript:void()" @click.prevent>
                register
            </a>
            <ul class="left-0 p-2 text-gray-900 bg-white sub-menu">
                <a class="dropdown-item" href="{{route('mem.apply')}}">Membership</a>
                <a class="dropdown-item" href="{{route('pgs.apply')}}">Program</a>
                <a class="dropdown-item" href="{{route('scs.apply')}}">Short Course</a>
            </ul>
        </li>
        @endguest
        @auth()
        @if (auth()->user()->ceo)
        <li class="nav-item">
            <a href="{{route('admin.dashboard')}}">
                Admin
            </a>
        </li>
        @endif
        @endauth
    </div>
</nav>
