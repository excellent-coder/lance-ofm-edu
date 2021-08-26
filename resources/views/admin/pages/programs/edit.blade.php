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
                            action="{{route('admin.programs.update', $program->id)}}">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-lg-8">
                                    <div class="form-group">
                                        <label>Short Description</label>
                                        <textarea placeholder="excerpt" class="form-control required" name="excerpt"
                                            rows="3">{{$program->excerpt}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="body">Long Description</label>
                                        <textarea class="form-control tinymce" name="description"
                                            rows="12">{{$program->description}}</textarea>
                                    </div>

                                    <div class="mt-4 row">
                                        <div class="my-4 checkbox checkbox-primary col-12">
                                            <input v-model="form.is_p" id="is_program" type="checkbox"
                                                class="form-check-input form-control" name="is_program" value="1">
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
                                                <div class="form-group">
                                                    <label for="visibility">Available To</label>
                                                    <select id="visibility" class="form-control select2"
                                                        name="visibility">
                                                        <option value="1" {{$program->visibility==1?'selected':''}}>All
                                                            Studenst</option>
                                                        <option value="2" {{$program->visibility==2?'selected':''}}>
                                                            Program Students Only</option>
                                                        <option value="3" {{$program->visibility==3?'selected':''}}>
                                                            Schort Course Studenst Only</option>
                                                    </select>
                                                    <small class="form-text text-muted">
                                                        You can use this to specify those who are eligible to apply for
                                                        this
                                                        program
                                                    </small>
                                                </div>
                                                <div class="my-3 form-group col-md-6">
                                                    <label for="max_level">Maximum Level</label>
                                                    <a href="{{route('admin.levels')}}" target="_blank"
                                                        rel="noopener noreferrer" title="add new Level">Add Levela</a>
                                                    <select data-placeholder="maximum level" name="max_level"
                                                        id="max_level" class=" form-control select2">
                                                        @foreach ($levels as $l)
                                                        <option value="{{$l->level}}"
                                                            {{$l->id == $program->max_level ? 'selected':''}}>
                                                            {{$l->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Program</label>
                                        <input class="form-control required" type="text" name="title"
                                            value="{{$program->title}}" autocomplete="off" placeholder="program">
                                    </div>
                                    <div class="form-group">
                                        <label>Abbreviation</label>
                                        <input class="form-control required" type="text" name="abbr"
                                            value="{{$program->abbr}}" autocomplete="off" placeholder="abbreviation">
                                    </div>
                                    <div class="checkbox checkbox-primary p-t-0">
                                        <input id="active" {{$program->active?'checked':''}} type="checkbox"
                                            class="form-check-input form-control" name="active" value="1">
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
                                            v-if="files.image && files.image.length || '{{$program->image}}' && !form.remove_image">
                                            <div
                                                class="px-3 col-12 select-cover-photo selected preview-file featured-photo">
                                                <img :src="(files.image && files.image[0])?fileSrc(files.image[0].file):'/storage/{{$program->image}}'"
                                                    alt="preview" class="cursor-pointer preview-img">
                                                <i class="remove-image" @click.prevent="removeFile('image', 0)">×</i>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($program->image)
                                    <div class="form-group">
                                        <div class="checkbox checkbox-primary p-t-0">
                                            <input id="remove_image" type="checkbox"
                                                class="form-check-input form-control" v-model="form.remove_image"
                                                name="remove_image" value="1">
                                            <label for="remove_image">
                                                Remove old featured image
                                            </label>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <button class="btn btn-block btn-success btn-lg">update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<button id="form-updater" class="d-none" @click.prevent="updateForm($event)"
    data-items='{{json_encode(['is_p'=> boolval($program->is_program)])}}'>
    @endsection

    @section('js')
    <script src="/vendor/tinymce/tinymce.min.js"></script>

    <script>
        setTimeout(() => {
            return $('#form-updater').trigger('click');
        }, 500);

    </script>
    @endsection
