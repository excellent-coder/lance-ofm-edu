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
<li class="nav-item  @if ($segment == 'notifications') menu-open @endif">
    <a href="#" role="button" class="nav-link @if ($segment == 'notifications') active @endif ">
        <i class="fas fa-signal nav-icon"></i>
        <p>
        Notifications
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('admin.notifications')}}" class="nav-link @if ($route == 'notifications') active @endif">
                <i class="fas fa-list nav-icon"></i>
                <p>
                    notifications
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.notifications.create')}}" class="nav-link @if ($route == 'notifications.create') active @endif">
                <i class="fas fa-edit nav-icon"></i>
                <p>New Notification</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.notifications.categories')}}" class="nav-link @if ($route == 'notifications.categories') active @endif">
                <i class="fas fa-portrait nav-icon"></i>
                <p>Categories</p>
            </a>
        </li>
    </ul>
</li>
 <li class="nav-item">
     <a href="javascript:void()" role="button" class="nav-link @if ($segment == 'journals') active @endif ">
          <i class="fas fa-journal-whills nav-icon"></i>
         <p>
            Journals
             <i class="fas fa-angle-left right"></i>
         </p>
     </a>
     <ul class="nav nav-treeview">
         <li class="nav-item">
             <a href="{{route('admin.journals')}}" class="nav-link @if ($route == 'journals') active @endif">
                 <i class="fas fa-journal-whills nav-icon"></i>
                 <p>Journals</p>
             </a>
         </li>
         <li class="nav-item">
             <a href="{{route('admin.journals.create')}}" class="nav-link @if ($route == 'journals.create') active @endif">
                 <i class="fas fa-edit nav-icon"></i>
                 <p>Journal</p>
             </a>
         </li>
     </ul>
 </li>
