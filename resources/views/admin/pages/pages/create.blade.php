@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="/css/file.css">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <x-admin-card-tool title="Create An Awesome Page"></x-admin-card-tool>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="POST" @submit.prevent="submit($event)" action="{{route('admin.pages.store')}}">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-lg-8">
                                    <div class="form-group">
                                        <label for="body">Body</label>
                                        <textarea class="form-control required tinymce" name="description"
                                            rows="12"></textarea>
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
                                        <input class="form-control required" type="text" v-model="slugTitle"
                                            name="title" placeholder="title">
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="title">Unique Name</label>
                                        <input class="form-control" type="text" name="name"
                                            placeholder="unique name">
                                    </div> --}}
                                    <div class="text-right form-group">
                                        <small class="mr-3 text-left text-muted">Conevert title to the page url</small>
                                        <label class="switch">
                                            <input type="checkbox" value="1" v-model="updateSlug">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="slug">Slug</label>
                                        <input class="form-control required" type="text" data-prefix="{{url('pages')}}"
                                            v-model="slug" name="slug" placeholder="slug">
                                    </div>
                                    <div class="checkbox checkbox-primary p-t-0">
                                        <input id="featured" type="checkbox" class="form-check-input form-control"
                                            name="published" value="1">
                                        <label for="featured">
                                            Published
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <h5 class="mb-3">preview photo
                                            <i class="fas fa-info-circle" data-toggle="tooltip"
                                                title="This image is used for open graph. Use the editor to add images to your page">
                                            </i>
                                        </h5>
                                        <div class="form-group position-relative"
                                            style="background-color:rgba(81, 32, 128, 0.787)">
                                            <input @change.prevent="previewSelected($event, 'image', false)" id="image"
                                                class="form-control-file" type="file" name="image" accept="image/*">
                                            <label for="image" class="text-center">
                                                <i class="fas fa-plus deeppink"></i>
                                            </label>
                                        </div>
                                        <div class="row selected-files" v-if="files.image && files.image.length">
                                            <div
                                                class="px-3 col-12 select-cover-photo selected preview-file featured-photo">
                                                <img :src="fileSrc(files.image[0].file)" alt="preview"
                                                    class="cursor-pointer preview-img">
                                                <i class="remove-image" @click.prevent="removeFile('image', 0)">×</i>
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
@endsection

@section('js')
<script src="/vendor/tinymce/tinymce.min.js"></script>
@endsection
