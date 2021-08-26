@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="/css/file.css">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <x-admin-card-tool title="New Notification">
                <a href="{{route('admin.notifications')}}" target="_blank" class="text-white btn btn-success btn-sm">
                    Notifications
                </a>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="col-12">
                        <div class="card-body">
                            <form method="POST" @submit.prevent="submit($event)"
                                action="{{route('admin.notifications.store')}}">
                                @csrf
                                <div class="row">
                                    <div class="order-2 col-lg-7 col-12 order-lg-0">
                                        <div class="form-group">
                                            <label>Body</label>
                                            <textarea class="form-control required tinymce" name="body"
                                                rows="12"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-5 order-lg-1 order-0">
                                        <div class="form-group">
                                            <label for="title">Subject</label>
                                            <input class="form-control required" type="text" name="subject"
                                                placeholder="subject" autocomplete="on">
                                        </div>
                                        <div class="form-group">
                                            <label for="cat">Receivers</label>
                                            <select data-placeholder="Receivers" id="cat"
                                             class="form-control select2 required"
                                                name="receivers">
                                                <option value=" ">-select-</option>
                                                @foreach ($categories as $p)
                                                <option value="{{$p->id}}">{{$p->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="my-3 checkbox checkbox-primary">
                                            <input id="published" type="checkbox" class="form-check-input form-control"
                                                name="published" value="1">
                                            <label for="published">
                                                Published
                                            </label>
                                        </div>
                                    </div>
                                    <hr class="order-2 col-12 bg-success">
                                </div>
                                <button class="btn btn-block btn-success btn-lg">submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
    <x-admin-modal title="Managing subjects">
    </x-admin-modal>
</div>
@endsection
@section('js')
<script src="/vendor/tinymce/tinymce.min.js"></script>
@endsection
