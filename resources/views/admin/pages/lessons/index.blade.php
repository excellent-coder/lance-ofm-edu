@extends('layouts.admin')

@section('css')
{{-- DataTables --}}
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
                                <span class="badge bg-pink"><?=$lessons->count()?></span>
                                Lessons
                            </h4>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-danger bulk-action"
                                title="Delete all selected subjects"
                                @click.prevent="destroy($event.target)"
                                data-action="{{route('admin.lessons.destroy')}}"
                                data-id=""
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
            <x-admin-card-tool title="User Categories" :links="$cardLinks">
                <a href="{{route('admin.lessons.create')}}" class="text-white btn btn-success btn-tool btn-sm">
                    new Lesson
                </a>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="my-3 col-12" style="background-color: indigo;">
                        <div class="row justify-content-end">
                            <a href="{{route('admin.lessons.create')}}" class="btn btn-success">
                                new Lesson
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
                                    <th>Topic</th>
                                    <th>Course</th>
                                    <th>Program</th>
                                    <th>Materials</th>
                                    <th>Session</th>
                                    <th>Total Users</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @php
                                $action = [
                                'destroy'=> route('admin.lessons.destroy'),
                                'form'=>'general-modal-form',

                                ];
                                @endphp
                                @foreach ($lessons as $l)
                                <?php
                                $action['id'] = $l->id;
                                $action['route'] = route('admin.lessons.edit', $l->id);
                                $action['rowid'] = "#tr-less-$l->id";
                                ?>
                                <tr id="tr-less-{{$l->id}}">
                                    <td><input type="checkbox" value="{{$l->id}}" class="checking"></td>
                                    <td>{{$i++}}</td>
                                    <td>{{ Str::limit($l->topic, 100, '...')}}</td>
                                    <td>{{ $l->course->name??'-'}}</td>
                                    <td>{{ $l->course->program->abbr??'-' }}</td>
                                    <td>{{ $l->materials->count()}}</td>
                                    <td>{{ $l->session->name}}</td>
                                    <td>{{$l->users??'nil'}}</td>
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
                                    <th>Topic</th>
                                    <th>Subject</th>
                                    <th>Programs</th>
                                    <th>Materials</th>
                                    <th>Session</th>
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
    <x-admin-modal title="Managing subjects">
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
