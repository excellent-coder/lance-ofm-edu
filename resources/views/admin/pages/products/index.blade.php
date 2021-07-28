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
            <x-admin-card-tool title="Products">
                 <a href="{{route('admin.products.create')}}" class="btn-success btn-sm">
                        new Product
                    </a>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="col-12 my-3" style="background-color: indigo;">
                    <div class="row justify-content-end">
                    <a href="{{route('admin.products.create')}}" class="btn btn-primary btn-success">
                        new product
                    </a>
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
                                    <th>title</th>
                                    <th>category</th>
                                    <th>price</th>
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
                                        'destroy'=> route('admin.products.destroy'),
                                    ];
                                 @endphp
                                @foreach ($products as $c)
                                <?php
                                $action['id'] = $c->id;
                                $action['route']= route('admin.products.edit', $c->id);
                                $action['rowid'] = "#tr-$c->id";

                                $fa_icon = $c->active?'check':'times';

                                $active =$c->active?'disable':'activate';
                                $action['btns'] =[
                                        "<button data-route=\"".route('admin.products.activate', $c->id)."\"
                                        title='$active' class='btn activate-btn'  data-rowid='#tr-$c->id'>
                                            <i class='fas fa-$fa_icon text-success'></i>
                                        </button>"
                                ];

                                $image = $c->images->count()>0 ? $c->images[0]->image:'';
                                ?>
                                <tr id="tr-{{$c->id}}">
                                    <td><input type="checkbox" class="checking"></td>
                                    <td>{{$i++}}</td>
                                    <td>
                                        <a href="{{route('shop.product', $c->slug)}}" target="_blank">
                                        {{$c->title}}
                                        </a>
                                    </td>
                                    <td>{{$c->category->name}}</td>
                                    <td>{{$c->price}}</td>
                                    <td>
                                        <img src="{{asset("storage/".$image)}}" alt="featured image">
                                    </td>
                                    <td>{{$c->created_at}}</td>
                                    <td>{{$c->updated_at}}</td>
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
                                    <th>Year</th>
                                    <th>Start</th>
                                    <th>End</th>
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
