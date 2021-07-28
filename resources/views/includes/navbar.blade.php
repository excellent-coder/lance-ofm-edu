<nav class="flex items-center bg-indigo-500 p-3 md:pr-10 z-50 main-nav justify-between" id="main-nav">
    <a href="{{route('home')}}">
    <img class="" src="/storage/web/logo.png" style="height: 30px" />
    </a>
    <div class="block lg:hidden pr-4">
        <button class="
                flex
                items-center
                px-3
                py-2
                border
                rounded
                text-teal-200
                border-teal-400
                hover:text-white
                hover:border-white
            " @click.prevent="toggleNav('navbar')">
            <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <title>Menu</title>
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
            </svg>
        </button>
    </div>
    <div class="w-full lg:flex lg:justify-end bg-indigo-500" id="navbar">
        <span class="block lg:hidden cursor-pointer" @click.prevent="toggleNav('navbar')">
            <i class="fas fa-times"></i>
            hide
        </span>
        <li class="nav-item mt-4">
            <a href="{{route('shop')}}" class="text-white hover:text-pink-200">
                Shop
            </a>
        </li>
        <li class="nav-item mt-4">
            <a href="{{route('portal.index')}}" class="text-white hover:text-pink-200">
                portal
            </a>
        </li>
        <li class="nav-item mt-4">
            <button  class="text-white hover:text-pink-200 border-2 border-red-50 shadow-md px-2" @click.prevent="$store.commit('modal', 'donate')">
                Donate
            </button>
        </li>
        @guest
        <li class="nav-item">
            <button class="text-white hover:text-pink-200" @click.prevent="$store.commit('modal', 'login')">
            login
            </button>
        </li>
        <li class="nav-item">
            <button class="text-white hover:text-pink-200"  @click.prevent="$store.commit('modal', 'register')">
            register
            </button>
        </li>
        @endguest
         <li class="nav-item mt-4">
            <a href="{{route('admin.dashboard')}}" class="text-white hover:text-pink-200">
                Admin
            </a>
        </li>
    </div>
</nav>

