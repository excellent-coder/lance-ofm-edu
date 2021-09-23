@extends('layouts.admin')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="/vendor/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/vendor/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="/vendor/datatables-buttons/css/buttons.bootstrap4.min.css">

@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6 text-md-left">
                            <h4 class="m-0 text-dark">
                                <span class="badge bg-pink">{{ $total = $members->count() }}</span>
                               {{Str::plural('Member', $total)}}
                            </h4>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-danger bulk-action" title="Delete all selected events"
                                @click.prevent="destroy($event.target)" data-action="{{route('admin.members.destroy')}}">
                                <i class="fas fa-trash-alt"></i> Bulk
                                (<span class="total-selected">0</span>)
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <x-admin-card-tool title="Applications">
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="my-3 col-12 " style="background-color: rgb(16, 17, 90);">
                        <div class="row justify-content-between">
                            <h4 class="px-3 text-white ">{{$title}}</h4>
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
                                    <th>MEMBER ID</th>
                                    <th>Payments</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Membership</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i=1;
                                $action = [
                                'destroy'=> route('admin.members.destroy'),
                                'form' => "general-modal-form",
                                'modal' => "general",
                                'icon'=>'eye'
                                ];
                                @endphp
                                @foreach ($members as $a)
                                <?php
                                    $action['rowid'] = "#tr-$a->id";
                                    $action['id'] = $a->id;
                                    $action['route'] = route('admin.members.show', $a->id);
                                ?>
                                <tr id="tr-{{$a->id}}">
                                    <td><input type="checkbox" class="checking" value="{{$a->id}}"></td>
                                    <td>{{$i++}}</td>
                                    <td>{{$a->member_id }}</td>
                                    <td>
                                        <a href="{{route('admin.members.payments.mem', $a->id)}}" target="_blank">
                                        <i class="fas fa-external-link-alt "></i>
                                    </a>
                                    </td>
                                    <td>{{$a->name }}</td>
                                    <td>{{$a->phone }}</td>
                                    <td>{{$a->email }}</td>
                                    <td>{{ $a->membership->name }}</td>
                                    <td>
                                        <x-data-table-action :action="$action">
                                        </x-data-table-action>
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
                                     <th>MEMBER ID</th>
                                    <th>Payments</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Membership</th>
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
