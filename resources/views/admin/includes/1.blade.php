

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
            <a href="{{route('admin.notifications.create')}}"
                class="nav-link @if ($route == 'notifications.create') active @endif">
                <i class="fas fa-edit nav-icon"></i>
                <p>New Notification</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.notifications.categories')}}"
                class="nav-link @if ($route == 'notifications.categories') active @endif">
                <i class="fas fa-portrait nav-icon"></i>
                <p>Categories</p>
            </a>
        </li>
    </ul>
</li>
