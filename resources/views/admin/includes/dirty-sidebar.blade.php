 {{-- <li class="nav-item  @if ($segment == 'programs') menu-open @endif">
     <a href="#" role="button" class="nav-link @if ($segment == 'programs') active @endif ">
         <i class="nav-icon fas fa-school"></i>
         <p>
            Courses
             <i class="fas fa-angle-left right"></i>
         </p>
     </a>
     <ul class="nav nav-treeview">
         <li class="nav-item">
             <a href="{{route('admin.programs')}}" class="nav-link @if ($route == 'programs') active @endif">
                 <i class="fas fa-bars nav-icon"></i>
                 <p></p>
             </a>
         </li>
         <li class="nav-item">
             <a href="{{route('admin.programs.create')}}" class="nav-link @if ($route == 'programs.create') active @endif">
                 <i class="fas fa-plus nav-icon"></i>
                 <p>New Program</p>
             </a>
         </li>
     </ul>
 </li> --}}

<li class="nav-item">
    <a href="{{route('admin.courses')}}" class="nav-link @if ($route == 'courses') active @endif">
        <i class="fas fa-book-reader nav-icon"></i>
        <p>Courses</p>
    </a>
</li>

