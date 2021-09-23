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
                        <form method="POST" @submit.prevent="submit($event)" action="{{route('admin.programs.store')}}">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-lg-8">
                                    <div class="form-group">
                                        <label>Short Description</label>
                                        <textarea placeholder="excerpt" class="form-control required" name="excerpt"
                                            rows="3"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="body">Long Description</label>
                                        <textarea class="form-control tinymce" name="description" rows="12"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="my-4 col-12 checkbox checkbox-primary">
                                            <input id="is_program" type="checkbox" class="form-check-input form-control"
                                                name="is_program" value="1" v-model="form.is_p">
                                            <label for="is_program">
                                                This is a program
                                            </label>
                                            <small class="form-text text-muted">
                                                <i class="fas text-warning fa-hand-point-right"></i>
                                                short course studies is not a program
                                            </small>
                                        </div>
                                        <div class="col-12" v-if="form.is_p">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="title">Main Application Fee</label>
                                                    <input class="form-control required" type="text" inputmode="numeric"
                                                        pattern="([\d]+)(\.)?(\d{1,2})" name="main_student_app_fee"
                                                        placeholder="Main Student Application Fee">
                                                    <small class="form-text text-muted">
                                                        requested format: numbers only optionally followed by dot (.)
                                                        and maximmum of two numbers after the dot (.)
                                                    </small>
                                                    <small class="form-text text-muted">
                                                        This is the fee for application as main student
                                                    </small>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="title">Short Course Application Fee</label>
                                                    <input class="form-control required" type="text" inputmode="numeric"
                                                        pattern="([\d]+)(\.)?(\d{1,2})" name="scs_app_fee"
                                                        placeholder="Short Course Application Fee">
                                                    <small class="form-text text-muted">
                                                        requested format: numbers only optionally followed by dot (.)
                                                        and maximmum of two numbers after the dot (.)
                                                    </small>
                                                    <small class="form-text text-muted">
                                                        This is the fee for application as main student
                                                    </small>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="visibility">Available To</label>
                                                    <select id="visibility" class="form-control select2"
                                                        name="visibility">
                                                        <option value="1" selected>All Studenst</option>
                                                        <option value="2">Program Students Only</option>
                                                        <option value="3">Schort Course Studenst Only</option>
                                                    </select>
                                                    <small class="form-text text-muted">
                                                        You can use this to specify those who are eligible to apply for
                                                        this
                                                        program
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Program</label>
                                        <input class="form-control required" type="text" name="title" autocomplete="off"
                                            placeholder="program">
                                    </div>
                                    <div class="form-group">
                                        <label>Abbreviation</label>
                                        <input class="form-control required" type="text" name="abbr" autocomplete="off"
                                            placeholder="abbreviation">
                                    </div>
                                    <div class="checkbox checkbox-primary p-t-0">
                                        <input id="active" checked type="checkbox" class="form-check-input form-control"
                                            name="active" value="1">
                                        <label for="active">
                                            Active
                                        </label>
                                        <small class="form-text text-muted">
                                            A program can be disabled and student wont be able to see
                                            it or lessons that belongs to it on their dashboard
                                        </small>
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
                            <button class="my-5 btn btn-block btn-success btn-lg">submit</button>
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
