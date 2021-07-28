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
                    data-store_route="{{route('admin.deliveries.store')}}">
                    new Delivery Method
                </button>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="col-12 my-3" style="background-color: indigo;">
                        <div class="row justify-content-end">
                            <button class="btn  btn-success" data-target="#general-modal"
                                @click="modalEdit($event.target, true); form={}" data-form="general-modal-form"
                                data-store_route="{{route('admin.deliveries.store')}}">
                                new Delibery Method
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
                                'destroy'=> route('admin.deliveries.destroy'),
                                'form'=>'general-modal-form',

                                ];
                                @endphp
                                @foreach ($deliveries as $c)
                                <?php
                                $action['id'] = $c->id;
                                $action['update_route']= route("admin.deliveries.update", $c->id);
                                $action['rowid'] = "#tr-cats-$c->id";

                                $action['item']= $c;
                                ?>
                                <tr id="tr-cats-{{$c->id}}">
                                    <td><input type="checkbox" class="checking"></td>
                                    <td>{{$i++}}</td>
                                    <td>{{$c->title}}</td>
                                    <td>
                                        <button class="btn btn-sidebar btn-sm preview modal-edit-btn"
                                          data-target="#preview-modal" type="button" data-item="{{$c}}">
                                        <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
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
    <x-admin-modal title="Shop Category">
        <form action="{{route('admin.deliveries.store')}}" autocomplete="off" @submit.prevent="submit($event)"
            id="general-modal-form">
            <div class="form-group">
                <label>Title</label>
                <input class="form-control required" placeholder="title" type="text" name="title" id="editing-title">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="editing-description" class="form-control tinymce required" name="description" rows="2"></textarea>
            </div>
            <div class="form-group text-right my-2">
                <button type="submit" class="btn btn-success">create</button>
            </div>
        </form>
        <button id="form-updater" class="d-none" @click.prevent="updateForm($event)"
        data-items='{}'></button>
    </x-admin-modal>
    <x-admin-modal title="Delivery Method" id="preview-modal">
        <h3 id="preview-title"></h3>
        <hr class="btn-success"/>
        <div class="col-12" id="preview-description">
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
