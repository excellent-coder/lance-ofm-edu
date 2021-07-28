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
            <x-admin-card-tool title="User Categories" :links="$cardLinks">
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="col-12 my-3 " style="background-color: rgb(16, 17, 90);">
                        <div class="row justify-content-between">
                            <h4 class=" text-white mr-3">{{$title}}</h4>
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
                                    <th>Category</th>
                                    <th>Applied On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i=1;
                                $action = [
                                'modal'=>'general',
                                'destroy'=> route('admin.applications.destroy'),
                                'form'=>'general-modal-form',
                                'icon'=>'eye'
                                ];
                                @endphp
                                @foreach ($apps as $a)
                                <?php
                                        $action['item']= json_encode([
                                            'name'=>$a->user->name,
                                            ]);
                                            $approve = $a->approved_at?'check':'times';
                                            $approve_title =$a->apprved_at?'un-approve':'Approve';
                                        $action['rowid'] = "#tr-app-$a->id";
                                        $action['id'] = $a->id;
                                        $action['update_route'] = route("admin.applications.update", $a->id);
                                        $action['btns'] =[
                                            "<button data-route=\"".route('admin.applications.approve', $a->id)."\"
                                            title='$approve_title' class='btn activate-btn' data-id='$a->id'
                                             data-rowid='#tr-app-$a->id'>
                                            <i class='fas fa-$approve text-success'></i>
                                            </button>"
                                            ];
                                        ?>
                                <tr id="tr-app-{{$a->id}}">
                                    <td><input type="checkbox" class="checking"></td>
                                    <td>{{$i++}}</td>
                                    <td>{{$a->user->name}}</td>
                                    <td>{{$a->category?$a->category->name:'DELETED'}}</td>
                                    <td>{{$a->created_at}}</td>
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
    <x-admin-modal>
        <form action="{{route('admin.user-categories.store')}}" autocomplete="off" @submit.prevent="submit($event)"
            id="general-modal-form">
            <div class="form-group">
                <label>Category Name</label>
                <input class="form-control required" type="text" name="name" id="editing-name">
            </div>

            <div class="form-group text-right my-2">
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
