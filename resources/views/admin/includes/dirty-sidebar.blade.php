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
             <a href="{{route('admin.settings')}}" class="nav-link @if ($route == 'settings') active @endif">
                 <i class="fas fa-bars nav-icon"></i>
                 <p>Settings</p>
             </a>
         </li>
         @foreach ($settingTags as $tag)
            <li class="nav-item">
                <a href="{{route('admin.settings.edit', $tag->slug)}}" class="nav-link @if ($url == $tag->slug) active @endif">
                    <i class="fas fa-bars nav-icon"></i>
                    <p>{{$tag->tag}}</p>
                </a>
            </li>
         @endforeach
     </ul>
 </li>
