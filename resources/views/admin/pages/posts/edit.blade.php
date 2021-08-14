@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="/css/file.css">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <x-admin-card-tool title="Blog - News - Posts">
                <a href="{{route('admin.posts.create')}}" class="text-white btn btn-success btn-sm">
                    New Post
                </a>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="my-3 col-12" style="background-color: indigo;">
                        <div class="row justify-content-end">
                            <a href="{{route('admin.posts.create')}}" class="btn btn-success">
                                New Post
                            </a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card-body">
                            <form method="POST" @submit.prevent="submit($event)"
                                action="{{route('admin.posts.update', $post->id)}}">
                                @csrf
                                <div class="row">
                                    <div class="order-2 col-lg-7 col-12 order-lg-0">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control required tinymce" name="description"
                                                rows="8">{{$post->description}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Excerpt</label>
                                            <textarea class="form-control" name="excerpt"
                                                rows="3">{{$post->excerpt}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="tags">Tags</label>
                                            <select data-placeholder="post tags" data-value="{{$postTags}}" id="tags"
                                                class="form-control select2" name="tags[]" multiple>
                                                <option value=" ">-select tags-</option>
                                                @foreach ($tags as $t)
                                                <option value="{{$t->id}}">{{$t->tag}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-5 order-lg-1 order-0">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input class="form-control required" type="text" name="title"
                                                placeholder="title" autocomplete="on" value="{{$post->title}}">
                                        </div>
                                        <div class="form-group">
                                            <input v-if="form.parent_cat" type="hidden" name="parent_cat"
                                                :value="form.parent_cat.id">
                                            <label>Category</label>
                                            <multi-select v-model="form.parent_cat" :options="{{$categories}}"
                                                :show-labels="false" label="name" track-by="id" autocomplete="off"
                                                :clear-on-select="false" placeholder="Super Category"
                                                :close-on-select="true"
                                                @select="subItems($event, '{{route('admin.post-cats.children')}}', 'categories', {post_cat:null,categories:[] })"
                                                @remove="removeShopCat('super')" />
                                        </div>
                                        <div class="form-group">
                                            <input v-if="form.post_cat" type="hidden" name="post_cat"
                                                :value="form.post_cat.id">

                                            <label>Sub Category</label>
                                            <multi-select v-model="form.post_cat" :options="form.categories"
                                                :show-labels="false" label="name" track-by="id" autocomplete="off"
                                                :clear-on-select="false" placeholder="Super Category"
                                                :disabled="!form.categories.length" :close-on-select="true" />
                                        </div>
                                        <div class="form-group">
                                            <h5 class="mb-3 text-muted">Featured Image
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
                                                v-if="files.image && files.image.length || '{{$post->image}}' && !form.remove_image">
                                                <div
                                                    class="px-3 col-12 select-cover-photo selected preview-file featured-photo">
                                                    <img :src="(files.image && files.image[0])?fileSrc(files.image[0].file):'/storage/{{$post->image}}'"
                                                        alt="preview" class="cursor-pointer preview-img">
                                                    <i class="remove-image"
                                                        @click.prevent="removeFile('image', 0)">×</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="order-2 col-12 bg-success">
                                    <div class="order-2 my-2 col-12">
                                        <div class="row justify-content-between">
                                            <div class="form-group">
                                                <div class="checkbox checkbox-primary p-t-0">
                                                    <input id="featured" type="checkbox"
                                                        class="form-check-input form-control"
                                                        {{$post->featured?'checked':''}} name="featured" value="1">
                                                    <label for="featured">
                                                        Featured
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="checkbox checkbox-primary p-t-0">
                                                    <input id="published" type="checkbox"
                                                        class="form-check-input form-control"
                                                        {{$post->published?'checked':''}} name="published" value="1">
                                                    <label for="published">
                                                        Published
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="checkbox checkbox-primary p-t-0">
                                                    <input id="remove_image" type="checkbox"
                                                        class="form-check-input form-control" {!!
                                                        $post->image?'v-model="form.remove_image"':'disabled' !!}
                                                    name="remove_image" value="1">
                                                    <label for="remove_image">
                                                        Remove old featured image
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
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
</div>
<button id="form-updater" class="d-none" @click.prevent="updateForm($event)" data-items='{{$items}}'>
</button>
@endsection

@section('js')
<script src="/vendor/tinymce/tinymce.min.js"></script>
<script>
    setTimeout(() => {
        $('#form-updater').trigger('click');
        $('#tags').val({
            {
                $postTags
            }
        }).select2();
    }, 500);

</script>
@endsection
