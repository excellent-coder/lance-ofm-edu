@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="/css/file.css">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <x-admin-card-tool title="Adding A new Course">
            </x-admin-card-tool>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="POST" @submit.prevent="submit($event)" action="{{route('admin.courses.store')}}">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-lg-8">
                                    <div class="form-group">
                                        <label>Short Description</label>
                                        <textarea placeholder="Short Description" class="form-control" name="excerpt"
                                            rows="3"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="body">Long Description</label>
                                        <textarea class="form-control tinymce" name="description" rows="12"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Course</label>
                                        <input class="form-control required" type="text" name="name" autocomplete="off"
                                            placeholder="course">
                                    </div>
                                    <div class="form-group">
                                        <label>Course Code</label>
                                        <input class="form-control required" type="text" name="code" autocomplete="off"
                                            placeholder="course">
                                    </div>
                                    <div class="checkbox checkbox-primary p-t-0">
                                        <input id="active" type="checkbox" class="form-check-input form-control"
                                            name="active" value="1">
                                        <label for="active">
                                            Active
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <h5 class="mb-3">image</h5>
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
                                <div class="my-5 col-12 row">
                                    <div class="form-group col-12 col-md-6 col-lg-4">
                                        <label for="editing-program">Program</label>
                                        <select data-placeholder="Program" id="editing-program"
                                            class="form-control select2" name="program_id">
                                            @foreach ($programs as $p)
                                            <option value="{{$p->id}}">{{$p->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-6 col-lg-4">
                                        <label for="editing-level">Level</label>
                                        <select data-placeholder="Level" id="editing-level" class="form-control select2"
                                            name="level_id">
                                            @foreach ($levels as $l)
                                            <option value="{{$l->id}}">{{$l->name}}</option>
                                            @endforeach
                                        </select>
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
