<nav class="w-full" id="navbar">
    <div class="flex flex-wrap justify-between w-full px-6 navbar">
        <div class="w-20 sidebar" id="sidebar">
            <button>
                <i class="fas fa-bars"></i>
            </button>
            <div class="absolute z-10 w-auto h-auto py-3 pl-3 bg-gray-100 shadow-sm box" id="side-box">
                @include('includes.shop.sidebar')
            </div>
        </div>
        <a href="{{route('home')}}" class="w-40 text-center logo">
            <img class="inline-block" src="/storage/{{web_setting('general', 'logo')}}" style="height: 30px" />
        </a>
        <form action="" @submit.prevent class="w-1/2">
            <div class="flex flex-wrap nav-search">
                <i class="absolute fa fa-search left-icon" aria-hidden="true"></i>
                <input type="search" class="nav-search-input" placeholder="search products, brands and categories">
                <button class="text-white bg-blue-700 w-1/7" type="submit">SEARCH</button>
            </div>
        </form>
        <ul class="flex flex-wrap w-1/4 justify-evenly">
            <li class="relative nav-item">
                <button>
                    <i class="fas fa-user-graduate"></i>
                    Account
                    <i class="fas fa-angle-down"></i>
                    <i class="fas fa-angle-up"></i>

                </button>
                <ul class="absolute left-0 z-50 grid grid-cols-1 bg-gray-100 nav-sub w-60 top-10">
                    <a class="block mx-3 my-3 text-lg font-semibold text-center text-white transition-all bg-yellow-500 hover:bg-yellow-600" href="#">
                            SIGN IN
                    </a>
                    <hr class="w-full bg-gray-700">
                    <a class="block px-3" href="#">
                        <i class="mr-4 fas fa-user-graduate" aria-hidden="true"></i>
                        My Account
                    </a>
                    <a class="block px-3" href="#">
                        <i class="mr-4 far fa-calendar" aria-hidden="true"></i>
                        Orders
                    </a>
                    <a class="block px-3" href="#">
                        <i class="mr-4 far fa-heart"></i>
                        Saved Items
                    </a>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#" @click.prevent>
                    <i class="far fa-question-circle "></i>
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
