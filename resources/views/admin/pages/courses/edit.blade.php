@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="/css/file.css">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <x-admin-card-tool title="All Pages">
            </x-admin-card-tool>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="POST" @submit.prevent="submit($event)"
                            action="{{route('admin.courses.update', $course->id)}}">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-lg-8">
                                    <div class="form-group">
                                        <label>Short Description</label>
                                        <textarea placeholder="excerpt" class="form-control" name="excerpt"
                                            rows="3">{{$course->excerpt}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="body">Long Description</label>
                                        <textarea class="form-control tinymce" name="description"
                                            rows="12">{{$course->description}}</textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Course</label>
                                        <input class="form-control required" type="text" name="name" autocomplete="off"
                                            value="{{$course->name}}" placeholder="course">
                                    </div>
                                    <div class="form-group">
                                        <label>Course Code</label>
                                        <input class="form-control required" type="text" name="code" autocomplete="off"
                                            value="{{$course->code}}" placeholder="course">
                                    </div>
                                    <div class="checkbox checkbox-primary p-t-0">
                                        <input id="active" {{$course->active?'checked':''}} type="checkbox" name="active" value="1">
                                        <label for="active">
                                            Active
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <h5 class="mb-3 text-muted">Featured Image
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
                                        <div class="row selected-files"
                                            v-if="files.image && files.image.length || '{{$course->image}}' && !form.remove_image">
                                            <div
                                                class="px-3 col-12 select-cover-photo selected preview-file featured-photo">
                                                <img :src="(files.image && files.image[0])?fileSrc(files.image[0].file):'/storage/{{$course->image}}'"
                                                    alt="preview" class="cursor-pointer preview-img">
                                                <i class="remove-image" @click.prevent="removeFile('image', 0)">×</i>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($course->image)
                                    <div class="form-group">
                                        <div class="checkbox checkbox-primary p-t-0">
                                            <input id="remove_image" type="checkbox" v-model="form.remove_image" name="remove_image" value="1">
                                            <label for="remove_image">
                                                Remove old featured image
                                            </label>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="my-5 col-12 row">
                                    <div class="form-group col-12 col-md-6 col-lg-4">
                                        <label for="editing-program">Program</label>
                                        <select data-placeholder="Program" id="editing-program"
                                            class="form-control select2" name="program_id">
                                            @foreach ($programs as $p)
                                            <option value="{{$p->id}}" {{$p->id == $course->program_id?'selected':''}}>
                                                {{$p->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-6 col-lg-4">
                                        <label for="editing-level">Level</label>
                                        <select data-placeholder="Level" id="editing-level" class="form-control select2"
                                            name="level_id">
                                            @foreach ($levels as $l)
                                            <option value="{{$l->id}}" {{$l->id == $course->level_id?'selected':''}}>
                                                {{$l->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-6 col-lg-4">
                                        <label for="visibility">Available To</label>
                                        <select id="visibility" class="form-control select2" name="visibility">
                                            <option value="1" {{$course->visibility == '1'?'selected':''}}>All Studenst
                                            </option>
                                            <option value="2" {{$course->visibility == '2'?'selected':''}}>Program
                                                Students Only</option>
                                            <option value="3" {{$course->visibility == '3'?'selected':''}}>Schort Course
                                                Studenst Only</option>
                                        </select>
                                        <small class="form-text text-muted">
                                            You can use this to specify those who are eligible to
                                            take this lesson
                                        </small>
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
