<?php
// use App\Models\Application;
// $programms = Application::whereNotNull('approved_at')
// ->where('user_id', Auth::id());
?>
<div class="w-full">
    <div class="flex justify-center flex-wrap pt-5 pb-11 bg-indigo-800 -mt-9 lg:-mt-0">
        <img src="{{asset('storage/'.(Auth::user()->profile->photo??'web/profile.jpg'))}}" alt="{{Auth::user()->name}}"
            class="profile-img">
        <div class=" w-full text-center">
            <p class="user-name text-blue-300 font-bold text-2xl cursor-pointer text-center">
                {{Auth::user()->name??'New Student'}}
            </p>
            <a href="{{route('portal.profile.edit')}}" class="shadow-md rounded-3xl inline-block
                text-white px-3 py-2 font-medium border-2 border-opacity-75 mt-7
                focus:bg-blue-700 focus:text-red-200 hover:bg-yellow-200 hover:text-green-800">
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
                <li class="sidebar-item has-children">
                    <a href="#" class="sidebar-link">
                        <i class="sidebar-icon fa fa-street-view"></i>
                        <p>
                            Application
                        </p>
                    </a>
                    <ul class="nav-children mt-3">
                        @foreach ($userCats as $uc)
                        <li class="nav-item">
                            <a href="{{route('portal.application.create', $uc->slug)}}" class="sidebar-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>{{$uc->name}}</p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                @foreach ($programms as $pr)
                 @php
                            $parent = $pr->category->parent;
                            $super = $pr->category->superParent;
                            if(!$super && $parent){
                                $super = $parent->superParent;
                            }
                             $super_subjects=collect([]);
                              $parent_subjects=collect([]);
                            if($super){
                                $super_subjects =  $super->subjects;
                            }
                            if($parent){
                                $parent_subjects =  $parent->subjects;
                            }

                            $main_subjects =  $pr->category->subjects;

                            $subjects =
                                    $super_subjects
                                   ->merge($parent_subjects)
                                   ->merge($main_subjects);
                            if($subjects->count()<1){
                                continue;
                            }
                        @endphp

                <li class="sidebar-item has-children">
                    <a href="#" class="sidebar-link">
                        <i class="sidebar-icon fa fa-chalkboard-teacher"></i>
                        <p>
                            {{$pr->category->name}}
                        </p>
                    </a>
                    <ul class="nav-children">

                        @foreach ($subjects as $s)
                        <li class="nav-item">
                            <a href="{{route('portal.subjects', $s->slug)}}" class="sidebar-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>{{$s->name}}</p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                @endforeach
            </ul>
        </nav>
    </div>
</div>
