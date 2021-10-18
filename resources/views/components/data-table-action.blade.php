<div class="btn-group btn-group-sm" role="group">
    @php
        $item  = (object) $action;
    @endphp

    @isset ($item->item)
        <button class="btn modal-edit-btn text-primary"
        data-form="{{$item->form}}"
        data-item="{{$item->item}}"
        data-target="#{{$item->modal}}-modal"
        data-update_route="{{$item->update_route}}"
        title="Quick Edit"
        >
        <i class="fas fa-{{$item->icon??'pencil-alt'}}"></i>
        </button>
        @endisset
        @isset($item->route)
    <a href="{{$item->route}}" class="text-primary" title="edit">
        <i class="fas fa-{{$item->icon??'pencil-alt'}}"></i>
    </a>
    @endisset
    {{-- load extra buttons --}}
    @isset($item->btns)
    @foreach ($item->btns as $btn)
    {!! $btn !!}
    @endforeach
    @endisset
    {{$slot}}
    {{-- load extra buttons --}}
    @isset ($item->destroy)
        <button class="btn action-btn" data-action="{{$item->destroy}}"
        data-id="{{$item->id}}" data-rowid="{{$item->rowid}}" title="permanently delete">
            <i class="fas fa-trash-alt text-danger"></i>
        </button>
    @endisset
</div>
