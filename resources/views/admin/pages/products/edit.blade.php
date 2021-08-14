@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="/css/file.css">
<style>
    .delete-image, .activate-image{
        position: absolute;
    }
    .activate-image{
        top: 0;
        right: 0;
    }
    .delete-image{
        bottom: 0;
        right: 0;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <x-admin-card-tool title="Products">
                <a href="{{route('admin.products')}}" class="btn-success btn-sm">
                    Products
                </a>
                <a href="{{route('admin.products.create')}}" class="btn-success btn-sm">
                    new Product
                </a>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="pl-3 my-3 text-white col-12" style="background-color: indigo;">
                        <div class="row justify-content-between">
                            <h5>Editing: {{$product->title}}</h5>
                            <a href="{{route('admin.products')}}" target="_blank" class="btn btn-primary btn-success">
                                products
                            </a>
                        </div>
                    </div>
                    <div class="col-12">
                        <form @submit.prevent="submit($event, ['images'])" action="{{route('admin.products.update', $product->id)}}">
                            <div class="row">
                                <div class="col-lg-8 col-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control required tinymce" name="description"
                                            rows="4">{{$product->description}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Excerpt</label>
                                        <textarea placeholder="excerpt" class="form-control" name="excerpt"
                                            rows="3">{{$product->excerpt}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Super Category</label>
                                        <multi-select v-model="form.super_cat" :options="{{$supers}}"
                                            :show-labels="false" label="name" track-by="id" autocomplete="off"
                                            :clear-on-select="false" placeholder="Super Category"
                                            :close-on-select="true"
                                            @select="getShopCats($event, 'super', '{{route('admin.product-cats.children')}}')"
                                            @remove="removeShopCat('super')" />
                                    </div>
                                    <div class="form-group">
                                        <label>Parent Category</label>
                                        <multi-select v-model="form.parent_cat" :options="parentShopCats"
                                            :show-labels="false" label="name" track-by="id" autocomplete="off"
                                            :clear-on-select="false" placeholder="Parent Category"
                                            :close-on-select="true" :disabled="!form.super_cat"
                                            @select="getShopCats($event, 'parent', '{{route('admin.product-cats.children')}}')"
                                            @remove="removeShopCat('parent')" />
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="product_cat_id" :value="form.product_cat_id"
                                            autocomplete="off" />
                                        <label>Category</label>
                                        <multi-select v-model="form.product_cat" :options="shopCats"
                                            :show-labels="false" label="name" track-by="id" autocomplete="off"
                                            :clear-on-select="false" placeholder="Category" :close-on-select="true"
                                            :disabled="!form.parent_cat"
                                            @select="($event) => (form.product_cat_id = $event.id)"
                                            @remove="removeShopCat('product_cat')" />
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input class="form-control required" value="{{$product->title}}" type="text" name="title" placeholder="title">
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Original Price</label>
                                        <input class="form-control required" v-model="price" type="text"
                                            inputmode="numeric" pattern="([\d]+)(\.)?(\d{1,2})" name="price"
                                            placeholder="price">
                                        <small class="form-text text-muted">
                                            requested format: numbers only optionally followed by dot (.)
                                            and maximmum of two numbers after the dot (.)
                                        </small>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">High Price</label>
                                        <input class="form-control" type="text" inputmode="numeric"
                                            pattern="([\d]+)(\.)?(\d{1,2})" v-model="highPrice" name="high_price"
                                            placeholder="high price">
                                        <small class="form-text text-muted">
                                            requested format: numbers only optionally followed by dot (.)
                                            and maximmum of two numbers after the dot (.)
                                        </small>
                                    </div>
                                    <div class="form-group">
                                        <label for="discount">
                                            <button class="btn" type="button">
                                                Percentage Discount -
                                                <span class="badge badge-primary">
                                                    @{{ `${ perDiscount }%`}}</span>
                                            </button>
                                        </label>
                                        <input id="discount" class="cursor-pointer form-control-range" type="range"
                                            name="discount" readonly min="0" max="100" v-model="perDiscount">
                                        <small class="form-text text-muted">
                                            This can be calculated from the high price
                                        </small>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control select2" style="width: 100%;" name="active">
                                            <option value="1" {{$product->active?'selected':''}}>Publish</option>
                                            <option value="0" {{$product->active?'':'selected'}}>Draft</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="d-flex align-items-center">
                                            <div class="checkbox checkbox-primary p-t-0">
                                                <input id="featured" type="checkbox" class="form-check-input" name="featured" value="1" {{$product->featured?'checked':''}}>
                                                <label for="featured">
                                                    Featured
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="d-flex no-block align-items-center">
                                            <div class="checkbox checkbox-primary p-t-0">
                                                <input id="digital" type="checkbox" name="digital" value="1"
                                                    v-model="form.isDigitalProduct" {{$product->digital?'checked':''}} >
                                                <label for="digital">
                                                    This is Digital Product
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" v-if="form.isDigitalProduct">
                                        <div>
                                            old Product
                                            <p>
                                                <a href="{{asset("storage/$product->item")}}" target="_blank" rel="noopener noreferrer">
                                                    {{$product->item}}
                                                </a>
                                            </p>
                                        </div>
                                        <h5>Upload item that user will download after payment</h5>
                                        <div class="form-group position-relative"
                                            style="background-color:rgba(81, 32, 128, 0.787)">
                                            <input @change.prevent="previewSelected($event, 'product', 0)" id="product"
                                                class="form-control-file" type="file" name="item">
                                            <label for="product" class="text-center">
                                                <i class="fas fa-plus deeppink"></i>
                                            </label>
                                        </div>
                                        <div class="row" v-if="files.product && files.product.length">
                                            <div class="col-12 preview-file">
                                                <div class="row justify-content-between">
                                                    <small class=" d-inline-block">
                                                        @{{ files.product[0].file.name }} -
                                                        @{{ size(files.product[0].file.size) }}
                                                    </small>
                                                    <small @click.prevent="removeFile('product', 0)"
                                                        class="remove-image d-inline-block">
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    </small>
                                                </div>
                                                <hr class="bg-success d-block">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 form-group col-12">
                                    <h5 class="mb-3">Product Photos</h5>
                                    <div class="form-group position-relative">
                                        <input
                                            @change="previewSelected($event, 'images', '{{route('admin.products.gallery')}}', 'product_photos', 'image')"
                                            id="images" class="form-control-file" type="file" name="images[]"
                                            accept="image/*" multiple>
                                        <label for="images" class="text-center">
                                            <i class="fas fa-plus deeppink"></i>
                                        </label>
                                    </div>
                                    <div class="row">
                                        <div v-for="(file, index) in {{$product->images}}"
                                            class="p-2 col-6 col-md-4 col-lg-3 preview-file position-relative"
                                            :class="[{'featured-photo':file.featured}]" :key="index">

                                            <img class="cursor-pointer preview-img" :src="'/storage/'+file.image"
                                                @click.prevent="activate($event.currentTarget)"
                                                :data-route="'/admin/product-imgs/feature/'+file.id">

                                            <button class="activate-image" @click.prevent="activate($event.currentTarget)"
                                            :title="file.active?'disable':'activate'"
                                            :data-route="'/admin/product-imgs/activate/'+file.id" type="button">
                                                <i class="fas" :class="[{'fa-check': file.active, 'fa-times': !file.active}]"></i>
                                            </button>

                                            <button class="delete-image" @click.prevent="destroy($event.currentTarget)"
                                            data-action="{{route('admin.product-imgs.destroy')}}"
                                            :data-id="file.id" type="button">
                                            <i class="fas fa-trash-alt text-danger"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row" v-if="files.images && files.images.length">
                                        <div class="col-12">
                                            <h4>New Images</h4>
                                        </div>
                                        <div v-for="(file, index) in files['images']"
                                            class="col-6 col-md-4 col-lg-3 added preview-file"
                                            v-bind:data-position="index"
                                            :class="[file.order, {'featured-photo':file.featured}]">

                                            <img class="cursor-pointer preview-img" :src="fileSrc(file.file)"
                                                @click.prevent="featureFile('images', index)">

                                            <i class="remove-image" @click.prevent="removeFile('images', index)">×</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-block btn-success btn-big">
                                Update
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 <button id="form-updater" class="d-none" @click.prevent="updateForm($event)"
        data-items='{{$items}}' data-mains="{{$mains}}">
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
