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
                <button class="btn  btn-success btn-tool dropdown-toggle btn-sm text-white" data-target="#general-modal"
                    @click="modalEdit($event.target, true)" data-form="general-modal-form"
                    data-store_route="{{route('admin.product-cats.store')}}">
                    new Category
                </button>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="col-12 my-3" style="background-color: indigo;">
                        <div class="row justify-content-end">
                            <button class="btn  btn-success" data-target="#general-modal"
                                @click="modalEdit($event.target, true); form={}" data-form="general-modal-form"
                                data-store_route="{{route('admin.product-cats.store')}}">
                                new Category
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
                                    <th>Category</th>
                                    <th>parent</th>
                                    <th>Super Parent</th>
                                    <th>Total products</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @php
                                $action = [
                                'modal'=>'general',
                                'destroy'=> route('admin.product-cats.destroy'),
                                'form'=>'general-modal-form',

                                ];
                                @endphp
                                @foreach ($categories as $c)
                                <?php
                                $action['id'] = $c->id;
                                $action['update_route']= route("admin.product-cats.update", $c->id);
                                $action['rowid'] = ".tr-cats-$c->id";
                                $parent_cat= $c->parent?[
                                    'id'=>$c->parent->id, 'name'=>$c->parent->name
                                    ]:null;
                                    $super_cat=$c->superParent?[
                                        'id'=>$c->superParent->id, 'name'=>$c->superParent->name
                                        ]:null;

                                $action['item']= json_encode([
                                    'name'=>$c->name,
                                    'parent_id'=>$c->parent_id,
                                    'super_parent_id'=>$c->super_parent_id,
                                    'parent_cat'=>$parent_cat,
                                    'super_cat'=>$super_cat
                                    ]);
                                ?>
                                <tr class="tr-cats-{{$c->id}}">
                                    <td><input type="checkbox" class="checking"></td>
                                    <td>{{$i++}}</td>
                                    <td>{{$c->name}}</td>
                                    <td>{{$c->parent?$c->parent->name:'false'}}</td>
                                    <td>{{$c->superParent?$c->superParent->name:'false'}}</td>
                                    <td>{{$c->products->count()}}</td>
                                    <td>
                                        <x-data-table-action :action="$action"></x-data-table-action>
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
                                    <th>Name</th>
                                    <th>parent</th>
                                    <th>Visibility</th>
                                    <th>Total Users</th>
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
    <x-admin-modal title="Shop Category">
        <form action="{{route('admin.product-cats.store')}}" autocomplete="off" @submit.prevent="submit($event)"
            id="general-modal-form">

            <div class="form-group">
                <input type="hidden" name="super_parent_id" :value="form.super_parent_id" autocomplete="off" />
                <label>Super Category</label>
                <multi-select v-model="form.super_cat" :options="{{$supers}}" :show-labels="false"
                label="name" track-by="id"
                    autocomplete="off" :clear-on-select="false" placeholder="Super Category"
                    :close-on-select="true"
                    @select="getShopCats($event, 'super', '{{route('admin.product-cats.children')}}')"
                    @remove="($event) => (form.super_parent_id = '')"
                    />
            </div>
            <div class="form-group">
                <input type="hidden" name="parent_id" :value="form.parent_id" autocomplete="off" />
                <label>Parent Category</label>
                <multi-select v-model="form.parent_cat" :options="parentShopCats" :show-labels="false"
                label="name" track-by="id"
                    autocomplete="off" :clear-on-select="false" placeholder="Super Category"
                    :close-on-select="true"
                    :disabled="!form.super_cat"
                    @select="($event) => (form.parent_id = $event.id)"
                     @remove="($event) => (form.parent_id = '')"
                    />
            </div>
            <div class="form-group">
                <label>Category Name</label>
                <input class="form-control required" placeholder="category" type="text" name="name" id="editing-name">
            </div>


            <div class="form-group text-right my-2">
                <button type="submit" class="btn btn-success">create</button>
            </div>
        </form>
        <button id="form-updater" class="d-none" @click.prevent="updateForm($event)"
        data-items='{}'></button>
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
