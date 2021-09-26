@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="/css/file.css">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <x-admin-card-tool title="New Event">
                <a href="{{route('admin.events')}}" target="_blank" class="text-white btn btn-success btn-sm">
                    Events
                </a>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="col-12">
                        <div class="card-body">
                            <form method="POST" @submit.prevent="submit($event)"
                                action="{{route('admin.events.store')}}">
                                @csrf
                                <div class="row">
                                    <div class="order-2 col-lg-7 col-12 order-lg-0">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control required tinymce" name="description" placeholder="Brief description about the event" rows="12"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-5 order-lg-1 order-0">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input class="form-control required" type="text" name="title" placeholder="title" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label>Price</label>
                                            <input class="form-control" type="text" inputmode="numeric" pattern="([\d]+)(\.)?(\d{1,2})"
                                                name="price" autocomplete="off" placeholder="Ticket Fee">
                                        </div>
                                        <div class="form-group">
                                            <label for="cat">Category</label>
                                            <select data-placeholder="Category" id="cat" class="form-control select2" required name="category">
                                                <option value=" ">-select-</option>
                                                @foreach ($categories as $p)
                                                    <option value="{{$p->id}}">{{$p->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <h5 class="mb-3">preview Image</h5>
                                            <div class="form-group position-relative"
                                                style="background-color:rgba(81, 32, 128, 0.787)">
                                                <input @change.prevent="previewSelected($event, 'image', false)" id="image" class="form-control-file"
                                                    type="file" name="image" accept="image/*">
                                                <label for="image" class="text-center">
                                                    <i class="fas fa-plus deeppink"></i>
                                                </label>
                                            </div>
                                            <div class="row selected-files" v-if="files.image && files.image.length">
                                                <div
                                                    class="px-3 col-12 select-cover-photo selected preview-file featured-photo">
                                                    <img :src="fileSrc(files.image[0].file)" alt="preview"
                                                        class="cursor-pointer preview-img">
                                                    <i class="remove-image"
                                                        @click.prevent="removeFile('image', 0)">×</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="order-2 col-12 bg-success">
                                    <div class="order-2 my-2 col-12">
                                        <div class="row">
                                            <div class="form-group col-md-6 col-12">
                                                <label for="address">Address</label>
                                                <input id="address" class="form-control wtk required" type="text" name="address" placeholder="address">
                                            </div>
                                            <div class="form-group col-md-6 col-12">
                                                <label for="start_at">Start Time</label>
                                                <input id="start_at" class="form-control wtk required" type="datetime-local" name="start_at">
                                            </div>
                                            <div class="form-group col-md-6 col-12">
                                                <label for="end_at">End Time</label>
                                                <input id="end_at" class="form-control wtk required" type="datetime-local" name="end_at">
                                            </div>
                                            <div class="mt-4 form-group col-6">
                                                <div class="checkbox checkbox-primary p-t-0">
                                                    <input id="active" type="checkbox"
                                                        class="form-check-input form-control" checked name="active" value="1">
                                                    <label for="active">
                                                        Active
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
