@php
$segments = Request::segments();
if(empty($segments[1])){
$segment = 'dashboard';
}else{
$segment = $segments[1];
}
$url = end($segments);
$logo = web_setting('general', 'logo');
$title = web_setting('general', 'title');
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="/storage/{{$logo}}" alt="{{$title}}" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{$title}}</span>
    </a>
    <!-- Sidebar -->
    <div class="mb-5 sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="pb-3 mt-3 mb-3 user-panel d-flex">
            <div class="image">
                <img src="/storage/{{$logo}}" class="img-circle elevation-2" alt="User Image">
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
                <li class="nav-item">
                    <a href="{{route('admin.profile')}}" class="nav-link @if ($route == 'journals') active @endif">
                        <i class="fas fa-user nav-icon"></i>
                        <p>Profile</p>
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
                <li class="nav-item  @if ($segment == 'students') menu-open @endif">
                    <a href="javascript:void()" class="nav-link @if ($segment == 'students') active @endif ">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Students
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.students.approved')}}"
                                class="nav-link @if ($route == 'students.approved') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Approved</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.students.pending')}}"
                                class="nav-link @if ($route == 'students.pending') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pending</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{route('admin.students.graduated')}}"
                                class="nav-link @if ($route == 'students.graduated') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Graduated</p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{route('admin.students.results')}}"
                                class="nav-link @if ($route == 'students.results') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Results</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.students.grades')}}"
                                class="nav-link @if ($route == 'students.grades') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Grading</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.students.fees')}}"
                                class="nav-link @if ($route == 'students.fees') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Fees</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item  @if ($segment == 'members') menu-open @endif">
                    <a href="javascript:void()" class="nav-link @if ($segment == 'members') active @endif ">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Members
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.members')}}"
                                class="nav-link @if ($route == 'members') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Active</p>
                            </a>
                            <a href="{{route('admin.members.approved')}}"
                                class="nav-link @if ($route == 'members.approved') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Approved</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.members.pending')}}"
                                class="nav-link @if ($route == 'members.pending') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pending</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item  @if ($segment == 'scs') menu-open @endif">
                    <a href="javascript:void()" class="nav-link @if ($segment == 'scs') active @endif ">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            S/Students
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.scs')}}" class="nav-link @if ($route == 'scs') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Active</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{route('admin.scs.graduated')}}"
                                class="nav-link @if ($route == 'scs.graduated') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Graduated</p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{route('admin.scs.payments.pending')}}"
                                class="nav-link @if ($route == 'scs.pending.payment') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pending Payments</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.scs.results')}}"
                                class="nav-link @if ($route == 'scs.results') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Results</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.scs.results.create')}}"
                                class="nav-link @if ($route == 'scs.pending.payment') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Upload Results</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{route('admin.sessions')}}" class="nav-link @if ($segment == 'sessions') active @endif">
                        <i class="fas fa-passport nav-icon"></i>
                        <p>Sessions</p>
                    </a>
                </li>

                <li class="nav-item  @if ($segment == 'settings') menu-open @endif">
                    <a href="#" class="nav-link @if ($segment == 'settings') active @endif ">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Settings
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.settings')}}"
                                class="nav-link @if ($route == 'settings') active @endif">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>Settings</p>
                            </a>
                        </li>
                        @foreach ($settingTags as $tag)
                        <li class="nav-item">
                            <a href="{{route('admin.settings.edit', $tag->slug)}}"
                                class="nav-link @if ($url == $tag->slug) active @endif">
                                @if ($tag->icon)
                                <img src="/storage/{{$tag->icon}}" alt="{{$tag->tag}} icon" class="nav-icon">
                                @else
                                <i class="fas fa-life-ring nav-icon"></i>
                                @endif
                                <p>{{$tag->tag}}</p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>

                <li class="nav-item  @if ($segment == 'programs') menu-open @endif">
                    <a href="#" role="button" class="nav-link @if ($segment == 'programs') active @endif ">
                        <i class="nav-icon fas fa-school"></i>
                        <p>
                            Programs
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.programs')}}"
                                class="nav-link @if ($route == 'programs') active @endif">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>Programs</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.programs.create')}}"
                                class="nav-link @if ($route == 'programs.create') active @endif">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>New Program</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{route('admin.levels')}}" class="nav-link @if ($segment == 'levels') active @endif">
                        <i class="fas fa-level-up-alt nav-icon"></i>
                        <p>Levels</p>
                    </a>
                </li>

                <li class="nav-item  @if ($segment == 'courses') menu-open @endif">
                    <a href="#" role="button" class="nav-link @if ($segment == 'courses') active @endif ">
                        <i class="fas fa-book-reader nav-icon"></i>
                        <p>
                            Courses
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.courses')}}"
                                class="nav-link @if ($route == 'courses') active @endif">
                                <i class="fas fa-list nav-icon"></i>
                                <p>
                                    Courses
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.courses.create')}}"
                                class="nav-link @if ($route == 'courses.create') active @endif">
                                <i class="fas fa-edit nav-icon"></i>
                                <p>New Course</p>
                            </a>
                        </li>
                    </ul>
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

                <li class="nav-item  @if ($segment == 'memberships') menu-open @endif">
                    <a href="#" role="button" class="nav-link @if ($segment == 'memberships') active @endif ">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                            Memberships
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.memberships')}}"
                                class="nav-link @if ($route == 'memberships') active @endif">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>All</p>
                            </a>
                        </li>
                        @foreach (App\Models\Membership::all() as $m)
                        <li class="nav-item">
                            <a href="{{route('admin.memberships.members', $m->slug)}}"
                                class="nav-link @if ($url == $m->slug) active @endif">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>{{$m->name}}</p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item  @if ($segment == 'publications') menu-open @endif">
                    <a href="javascript:void(0)" role="button"
                        class="nav-link @if ($segment == 'publications') active @endif ">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                            Publications
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.pubs')}}" class="nav-link @if ($route == 'pubs') active @endif">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>All</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.pubs.cats')}}"
                                class="nav-link @if ($route == 'pubs.cats') active @endif">
                                <i class="fas fa-screwdriver nav-icon"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.pubs.create')}}"
                                class="nav-link @if ($route == 'pubs.create') active @endif">
                                <i class="fas fa-pen-alt nav-icon"></i>
                                <p>New</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item  @if ($segment == 'events') menu-open @endif">
                    <a href="#" role="button" class="nav-link @if ($segment == 'events') active @endif ">
                        <i class="fas fa-id-card nav-icon"></i>
                        <p>
                            Events
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.events')}}" class="nav-link @if ($route == 'events') active @endif">
                                <i class="fas fa-list nav-icon"></i>
                                <p>
                                    Events
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.events.create')}}"
                                class="nav-link @if ($route == 'events.create') active @endif">
                                <i class="fas fa-edit nav-icon"></i>
                                <p>New Event</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.events.categories')}}"
                                class="nav-link @if ($route == 'events.categories') active @endif">
                                <i class="fas fa-portrait nav-icon"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item  @if ($segment == 'licences') menu-open @endif">
                    <a href="javascript:void()" role="button" class="nav-link @if ($segment == 'licences') active @endif ">
                        <i class="fas fa-id-card nav-icon"></i>
                        <p>
                            Licences
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.licences')}}"
                                class="nav-link @if ($route == 'licences') active @endif">
                                <i class="fas fa-list nav-icon"></i>
                                <p> Licences </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.licences.create')}}"
                                class="nav-link @if ($route == 'licences.create') active @endif">
                                <i class="fas fa-edit nav-icon"></i>
                                <p>New Licence</p>
                            </a>
                        </li>
                    </ul>
                </li>
                 <li class="nav-item">
                    <a href="{{route('admin.exam-c')}}" class="nav-link @if ($route == 'exam-c') active @endif">
                        <i class="fas fa-home nav-icon" aria-hidden="true"></i>
                        <p>Exam Centers</p>
                    </a>
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

                <li class="nav-item  @if ($segment == 'posts') menu-open @endif">
                    <a href="#" role="button" class="nav-link @if ($segment == 'post') active @endif ">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Posts
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.posts')}}" class="nav-link @if ($route == 'posts') active @endif">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>Posts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.posts.create')}}"
                                class="nav-link @if ($route == 'posts.create') active @endif">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>New</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.posts.categories')}}"
                                class="nav-link @if ($route == 'posts.categories') active @endif">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.posts.tags')}}"
                                class="nav-link @if ($route == 'posts.tags') active @endif">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>Tags</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item  @if ($segment == 'posts') menu-open @endif">
                    <a href="#" role="button" class="nav-link @if ($segment == 'images') active @endif ">
                        <i class="nav-icon fas fa-images"></i>
                        <p>
                            Images
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.images')}}" class="nav-link @if ($route == 'images') active @endif">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>Images</p>
                            </a>
                        </li>
                        @foreach ($imageParts as $imgPart)
                        <li class="nav-item">
                            <a href="{{route('admin.images.part', $imgPart->part)}}"
                                class="nav-link @if ($url == $imgPart->part) active @endif">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>{{$imgPart->part}}</p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                @include('admin.includes.1')
                @include('admin.includes.dirty-sidebar')
                <li class="mb-5 nav-item"></li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
