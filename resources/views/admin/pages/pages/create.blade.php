@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="/css/file.css">

@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <x-admin-card-tool title="All Pages" :links="$cardLinks">
            </x-admin-card-tool>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="POST" @submit.prevent="submit($event)"
                            action="{{route('admin.pages.store')}}">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-lg-8">
                                    <div class="form-group">
                                        <label for="body">Body</label>
                                        <textarea class="form-control required tinymce" name="body" rows="12"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Excerpt</label>
                                        <textarea placeholder="excerpt" class="form-control" name="excerpt"
                                            rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input class="form-control required" type="text" v-model="slugTitle" name="title" placeholder="title">
                                    </div>
                                    <div class="form-group text-right">
                                        <small class="text-muted text-left mr-3">Conevert title to the page url</small>
                                        <label class="switch">
                                            <input type="checkbox" value="1" v-model="updateSlug">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="slug">Slug</label>
                                        <input class="form-control required" type="text" v-model="slug" name="slug" placeholder="slug">
                                    </div>
                                    <div class="form-group">
                                        <label>Status
                                            <i class="fas fa-info-circle" data-toggle="tooltip"
                                                title="Make page active and accessible other save as draft"></i>
                                        </label>
                                        <select class="form-control select2" style="width: 100%;" name="active">
                                            <option value="1" selected>Active</option>
                                            <option value="0">Draft</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <h5 class="mb-3">Choose Open graph
                                            <i class="fas fa-info-circle" data-toggle="tooltip"
                                                title="This image is used for open graph. Use the editor to add images to your page">
                                            </i>
                                        </h5>
                                        <div class="form-group position-relative">
                                            <input @change.prevent="previewSelected($event)" id="image" class="form-control-file" type="file" name="image"
                                                accept="image/*">
                                            <label for="image" class="text-center">
                                                <i class="fas fa-plus deeppink"></i>
                                            </label>
                                        </div>
                                        <div class="row selected-files" id="image_preview" v-if="imageFile">
                                            <div class="col-12 px-3 select-cover-photo selected preview-file featured-photo">
                                                <img :src="imageFile" alt="preview" class="cursor-pointer preview-img">
                                                <i class="remove-image" @click.prevent="removeSelected('image')">×</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-block btn-success  btn-lg">submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="/vendor/tinymce/tinymce.min.js"></script>
@endsection
