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
                        <form method="POST" @submit.prevent="submit($event)" action="{{route('admin.licences.store')}}">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-lg-8">
                                    <div class="form-group">
                                        <label for="body">Description</label>
                                        <textarea class="form-control tinymce required"
                                            placeholder="Description about the license" name="description"
                                            rows="12"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12 col-md-6">
                                            <label>Initial Fee</label>
                                            <input class="form-control required" type="text" inputmode="numeric"
                                                pattern="([\d]+)(\.)?(\d{1,2})" name="fee" autocomplete="off"
                                                placeholder="Initial Fee">
                                        </div>
                                        <div class="form-group col-12 col-md-6">
                                            <label>Renewal Fee</label>
                                            <input class="form-control required" type="text" inputmode="numeric"
                                                pattern="([\d]+)(\.)?(\d{1,2})" name="renewal" autocomplete="off"
                                                placeholder="Renewal Fee">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input class="form-control required" type="text" name="name" autocomplete="off"
                                            placeholder="Name">
                                    </div>
                                    <div class="form-group">
                                        <label>Code</label>
                                        <input class="form-control required" type="text" name="code" autocomplete="off"
                                            placeholder="Unique Code">
                                    </div>
                                    <div class="form-group">
                                        <label>Duration (Years)</label>
                                        <input class="form-control required" type="number" inputmode="numeric"
                                            name="duration" value="3" placeholder="Duration in Years">
                                    </div>
                                    <div class="checkbox checkbox-primary p-t-0">
                                        <input id="active" checked type="checkbox" class="form-check-input form-control"
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
