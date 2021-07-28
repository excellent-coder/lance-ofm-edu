<div class="btn-group btn-group-sm" role="group">
    @php
        $item  = (object) $action;
    @endphp

    @empty ($item->route)
        <button class="btn modal-edit-btn text-primary"
        data-form="{{$item->form}}"
        data-item="{{$item->item}}"
        data-target="#{{$item->modal}}-modal"
        data-update_route="{{$item->update_route}}"
        >
        <i class="fas fa-{{$item->icon??'pencil-alt'}}"></i>
        </button>
        @else
    <a href="{{$item->route}}" class="text-primary">
        <i class="fas fa-{{$item->icon??'pencil-alt'}}"></i>
    </a>
    @endempty
    {{-- load extra buttons --}}
    @isset($item->btns)
    @foreach ($item->btns as $btn)
    {!! $btn !!}
    @endforeach
    @endisset
    {{-- load extra buttons --}}
    <button class="btn action-btn" data-action="{{$item->destroy}}"
    data-id="{{$item->id}}" data-rowid="{{$item->rowid}}">
        <i class="fas fa-trash-alt text-danger"></i>
    </button>
</div>
