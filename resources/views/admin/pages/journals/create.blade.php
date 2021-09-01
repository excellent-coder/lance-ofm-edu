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
                                    Add Journal
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
            <x-admin-card-tool title="journals">
                <a target="_blank" href="{{route('admin.journals')}}" class="btn-sm">
                    new Journal
                </a>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="my-3 col-12" style="background-color: indigo;">
                        <div class="row justify-content-end">
                            <a target="_blank" href="{{route('admin.journals')}}" class="btn btn-success">
                                Journals
                            </a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card-body">
                            <form method="POST" @submit.prevent="submit($event)"
                                action="{{route('admin.journals.store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-lg-7">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control tinymce" name="description"
                                                rows="4"></textarea>
                                        </div>

                                    </div>
                                    <div class=" col-lg-5 col-12">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input class="form-control required" type="text" name="title"
                                                placeholder="title">
                                        </div>
                                         <div class="my-2 form-group">
                                            <h5 class="mb-4 ">Pdf</h5>
                                            <div class="form-group position-relative"
                                                style="background-color:rgba(81, 32, 128, 0.787)">
                                                <input
                                                    @change.prevent="previewSelected($event, 'pdf', false)"
                                                    id="pdf" class="form-control-file" type="file"
                                                    name="pdf" accept=".pdf">
                                                <label for="pdf" class="text-center">
                                                    <i class="fas fa-plus deeppink"></i>
                                                </label>
                                            </div>
                                            <div class="row" v-if="files.pdf && files.pdf.length">
                                                <div v-for="(item, index) in files.pdf"
                                                    class="col-12 col-md-6 added preview-file">
                                                    <div>
                                                        <small>
                                                            @{{ item.file.name }} - @{{ size(item.file.size) }}
                                                        </small>
                                                        <small @click.prevent="removeFile('pdf', index)"
                                                         class="remove-image">
                                                            <i class="fa fa-times" aria-hidden="true"></i>
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

                                        <div class="checkbox checkbox-primary p-t-0">
                                            <input id="active" type="checkbox" class="form-check-input form-control"
                                                name="active" value="1">
                                            <label for="active">
                                                Active
                                            </label>
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
{{-- <button id="form-updater" class="d-none" @click.prevent="updateForm($event)" data-items='{}'> --}}
</button>
@endsection
@section('js')
<script src="/vendor/tinymce/tinymce.min.js"></script>
@endsection
