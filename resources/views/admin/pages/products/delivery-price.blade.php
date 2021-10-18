@extends('layouts.admin')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="/vendor/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/vendor/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="/vendor/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <x-admin-card-tool title="Shop Categories">
                <button class="text-white btn btn-success btn-tool dropdown-toggle btn-sm" data-target="#general-modal"
                    @click="modalEdit($event.target, true)" data-form="general-modal-form"
                    data-store_route="{{route('admin.d-prices.store')}}">
                    new Delivery Price
                </button>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="my-3 col-12" style="background-color: indigo;">
                        <div class="row justify-content-end">
                            <button class="btn btn-success" data-target="#general-modal"
                                @click="modalEdit($event.target, true); form={}" data-form="general-modal-form"
                                data-store_route="{{route('admin.d-prices.store')}}">
                                new Delibery Price
                            </button>
                        </div>
                    </div>
                    <div class="col-12">
                        <table id="dataTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="checkbox">
                                    </th>
                                    <th>#</th>
                                    <td>Title</td>
                                    <td>View</td>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @php
                                $action = [
                                'modal'=>'general',
                                'destroy'=> route('admin.d-prices.destroy'),
                                'form'=>'general-modal-form',

                                ];
                                @endphp
                                @foreach ($prices as $c)
                                <?php
                                $action['id'] = $c->id;
                                $action['update_route']= route("admin.d-prices.update", $c->id);
                                $action['rowid'] = "#tr-cats-$c->id";

                                $action['item']= $c;
                                ?>
                                <tr id="tr-cats-{{$c->id}}">
                                    <td><input type="checkbox" class="checking"></td>
                                    <td>{{$i++}}</td>
                                    <td>{{$c->title}}</td>
                                    <td>
                                        {{-- <button class="btn btn-sidebar btn-sm preview modal-edit-btn"
                                          data-target="#preview-modal" type="button" data-item="{{$c}}">
                                        <i class="fas fa-eye"></i>
                                        </button> --}}
                                    </td>
                                    <td>
                                        {{-- <x-data-table-action :action="$action"></x-data-table-action> --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>
                                        <i class="fa fa-check-square" aria-hidden="true"></i>
                                    </th>
                                    <th>#</th>
                                    <td>Title</td>
                                    <td>View</td>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
    <x-admin-modal title="Delivery Price">
        <form action="{{route('admin.product-cats.store')}}" autocomplete="off" @submit.prevent="submit($event)"
            id="general-modal-form">
            <div class="form-group">
                <input type="hidden" name="cat_super_parent" :value="form.super_parent_id" autocomplete="off" />
                <label>Super Category</label>
                <multi-select v-model="form.super_cat" :options="{{$supers}}" :show-labels="false" label="name"
                    track-by="id" autocomplete="off" :clear-on-select="false" placeholder="Super Category"
                    :close-on-select="true"
                    @select="getShopCats($event, 'super', '{{route('admin.product-cats.children')}}')"
                    @remove="removeShopCat('super')" />
            </div>
            <div class="form-group">
                <input type="hidden" name="cat_parent" :value="form.parent_id" autocomplete="off" />
                <label>Parent Category</label>
                <multi-select v-model="form.parent_cat" :options="parentShopCats" :show-labels="false" label="name"
                    track-by="id" autocomplete="off" :clear-on-select="false" placeholder="Parent Category"
                    :close-on-select="true" :disabled="!form.super_cat"
                    @select="getShopCats($event, 'parent', '{{route('admin.product-cats.children')}}')"
                    @remove="removeShopCat('parent')" />
            </div>
            <div class="form-group">
                <input type="hidden" name="product_cat" :value="form.product_cat_id" autocomplete="off" />
                <label>Category</label>
                <multi-select v-model="form.product_cat" :options="shopCats" :show-labels="false" label="name"
                    track-by="id" autocomplete="off" :clear-on-select="false" placeholder="Category"
                    :close-on-select="true" :disabled="!form.parent_cat"
                     @select="getShopCats($event, 'product_cat', '{{route('admin.product-cats.children')}}', false)"
                     @remove="removeShopCat('product_cat')" />
            </div>
            <div class="form-group">
                <input type="hidden" name="product" :value="form.product_id" autocomplete="off" />
                <label>Product</label>
                <multi-select v-model="form.product" :options="products" :show-labels="false" label="title"
                    track-by="id" autocomplete="off" :clear-on-select="false" placeholder="Specific Product"
                    :close-on-select="true" :disabled="!form.product_cat"
                    @select="($event) => (form.product_id = $event.id)"
                     @remove="($event) => (form.product_id = '')"
                     />
            </div>
            <div class="form-group">
                <label>Shipping Method</label>
                <input type="hidden" name="delivery_method" class=" required" :value="form.delivery_method_id" autocomplete="off" />
                <multi-select v-model="form.delivery_method" :options="{{$methods}}" :show-labels="false" label="title"
                    track-by="id" autocomplete="off" :clear-on-select="false" placeholder="Delivery Method"
                    :close-on-select="true"
                     @select="($event) => (form.delivery_method_id = $event.id)"
                     @remove="($event) => (form.delivery_method_id = '')"
                      />
            </div>
            <div class="form-group">
                <label>Price</label>
                <input  class="form-control required" placeholder="delivery price" type="number" name="price">
            </div>

            <div class="my-2 text-right form-group">
                <button type="submit" class="btn btn-success">create</button>
            </div>
        </form>
        <button id="form-updater" class="d-none" @click.prevent="updateForm($event)" data-items='{}'></button>
    </x-admin-modal>
        <x-admin-modal title="Delivery Price" id="preview-modal">
        <div>
            <h3 id="price"></h3>
        </div>
        <hr class="btn-success"/>
        <div>
            <div class="col-12" id="preview-description"></div>
        </div>
    </x-admin-modal>
</div>
@endsection

@section('js')
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
<script src="/vendor/tinymce/tinymce.min.js"></script>


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
