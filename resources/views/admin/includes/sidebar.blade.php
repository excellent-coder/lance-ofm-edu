@php
$segments = Request::segments();
if(empty($segments[1])){
$segment = 'dashboard';
}else{
$segment = $segments[1];
}
$url = end($segments);
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="/storage/web/logo.png" alt="{{$web_title}}" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">{{$web_title}}</span>
    </a>
    <!-- Sidebar -->
    <div class="mb-5 sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="pb-3 mt-3 mb-3 user-panel d-flex">
            <div class="image">
                <img src="/storage/web/logo.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{Auth::user()->name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('admin.dashboard')}}"
                        class="nav-link @if ($segment=='dashboard' && $url == 'admin') active @endif ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item  @if ($segment == 'pages') menu-open @endif">
                    <a href="#" class="nav-link @if ($segment == 'pages') active @endif ">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Pages
                            <i class="fas fa-angle-left right"></i>
                            {{-- <span class="badge badge-info right">6</span> --}}
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.pages')}}" class="nav-link @if ($route == 'pages') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>pages</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.pages.create')}}"
                                class="nav-link @if ($route == 'pages.create') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>create</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.user-categories')}}"
                        class="nav-link @if ($route == 'user-categories') active @endif">
                        <i class="fa fa-scissors nav-icon" aria-hidden="true"></i>
                        <p>User Categories</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.applications')}}"
                        class="nav-link @if ($segment == 'applications') active @endif">
                        <i class="fas fa-book-open nav-icon"></i>
                        <p>Applications</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.subjects')}}" class="nav-link @if ($segment == 'subjects') active @endif">
                        <i class="fas fa-book-open nav-icon"></i>
                        <p>Subjects</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.sessions')}}" class="nav-link @if ($segment == 'sessions') active @endif">
                        <i class="fas fa-passport nav-icon"></i>
                        <p>Sessions</p>
                    </a>
                </li>
                <li class="nav-item  @if ($segment == 'lessons') menu-open @endif">
                    <a href="#" class="nav-link @if ($segment == 'lessons') active @endif ">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Lessons
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.lessons')}}"
                                class="nav-link @if ($route == 'lessons') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lessons</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.lessons.create')}}"
                                class="nav-link @if ($route == 'lessons.create') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>create</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item  @if ($segment == 'products') menu-open @endif">
                    <a href="#" class="nav-link @if ($segment == 'products') active @endif ">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                        <p>
                            Products
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.products')}}"
                                class="nav-link @if ($route == 'products') active @endif">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.products.create')}}"
                                class="nav-link @if ($route == 'products.create') active @endif">
                                <i class="far fa-address-book nav-icon"></i>
                                <p>create</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.products.categories')}}"
                                class="nav-link @if ($route == 'products.categories') active @endif">
                                <i class="far fa-address-book nav-icon"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.products.deliveries')}}"
                                class="nav-link @if ($route == 'products.deliveries') active @endif">
                                <i class="fas fa-car nav-icon"></i>
                                <p>Delivery Methods</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.products.d-prices')}}"
                                class="nav-link @if ($route == 'products.d-prices') active @endif">
                                <i class="fas fa-money-bill nav-icon"></i>
                                <p>Delivery Prices</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @include('admin.includes.dirty-sidebar')
                <li class="mb-5 nav-item"></li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
