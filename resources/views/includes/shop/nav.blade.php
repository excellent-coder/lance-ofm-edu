<nav class="w-full" id="navbar">
    <div class="flex flex-wrap justify-between w-full px-6 navbar">
        <div class="w-20 sidebar" id="sidebar">
            <button>
                <i class="fas fa-bars"></i>
            </button>
            <div class="absolute w-auto h-auto shadow-sm z-10 box pl-3 py-3 bg-gray-100" id="side-box">
                @include('includes.shop.sidebar')
            </div>
        </div>
        <a href="{{route('home')}}" class="w-40 text-center logo">
            <img class="inline-block" src="/storage/web/logo.png" style="height: 30px" />
        </a>
        <form action="" @submit.prevent class="w-1/2">
            <div class="flex flex-wrap nav-search">
                <i class="fa fa-search absolute left-icon" aria-hidden="true"></i>
                <input type="search" class="nav-search-input" placeholder="search products, brands and categories">
                <button class="w-1/7 bg-blue-700 text-white" type="submit">SEARCH</button>
            </div>
        </form>
        <ul class="flex flex-wrap justify-evenly w-1/4">
            <li class="nav-item relative">
                <button>
                    <i class="fas fa-user-graduate"></i>
                    Account
                    <i class="fas fa-angle-down"></i>
                    <i class="fas fa-angle-up"></i>

                </button>
                <ul class="nav-sub grid grid-cols-1 bg-gray-100 z-50 w-60 absolute top-10 left-0">
                    <a class="
                        text-center
                        block hover:bg-yellow-600
                        transition-all bg-yellow-500
                        text-white my-3 mx-3 text-lg
                        font-semibold" href="#">
                            SIGN IN
                    </a>
                    <hr class="w-full bg-gray-700">
                    <a class="block px-3" href="#">
                        <i class="fas fa-user-graduate mr-4" aria-hidden="true"></i>
                        My Account
                    </a>
                    <a class="block px-3" href="#">
                        <i class="far fa-calendar mr-4" aria-hidden="true"></i>
                        Orders
                    </a>
                    <a class="block px-3" href="#">
                        <i class="far fa-heart mr-4"></i>
                        Saved Items
                    </a>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#" @click.prevent>
                    <i class="far fa-question-circle    "></i>
                    Help
                    <i class="fas fa-angle-down"></i>
                    <i class="fas fa-angle-up"></i>
                </a>
            </li>
            <li class="nav-item">
                <a href="" @clicl.prevent>
                    <i class="fa fa-cart-plus"></i>
                    Cart
                </a>
            </li>
        </ul>
    </div>
</nav>
