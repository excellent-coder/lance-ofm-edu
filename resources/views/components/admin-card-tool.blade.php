<div class="card-header">
    <h5 class="card-title">{{$title}}</h5>
    <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
        </button>

        <div class="btn-group">
            <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                <i class="fas fa-wrench"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right" role="menu">
        @if($links)
                @foreach ($links as  $l)
                @php
                    $l = (object) $l;
                    if(isset($l->show) && !$l->show){
                        continue;
                    }
                @endphp
                @if($l->type == 'modal')
                <button class="dropdown-item" data-target="#{{$l->route}}-modal" data-toggle="modal">
                    {{$l->title}}
                </button>
                @else
                    <a href="{{$l->route}}" class="dropdown-item">
                    @isset ($l->icon)
                        <i class="fa fa-{{$l->icon}}"></i>
                    @endisset
                        {{$l->title}}
                    </a>
                @endif
                @endforeach
        @endif
                {{$slot}}
            </div>
        </div>
    </div>
</div>
