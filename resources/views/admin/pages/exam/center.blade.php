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
            <x-admin-card-tool title="Exam Centers">
                <button class="btn btn-success btn-sm" data-target="#general-modal"
                    @click="modalEdit($event.target, true)" data-form="general-modal-form"
                    data-store_route="{{route('admin.exam-c.store')}}">
                    <i class="fas fa-plus" aria-hidden="true"></i>
                    Center
                </button>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="my-3 col-12" style="background-color: indigo;">
                        <div class="row justify-content-end">
                            <button class="btn btn-primary btn-success" data-target="#general-modal"
                                @click="modalEdit($event.target, true)" data-form="general-modal-form"
                                data-store_route="{{route('admin.exam-c.store')}}">
                                <i class="fas fa-plus" aria-hidden="true"></i>
                                Center
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
                                    <th>Name</th>
                                    <th>capacity</th>
                                    <th>address</th>
                                    <th>image</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @php
                                $action = [
                                'modal'=>'general',
                                'form'=>'general-modal-form',

                                ];
                                @endphp
                                @foreach ($centers as $c)
                                <?php
                                $action['id'] = $c->id;
                                $action['update_route']= route("admin.exam-c.update", $c->id);
                                $action['rowid'] = "#tr-$c->id";
                                $action['item']= $c;
                                ?>
                                <tr id="tr-{{$c->id}}">
                                    <td><input type="checkbox" class="checking"></td>
                                    <td>{{$i++}}</td>
                                    <td>{{$c->name}}</td>
                                    <td>{{$c->capacity}}</td>
                                    <td>{{$c->address}}</td>
                                    <td>
                                        @if ($c->image)
                                         <img src="/storage/{{$c->image}}" alt="">
                                         @else
                                         N/A
                                        @endif
                                    </td>
                                    <td>{{$c->created_at??'nil'}}</td>
                                    <td>{{$c->updated_at??'nil'}}</td>
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
                                    <th>capacity</th>
                                    <th>address</th>
                                    <th>image</th>
                                    <th>Created</th>
                                    <th>Updated</th>
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
    <x-admin-modal>
        <form action="{{route('admin.exam-c.store')}}" autocomplete="off" @submit.prevent="submit($event)"
            id="general-modal-form">
            <div class="form-group">
                <label>Center Name</label>
                <input class="form-control required" placeholder="Center Name" type="text" name="name"
                    id="editing-name">
            </div>
            <div class="form-group">
                <label>Capacity</label>
                <input class=" form-control required" placeholder="Capacity" type="number" min="1"  name="capacity" id="editing-capacity">
                <small class="form-text text-muted">Maximun NUmber of seats</small>
            </div>
            <div class="form-group">
                <label>Center Address</label>
                <textarea class=" form-control required" placeholder="Center Address" name="address" id="editing-address"></textarea>
            </div>
             <div class="form-group">
                <label for="image">Preview Image</label>
                <input type="file" class="form-control-file simple-file" accept="image/*" name="image" id="image" placeholder="Image">
                <small id="docs-help" class="form-text text-muted">Center Preview Image, optional</small>
            </div>
            <div class="my-2 text-right form-group">
                <button type="submit" class="btn btn-success">create</button>
            </div>
        </form>
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
