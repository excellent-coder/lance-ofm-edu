<aside class="control-sidebar control-sidebar-dark">
    {{$title}}
    <div>
        <a href="{{route('admin.logout')}}">Logout</a>
      {{$slot}}
    </div>
</aside>
