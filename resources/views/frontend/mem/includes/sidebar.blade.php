<div class="w-full">
    <div class="flex flex-wrap justify-center pt-5 bg-indigo-800 pb-11 -mt-9 lg:-mt-0">
       <div class="relative w-full">
            <input @change.prevent="updatePassport($event, '{{route('mem.passport')}}')"
                id="update-passport" class="hidden form-control-file" type="file" name="image" accept="image/*" title="Your Passport">
            <img :src="form.passport ? form.passport: `{{asset('storage/'.($auth->passport))}}`" alt="{{$auth->name}}" class="profile-img">
                <label for="update-passport" class="absolute bottom-0 text-white cursor-pointer right-1/3" title="Update Your Passport">
                    <i class="text-white fa fa-camera" aria-hidden="true"></i>
                </label>
        </div>
        <div class="w-full text-center ">
            <p class="text-2xl font-bold text-center text-blue-300 cursor-pointer user-name">
                {{$auth->name }}
                 <br>
                <span class="mt-4 text-xl times-new-romans">
                     {{$auth->membership->name}} Member
                </span>
            </p>
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
                    <a href="{{route('mem')}}" class="sidebar-link">
                        <i class="sidebar-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{route('dashboard')}}" class="sidebar-link">
                        <i class="sidebar-icon fas fa-tachometer-alt"></i>
                        <p>Change Membership</p>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{route('mem.pubs')}}" class="sidebar-link">
                        <i class="sidebar-icon fas fa-tachometer-alt"></i>
                        <p>Publications</p>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{route('mem.events')}}" class="sidebar-link">
                        <i class="sidebar-icon fas fa-envelope-open"></i>
                        <p>My Events</p>
                    </a>
                </li>
                <li class="sidebar-item has-children">
                    <a href="javascript:void()" class="sidebar-link">
                        <i class="fas fa-money-bill-alt sidebar-icon"></i>
                        <p>
                         Billings
                        </p>
                    </a>
                    <ul class="mt-3 nav-children">
                        <li class="nav-item">
                            <a href="{{route('mem.bills')}}" class="sidebar-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>Bills</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('mem.bills.paid')}}" class="sidebar-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>Transactions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('mem.bills.pending')}}" class="sidebar-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>Pending</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item has-children">
                    <a href="javascript:void()" class="sidebar-link">
                        <i class="fas fa-ticket-alt sidebar-icon "></i>
                        <p>License</p>
                    </a>
                    <ul class="mt-3 nav-children">
                        <li class="nav-item">
                            <a href="{{route('mem.license')}}" class="sidebar-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>My License</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('mem.license.all')}}" class="sidebar-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>Buy License</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('mem.license.expeired')}}" class="sidebar-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>Experied License</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('mem.license.payments')}}" class="sidebar-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>Transactions</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="{{route('logout')}}" class="sidebar-link" title="logout">
                        <i class="text-red-500 sidebar-icon fas fa-power-off"></i>
                        <p><i class="fas fa-sign-out-alt "></i>
                            <span class="inline md:hidden">
                                Logout
                            </span>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
