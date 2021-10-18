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
                                <span class="badge bg-pink"><?=count($results)?></span>
                                Short Course Student results for {{$year}}
                            </h4>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-danger bulk-action"
                                title="Delete all selected students"
                                @click.prevent="destroy($event.target)"
                                data-action="{{route('admin.scs.destroy')}}"
                                >
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
            <x-admin-card-tool title="Student results for {{$year}} session">
                <div class=" dropdown-divider"></div>
                <a href="{{route('admin.students.results.create')}}" class=" btn btn-success btn-sm">
                    Add Result
                </a>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="my-3 col-12" style="background-color: indigo;">
                        <div class="row justify-content-end">
                            <a href="{{route('admin.students.results.create')}}" class="btn btn-success">
                                Add Result
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
                                    <th>Student</th>
                                    <th>program</th>
                                    <th>Session</th>
                                    <th>Level</th>
                                    <th>Course</th>
                                    <th>Score</th>
                                    <th>Retaken</th>
                                    <th>Exam Date</th>
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
                                @foreach ($results as $c)
                                <?php
                                $action['id'] = $c->id;
                                $action['rowid'] = "#tr-$c->id";
                                ?>
                                <tr id="tr-{{$c->id}}">
                                    <td><input type="checkbox" value="{{$c->id}}" class="checking"></td>
                                    <td>{{$i++}}</td>
                                    <td>{{$c->student->name}}</td>
                                    <td>{{$c->program->abbr}}</td>
                                    <td>{{$c->session->name}}</td>
                                    <td>{{$c->level->name}}</td>
                                    <td>{{$c->course->code}}</td>
                                    <td>{{$c->score}}</td>
                                    <td>{{bv($c->retaken)}}</td>
                                    <td>{{$c->exam_date}}</td>
                                    <td>
                                        <x-data-table-action :action="$action">
                                            <a href="{{route('admin.students.results.edit', $c->id)}}">
                                                <i class="fas fa-pen" aria-hidden="true"></i>
                                            </a>
                                        </x-data-table-action>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
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
