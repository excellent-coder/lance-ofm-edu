@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="/css/file.css">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <x-admin-card-tool title="New Publication">
                <a href="{{route('admin.pubs.create')}}" class="text-white btn btn-success btn-sm">
                    New Publication
                </a>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="my-3 col-12" style="background-color: indigo;">
                        <div class="row justify-content-end">
                            <a href="{{route('admin.pubs.create')}}" class="btn btn-success">
                                New Publication
                            </a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card-body">
                            <form method="POST" @submit.prevent="submit($event, ['materials'])"
                                action="{{route('admin.pubs.store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-7 col-12">
                                        <div class="mb-4 form-group">
                                            <label for="title">Title</label>
                                            <input class="form-control required" type="text" name="title"
                                                placeholder="title" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control required tinymce" name="description"
                                                rows="12"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-5">
                                        <div class="form-group">
                                            <label for="category">Category</label>
                                            <select data-placeholder="category" id="category" class="form-control select2 required" name="category">
                                                <option value=" ">-select category-</option>
                                                @foreach ($categories as $t)
                                                <option value="{{$t->id}}">{{$t->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4 form-group">
                                            <label>Volume</label>
                                            <input class="form-control" type="text" name="volume"
                                                placeholder="volume" autocomplete="off">
                                        </div>
                                        <div class="mb-4 form-group">
                                            <label for="price">price</label>
                                            <input class="form-control" type="text" inputmode="numeric" name="price"
                                                placeholder="price" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                          <label for="docs">Document</label>
                                          <input type="file" class="form-control-file simple-file required" accept=".pdf,.docx" name="docs" id="docs" placeholder="document"
                                           aria-describedby="docs-help">
                                          <small id="docs-help" class="form-text text-muted">The file to download as the publication</small>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-group">
                                                <h5 class="mb-3">preview photo
                                                    <i class="fas fa-info-circle" data-toggle="tooltip"
                                                        title="This image is used for open graph. Use the editor to add images to your page">
                                                    </i>
                                                </h5>
                                                <div class="form-group position-relative"
                                                    style="background-color:rgba(81, 32, 128, 0.787)">
                                                    <input @change.prevent="previewSelected($event, 'image', false)"
                                                        id="image" class="form-control-file" type="file" name="image"
                                                        accept="image/*">
                                                    <label for="image" class="text-center">
                                                        <i class="fas fa-plus deeppink"></i>
                                                    </label>
                                                </div>
                                                <div class="row selected-files"
                                                    v-if="files.image && files.image.length">
                                                    <div
                                                        class="px-3 col-12 select-cover-photo selected preview-file featured-photo">
                                                        <img :src="fileSrc(files.image[0].file)" alt="preview"
                                                            class="cursor-pointer preview-img">
                                                        <i class="remove-image"
                                                            @click.prevent="removeFile('image', 0)">×</i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="col-12 bg-success">
                                        <div class="my-2 col-12">
                                            <div class="row">
                                                <div class="form-group col-6 col-lg-3">
                                                    <div class="checkbox checkbox-primary p-t-0">
                                                        <input id="featured" type="checkbox"
                                                            class="form-check-input form-control" name="featured"
                                                            value="1">
                                                        <label for="featured">
                                                            Featured
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-6 col-lg-3">
                                                    <div class="checkbox checkbox-primary p-t-0">
                                                        <input id="published" type="checkbox"
                                                            class="form-check-input form-control" name="published"
                                                            value="1">
                                                        <label for="published">
                                                            Published
                                                        </label>
                                                    </div>
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
</div>
<div>
    <x-admin-modal title="Managing subjects">
    </x-admin-modal>
</div>
@endsection
@section('js')
<script src="/vendor/tinymce/tinymce.min.js"></script>
@endsection
