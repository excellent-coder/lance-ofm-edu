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
             <a href="{{route('admin.courses')}}" class="nav-link @if ($route == 'courses') active @endif">
                 <i class="fas fa-list nav-icon"></i>
                 <p>
                     Courses
                 </p>
             </a>
         </li>
         <li class="nav-item">
             <a href="{{route('admin.courses.create')}}" class="nav-link @if ($route == 'courses.create') active @endif">
                 <i class="fas fa-edit nav-icon"></i>
                 <p>New Course</p>
             </a>
         </li>
     </ul>
 </li>
  <li class="nav-item  @if ($segment == 'licences') menu-open @endif">
     <a href="#" role="button" class="nav-link @if ($segment == 'licences') active @endif ">
          <i class="fas fa-id-card nav-icon"></i>
         <p>
            Licences
             <i class="fas fa-angle-left right"></i>
         </p>
     </a>
     <ul class="nav nav-treeview">
         <li class="nav-item">
             <a href="{{route('admin.licences')}}" class="nav-link @if ($route == 'licences') active @endif">
                 <i class="fas fa-list nav-icon"></i>
                 <p>
                     Licences
                 </p>
             </a>
         </li>
         <li class="nav-item">
             <a href="{{route('admin.licences.create')}}" class="nav-link @if ($route == 'licences.create') active @endif">
                 <i class="fas fa-edit nav-icon"></i>
                 <p>New Licence</p>
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
             <a href="{{route('admin.events.create')}}" class="nav-link @if ($route == 'events.create') active @endif">
                 <i class="fas fa-edit nav-icon"></i>
                 <p>New Event</p>
             </a>
         </li>
         <li class="nav-item">
             <a href="{{route('admin.events.categories')}}" class="nav-link @if ($route == 'events.categories') active @endif">
                 <i class="fas fa-portrait nav-icon"></i>
                 <p>Categories</p>
             </a>
         </li>
     </ul>
 </li>
