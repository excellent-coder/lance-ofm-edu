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
                    <div class="my-3 col-12" style="background-color: indigo;">
                        <div class="row justify-content-end">
                            <a href="{{route('admin.lessons')}}" class="btn btn-success">
                                Lessons
                            </a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card-body">
                            <form method="POST" @submit.prevent="submit($event, ['materials'])"
                                action="{{route('admin.lessons.update', $lesson->id)}}">
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-lg-7">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control required tinymce" name="description" rows="4">{{$lesson->description}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label>Old Materials</label>
                                                <table id="dataTable" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>material</th>
                                                            <th>uploaded at</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i=1;?>
                                                        @foreach ($lesson->materials as $m)
                                                        <tr>
                                                            <td>{{$i++}}</td>
                                                            <td>
                                                                <a href="/storage/{{$m->path}}" target="_blank" rel="noopener noreferrer">
                                                                    {{$m->name}}
                                                                </a>
                                                            </td>
                                                            <td>{{$m->created_at}}</td>
                                                            <td>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-warning activate-btn"
                                                                    title="draft"
                                                                    data-route="{{route('admin.materials.activate', $m->id)}}"
                                                                    data-rowid='#tr-m-{{$m->id}}'>
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger action-btn"
                                                                    data-action="{{route('admin.materials.destroy')}}"
                                                                    data-id="{{$m->id}}" data-rowid="#tr-m-{{$m->id}}">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <h4>Upload More Materials for this Lesson</h4>
                                            <div class="form-group position-relative"
                                                style="background-color:rgba(81, 32, 128, 0.787)">
                                                <input
                                                    @change.prevent="previewSelected($event, 'materials', '{{route('admin.materials.store')}}')"
                                                    id="materials" class="form-control-file" type="file"
                                                    name="materials" multiple>
                                                <label for="materials" class="text-center">
                                                    <i class="fas fa-plus deeppink"></i>
                                                </label>
                                            </div>
                                            <div class="row" v-if="files.materials && files.materials.length">
                                                <h4 class="p-3 my-2 text-center col-12 bg-gradient-success">New
                                                    Materials</h4>
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
                                                        <div class="text-center progress-bar progress-bar-striped"
                                                            :class="['bg-'+item.color]"
                                                            :style="{width: item.progress+'%'}" role="progressbar"
                                                            v-bind:aria-valuenow="item.progress" aria-valuemin="0"
                                                            aria-valuemax="100">@{{item.file.name}}</div>
                                                    </div>
                                                    <div>
                                                        <hr class="bg-success">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class=" col-lg-5 col-12">
                                        <div class="form-group">
                                            <label for="title">Topic</label>
                                            <input class="form-control required" type="text" value="{{$lesson->topic}}" name="topic"
                                                placeholder="title">
                                        </div>

                                        <div class="form-group">
                                            <label>Program</label>
                                            <multi-select v-model="form.program" :options="{{$programs}}"
                                                :show-labels="false" label="title" track-by="id" autocomplete="off"
                                                :clear-on-select="false" placeholder="Program" :close-on-select="true"
                                                @select="fetchCourses($event, 'program')"
                                                @remove="($event) => (form.course =null) " />
                                        </div>
                                        <div class="form-group">
                                            <label>Level</label>
                                            <multi-select v-model="form.level" :options="{{$levels}}"
                                                :show-labels="false" label="name" track-by="id" autocomplete="off"
                                                :clear-on-select="false" placeholder="Level" :close-on-select="true"
                                                @select="fetchCourses($event, 'level')"
                                                @remove="($event) => (form.course =null)" />
                                        </div>

                                        <div class="form-group">
                                            <label>Course</label>
                                            <input type="hidden" name="course_id" class="required"
                                                :value="form.course.id" v-if="form.course">
                                            <multi-select v-model="form.course" :options="form.courses?form.courses:[]"
                                                :show-labels="false" label="name" track-by="id" autocomplete="off"
                                                :clear-on-select="false" placeholder="Course" :close-on-select="true"
                                                required :disabled="!form.program || !form.level" />
                                        </div>

                                        <div class="my-4 checkbox checkbox-primary p-t-0">
                                            <input id="active" {{$lesson->active?'checked':''}} type="checkbox" class="form-check-input form-control"
                                                name="active" value="1">
                                            <label for="active">
                                                Active
                                            </label>
                                        </div>
                                        <div class="mb-4 form-group">
                                            <label for="session">Session</label>
                                            <select id="session" class="form-control select2 required" name="session_id"
                                                data-placeholder="Session">
                                                @foreach ($sessions as $s)
                                                <option {{$s->id == $lesson->session_id?'selected':''}} value="{{$s->id}}">
                                                    {{$s->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <h5 class="mb-3">preview Image
                                                <i class="fas fa-info-circle" data-toggle="tooltip"
                                                    title="This image is important for student to quickly know what lesson is all about">
                                                </i>
                                                <span class="text-danger">*</span>
                                            </h5>
                                            <div class="form-group position-relative"
                                                style="background-color:rgba(81, 32, 128, 0.787)">
                                                <input @change.prevent="previewSelected($event, 'image', false)"
                                                    id="image" class="form-control-file" type="file"
                                                    name="image" accept="image/*">
                                                <label for="image" class="text-center">
                                                    <i class="fas fa-plus deeppink"></i>
                                                </label>
                                            </div>
                                            <div class="row selected-files" v-if="(files.image && files.image.length)||'{{!empty($lesson->image)}}'">
                                                <div
                                                    class="px-3 col-12 select-cover-photo selected preview-file featured-photo">
                                                   <img :src="(files.image && files.image[0])?fileSrc(files.image[0].file):'/storage/{{$lesson->image}}'" alt="preview"
                                                            class="cursor-pointer preview-img">
                                                    <i class="remove-image"
                                                        @click.prevent="removeFile('image', 0)">??</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-block btn-success btn-lg">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<button id="form-updater" class="d-none" @click.prevent="updateForm($event)" data-items='{{$items}}'>
</button>
@endsection
@section('js')
<script src="/vendor/tinymce/tinymce.min.js"></script>
<script>
    setTimeout(() => {
        return $('#form-updater').trigger('click');
    }, 500);

</script>
@endsection
