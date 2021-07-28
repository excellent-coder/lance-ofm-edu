@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="/css/file.css">

@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <x-admin-card-tool title="All Pages" :links="$cardLinks">
            </x-admin-card-tool>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="POST" @submit.prevent="submit($event)"
                            action="{{route('admin.pages.update', $page->id)}}">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-lg-8">
                                    <div class="form-group">
                                        <label for="body">Body</label>
                                        <textarea class="form-control required tinymce" name="body" rows="12">{{$page->body}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Excerpt</label>
                                        <textarea placeholder="excerpt" class="form-control" name="excerpt"rows="3">{{$page->excerpt}}</textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input class="form-control required" type="text" name="title" value="{{$page->title}}" placeholder="title">
                                    </div>
                                    <div class="form-group">
                                        <label for="slug">Slug</label>
                                        <input class="form-control required" type="text"  name="slug" value="{{$page->slug}}" placeholder="slug">
                                    </div>
                                    <div class="form-group">
                                        <label>Status
                                            <i class="fas fa-info-circle" data-toggle="tooltip"
                                                title="Make page active and accessible other save as draft"></i>
                                        </label>
                                        <select class="form-control select2" style="width: 100%;" name="active">
                                            <option value="1" {{ $page->active ?'selected':''}}>Active</option>
                                            <option value="0" {{$page->active ?'' :'selected'}}>Draft</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <h5 class="mb-3">Choose Open graph
                                            <i class="fas fa-info-circle" data-toggle="tooltip"
                                                title="This image is used for open graph. Use the editor to add images to your page">
                                            </i>
                                        </h5>
                                        <div class="form-group position-relative">
                                            <input @change.prevent="previewSelected($event)" id="image" class="form-control-file" type="file" name="image"
                                                accept="image/*">
                                            <label for="image" class="text-center">
                                                <i class="fas fa-plus deeppink"></i>
                                            </label>
                                        </div>
                                        <div class="row selected-files" id="image_preview">
                                            <div class="col-12 px-3 select-cover-photo selected preview-file featured-photo">
                                                <img :src="imageFile?imageFile:'/storage/{{$page->image}}'" alt="preview" class="cursor-pointer preview-img">
                                                <i v-if="imageFile" class="remove-image" @click.prevent="removeSelected('image')">×</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-block btn-success btn-lg rounded-1">update</button>
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
