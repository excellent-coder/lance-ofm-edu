@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="/css/file.css">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6 text-md-left">
                            <h4 class="m-0 text-dark">
                                <span class="badge bg-pink">
                                    Add New Lesson
                                </span>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <x-admin-card-tool title="Lessons">
                <a href="{{route('admin.lessons.create')}}" class="btn-sm">
                    new Lesson
                </a>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="col-12 my-3" style="background-color: indigo;">
                        <div class="row justify-content-end">
                            <a href="{{route('admin.lessons')}}" class="btn btn-success">
                                Lessons
                            </a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card-body">
                            <div class="col-12">
                                <form method="POST" @submit.prevent="submit($event, ['materials'])"
                                    action="{{route('admin.lessons.store')}}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 col-lg-8">
                                            <div class="form-group">
                                                <label for="subject_id">Subject</label>
                                                <select name="subject_id" id="subject_id"
                                                    class=" form-control required select2"
                                                    data-placeholder="choose subject">
                                                    @foreach ($subjects as $s)
                                                    <option value="{{$s->id}}">{{$s->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="title">Topic</label>
                                                <input class="form-control required" type="text"
                                                    name="topic" placeholder="title">
                                            </div>
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea class="form-control required tinymce" name="description"
                                                    rows="4"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-group position-relative" style="background-color:rgba(81, 32, 128, 0.787)">
                                                    <input
                                                        @change.prevent="previewSelected($event, 'materials', '{{route('admin.materials.store')}}')"
                                                        id="materials" class="form-control-file" type="file"
                                                        name="materials" multiple>
                                                    <label for="materials" class="text-center">
                                                        <i class="fas fa-plus deeppink"></i>
                                                    </label>
                                                </div>
                                                <div class="row" v-if="files.materials && files.materials.length">
                                                    <div v-for="(item, index) in files.materials"
                                                        class="col-12 col-md-6 added preview-file"
                                                        v-bind:data-position="index"
                                                        :class="[{'featured-photo':item.featured}]">
                                                        <div>
                                                            <small>
                                                                @{{ item.file.name }} - @{{ size(item.file.size) }}
                                                            </small>
                                                            <small @click.prevent="removeFile('materials', index)"
                                                                v-if="item.removeable" class="remove-image">
                                                                <i class="fa fa-times" aria-hidden="true"></i>
                                                            </small>
                                                            <small v-if="item.uploading" class="remove-image">
                                                                <button class="btn btn-sm" :class="
                                                                    item.canceled
                                                                    ? 'btn-danger'
                                                                    : item.progress < 100
                                                                    ? 'btn-warning'
                                                                    : 'btn-success'
                                                                " :disabled="item.canceled || item.progress==100"
                                                                    @click.prevent="cancelUpload('materials', index)">
                                                                    @{{
                                                                    item.canceled
                                                                    ? "Canceled"
                                                                    : item.progress < 100
                                                                    ? "Cancel"
                                                                    : "Done"
                                                                }}
                                                                </button>
                                                            </small>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-striped text-center"
                                                                :class="['bg-'+item.color]" :style="{width: item.progress+'%'}"
                                                                role="progressbar" v-bind:aria-valuenow="item.progress" aria-valuemin="0"
                                                                aria-valuemax="100">@{{item.file.name}}</div>
                                                        </div>
                                                        <div>
                                                            <hr class="bg-success">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Status
                                                    <i class="fas fa-info-circle" data-toggle="tooltip"
                                                        title="Make page active and accessible other save as draft"></i>
                                                </label>
                                                <select class="form-control select2" name="active">
                                                    <option value="1" selected>Active</option>
                                                    <option value="0">Draft</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <h5 class="mb-3">preview photo
                                                    <i class="fas fa-info-circle" data-toggle="tooltip"
                                                        title="This image is used for open graph. Use the editor to add images to your page">
                                                    </i>
                                                </h5>
                                                <div class="form-group position-relative" style="background-color:rgba(81, 32, 128, 0.787)">
                                                    <input @change.prevent="previewSelected($event, 'image', false)" id="image"
                                                        class="form-control-file" type="file" name="photo"
                                                        accept="image/*">
                                                    <label for="image" class="text-center">
                                                        <i class="fas fa-plus deeppink"></i>
                                                    </label>
                                                </div>
                                                <div class="row selected-files" v-if="files.image && files.image.length">
                                                    <div
                                                        class="col-12 px-3 select-cover-photo selected preview-file featured-photo">
                                                        <img :src="fileSrc(files.image[0].file)" alt="preview"
                                                            class="cursor-pointer preview-img">
                                                        <i class="remove-image"
                                                            @click.prevent="removeFile('image', 0)">×</i>
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
    </div>
</div>
@endsection
@section('js')
<script src="/vendor/tinymce/tinymce.min.js"></script>
@endsection
