<div class="w-full">
    <div class="relative flex flex-wrap justify-center pt-5 bg-indigo-800 pb-11 -mt-9 lg:-mt-0">
        <div class="relative w-full">
            <input @change.prevent="updatePassport($event, '{{route('pgs.passport')}}')"
                id="update-passport" class="hidden form-control-file" type="file" name="image" accept="image/*" title="Your Passport">
            <img :src="form.passport ? form.passport: `{{asset('storage/'.($auth->passport))}}`" alt="{{$auth->name}}" class="profile-img">
                <label for="update-passport" class="absolute bottom-0 text-white cursor-pointer right-1/3" title="Update Your Passport">
                    <i class="text-white fa fa-camera" aria-hidden="true"></i>
                </label>
        </div>
        <div class="w-full text-center ">
            <p class="text-2xl font-bold text-center text-blue-300 cursor-pointer user-name">
                {{$auth->name}}
                <br>
                <span class="mt-4 text-xl times-new-romans">LEVEL {{$auth->level->name ?? '1'}}</span>
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
                    <a href="{{route('pgs')}}" class="sidebar-link">
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
