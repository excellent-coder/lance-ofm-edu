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
        <div class="card collapsed-card">
            <x-admin-card-tool :title="$student->first_name.' '. $student->last_name">
                <div class=" dropdown-divider"></div>
                <a href="{{route('admin.scs.create')}}" class=" btn btn-success btn-sm">
                    new Student
                </a>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="my-3 col-12" style="background-color: indigo;">
                        <div class="row justify-content-end">
                            <a href="{{route('admin.scs.create')}}" class="btn btn-success">
                                new Student
                            </a>
                        </div>
                    </div>
                    <div class="col-12">
                        @foreach ($student->toArray() as $k=>$v)
                            <div class="row">
                                <div class="col-md-3 col-12">
                                    <h6 class=" font-weight-bold">
                                        {{Str::title(str_replace('_', ' ', $k ))}}
                                    </h6>
                                </div>
                                <div class="ml-md-auto col-md-8 col-12">{{$v}}</div>
                            </div>
                            <hr class="w-full bg-danger">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="card collapsed-card" id="payments">
            <x-admin-card-tool title="{{$student->first_name .' '. $student->last_name}}'s Payments">
            </x-admin-card-tool>
            <div class="card-body">
                <div class="row">
                    <div class="mt-5 col-12">
                        <table id="dataTable" class="table table-bordered table-striped dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Amount</th>
                                    <th>Reason</th>
                                    <th>Ref</th>
                                    <th>Status</th>
                                    <th>Paid On</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @php
                                $action = [
                                'destroy'=> route('admin.scs.destroy'),
                                ];
                                @endphp
                                @foreach ($student->payments as $c)
                                <?php
                                $action['id'] = $c->id;
                                $action['rowid'] = "#tr-$c->id";
                                ?>
                                <tr id="tr-{{$c->id}}">
                                    <td>{{$i++}}</td>
                                    <td>{{$c->amount}}</td>
                                    <td>
                                        {{$c->reason}}
                                    </td>
                                    <td>
                                        {{$c->ref}}
                                    </td>
                                    <td>{{$c->status}}</td>
                                    <td>{{$c->paid_at}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Amount</th>
                                    <th>Reason</th>
                                    <th>Ref</th>
                                    <th>Status</th>
                                    <th>Paid On</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="card collapsed-card">
            <x-admin-card-tool title="{{$student->first_name .' '. $student->last_name}}'s Programs">
                <div class="dropdown-divider"></div>
                <a href="{{route('admin.scs.create')}}" class=" btn btn-success btn-sm">
                    new Student
                </a>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="mt-5 col-12">
                        <div class="text-center bg-gradient-success">
                            <h4 class="p-2 mb-4 ">{{$student->first_name}}'s Programs</h4>
                        </div>
                        <table id="programTable" class="table table-bordered table-striped dataTable">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="checkbox">
                                    </th>
                                    <th>#</th>
                                    <th>Program</th>
                                    <th>View</th>
                                    <th>Session</th>
                                    <th>Level</th>
                                    <th>Applied On</th>
                                    <th>Approved On</th>
                                    <th>Start At</th>
                                    <th>End At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @php
                                $action = [
                                'destroy'=> route('admin.scs.destroy'),
                                ];
                                @endphp
                                @foreach ($student->allPrograms as $c)
                                <?php
                                $action['id'] = $c->id;
                                $action['rowid'] = "#tr-$c->id";
                                ?>
                                <tr id="tr-{{$c->id}}">
                                    <td><input type="checkbox" value="{{$c->id}}" class="checking"></td>
                                    <td>{{$i++}}</td>
                                    <td>{{$c->title}}</td>
                                    <td>
                                        <a title="view student details"
                                            href="{{route('admin.scs.app', $c->pivot->id)}}"
                                            target="_blank">
                                            <i class="fa fa-eye text-success" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                    <td>{{App\Models\Session::find($c->pivot->session_id)->name??''}}</td>
                                    <td>{{App\Models\Level::find($c->pivot->level_id)->name??''}}</td>
                                    <td>{{$c->pivot->created_at}}</td>
                                    <td>{{$c->pivot->approved_at}}</td>
                                    <td>{{$c->pivot->start_at}}</td>
                                    <td>{{$c->pivot->end_at}}</td>
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
                                     <th>Program</th>
                                    <th>View</th>
                                    <th>Session</th>
                                    <th>Level</th>
                                    <th>Applied On</th>
                                    <th>Approved On</th>
                                    <th>Start At</th>
                                    <th>End At</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}
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

    $("#programTable").DataTable({
        "responsive": true,
        "autoWidth": false,
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": [0, -1]
        }],
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#programTable_wrapper .col-md-6:eq(0)');

</script>
@endsection
