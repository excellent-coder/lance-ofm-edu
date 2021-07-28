@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="/css/file.css">
{{-- DataTables --}}
<link rel="stylesheet" href="/vendor/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/vendor/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="/vendor/datatables-buttons/css/buttons.bootstrap4.min.css">
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
                                   Edit: {{$lesson->topic}}
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
                <a href="{{route('admin.lessons')}}" class="btn-sm">
                    Lessons
                </a>
                <a href="{{route('admin.lessons.create')}}" class="btn-sm">
                    new Lesson
                </a>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="col-12 my-3" style="background-color: indigo;">
                        <div class="row justify-content-end">
                            <a href="{{route('admin.lessons.create')}}" class="btn btn-success">
                               New Lessons
                            </a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card-body">
                            <div class="col-12">
                                <form method="POST" @submit.prevent="submit($event, ['materials'])"
                                    action="{{route('admin.lessons.update', $lesson->id)}}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 col-lg-8">
                                            <div class="form-group">
                                                <label for="subject_id">Subject</label>
                                                <select name="subject_id" id="subject_id"
                                                    class=" form-control required select2"
                                                    data-placeholder="choose subject">
                                                    @foreach ($subjects as $s)
                                                    <option {{$s->id == $lesson->subject_id?'selected':''}} value="{{$s->id}}">{{$s->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="title">Topic</label>
                                                <input class="form-control required" type="text"
                                                    name="topic" placeholder="title" value="{{$lesson->topic}}">
                                            </div>
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea class="form-control required tinymce" name="description" rows="4">{{$lesson->description}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label>Old Materials</label>
                                                    <table  id="dataTable" class="table table-bordered table-striped">
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
                                                            <td>{{$m->name}}</td>
                                                            <td>{{$m->created_at}}</td>
                                                            <td>
                                                                <button type="button"
                                                                class="btn btn-sm btn-warning activate-btn"
                                                                title="draft"
                                                                data-route="{{route('admin.materials.activate', $m->id)}}"
                                                                data-rowid='#tr-m-{{$m->id}}'
                                                                >
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-danger action-btn"
                                                                data-action="{{route('admin.materials.destroy')}}"
                                                                data-id="{{$m->id}}"
                                                                data-rowid="#tr-m-{{$m->id}}">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </td>
                                                         </tr>
                                                         @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <h4>Upload More Materials for this Lesson</h4>
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
                                                    <h4 class=" col-12 my-2 bg-gradient-success text-center p-3">New Materials</h4>
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
                                                    <option value="1" {{$lesson->active?'selected':''}} >Active</option>
                                                    <option value="0" {{!$lesson->active?'selected':''}}>Draft</option>
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
                                                <div class="row selected-files">
                                                    <div
                                                        class="col-12 px-3 select-cover-photo selected preview-file featured-photo">
                                                        <img :src="(files.image && files.image[0])?fileSrc(files.image[0].file):'/storage/{{$lesson->photo}}'" alt="preview"
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

<script src="/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/vendor/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/vendor/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/vendor/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/vendor/jszip/jszip.min.js"></script>
<script src="/vendor/pdfmake/pdfmake.min.js"></script>
<script src="/vendor/pdfmake/vfs_fonts.js"></script>
<script src="/vendor/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/vendor/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/vendor/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
    $("#dataTable").DataTable({
        "responsive": true,
        "autoWidth": false,
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": [0, -1]
        }],
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');

</script>
@endsection
