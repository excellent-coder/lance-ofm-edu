@extends('layouts.admin')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="/vendor/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/vendor/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="/vendor/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <x-admin-card-tool title="{{$tag->tag}} Settings">
                <button class="text-white btn btn-success btn-tool dropdown-toggle btn-sm" data-target="#general-modal"
                    @click="modalEdit($event.target, true)" data-form="general-modal-form"
                    data-store_route="{{route('admin.settings.storetag')}}">
                    New setting in {{Str::ucfirst($tag->tag)}}
                </button>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="col-12 col-md-10 offset-md-2 col-lg-8 offset-lg-2">
                        <form action="{{route('admin.settings.update', $tag->id)}}" autocomplete="off"
                            @submit.prevent="submit($event)" id="general-modal-form">
                            @foreach ($tag->settings as $s)
                            <div class="form-group">
                                <label class=" d-block" for="{{$s->title}}">{{$s->name}}</label>
                                <p><span class="badge badge-primary">title</span> {{$s->title}}</p>
                                <p>Type <span class="badge badge-danger">{{$s->type}}</span></p>
                            @switch($s->type)
                            @case('text')
                                <textarea class="form-control" name="{{$s->title}}"
                                    placeholder="{{Str::ucfirst($s->name)}}" rows="3">{{$s->value}}</textarea>
                            @break
                            @case('image')
                            @if ($s->title == 'favicon')
                            <img class="my-1 img img-fluid img-sm d-block" src="/{{$s->value}}" alt="preview {{$s->name}}">
                            @else
                            <img class="my-1 img img-fluid img-sm d-block" src="/storage/{{$s->value}}" alt="preview {{$s->name}}">
                            @endif
                            @case('video')
                                <input id="{{$s->title}}" class="form-control-file" type="file" name="{{$s->title}}">
                            @break
                            @endswitch
                            </div>
                            @endforeach
                            <div class="my-2 text-center form-group">
                                <button type="submit" class="btn btn-success">update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
    <x-admin-modal title="New Setting in {{Str::ucfirst($tag->tag)}}">
        <form action="{{route('admin.settings.store', $tag->id)}}" autocomplete="off" @submit.prevent="submit($event)"
            id="general-modal-form">
            <div class="form-group">
                <label>Title</label>
                <input class="form-control" placeholder="title" type="text" name="title">
            </div>

            <div class="form-group">
                <label for="type">Type</label>
                <select id="type" class="form-control" name="type" v-model="form.type">
                    <option value="">Type of setting value</option>
                    <option value="text" selected>Text</option>
                    <option value="file">Image</option>
                    <option value="file">Video</option>
                </select>
            </div>

            <div class="form-group" v-if="form.type=='file'">
                <label for="my-input">Choose File</label>
                <input id="my-input" class="form-control-file" type="file" name="file">
            </div>

            <div class="form-group"  v-if="form.type=='text' ||!form.type">
                <label>Excerpt</label>
                <textarea class="form-control" placeholder="value" name="value" rows="3"></textarea>
            </div>
            <div class="my-2 text-right form-group">
                <button type="submit" class="btn btn-success">create</button>
            </div>
        </form>
    </x-admin-modal>
</div>
@endsection

@section('js')

@endsection
