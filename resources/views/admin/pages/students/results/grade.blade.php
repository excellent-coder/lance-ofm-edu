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
                        <div class="col-6">
                            <button class="btn btn-danger bulk-action" title="Delete all selected students"
                                @click.prevent="destroy($event.target)" data-action="{{route('admin.scs.destroy')}}">
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
            <x-admin-card-tool title="Student results for {{$session->name}} session">
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
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
                                    <th>Average</th>
                                    <th>Passed</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @php
                                $action = [
                                'destroy'=> route('admin.scs.destroy'),
                                'form'=>'general-modal-form',
                                'modal'=>'general',
                                ];
                                @endphp
                                @foreach ($students as $c)
                                <?php
                                $action['id'] = $c->id;
                                $action['rowid'] = "#tr-$c->id";
                                $action['update_route']= route("admin.students.grades.update", $c->id);
                                $action['item'] =collect([
                                    'id'=>$c->id,
                                    'student'=>$c->student->name,
                                    'session'=>$c->session->name,
                                    'level'=>$c->level->name,
                                    'average'=>$c->average,
                                    'passed'=>$c->passed,
                                    'program'=>$c->program->abbr,
                                ]);
                                ?>
                                <tr id="tr-{{$c->id}}">
                                    <td><input type="checkbox" value="{{$c->id}}" class="checking"></td>
                                    <td>{{$i++}}</td>
                                    <td>{{$c->student->name}}</td>
                                    <td>{{$c->program->abbr??'N/A'}}</td>
                                    <td>{{$c->session->name}}</td>
                                    <td>{{$c->level->name}}</td>
                                    <td>{{$c->average}}</td>
                                    <td>{{$c->passed}}</td>
                                    <td>
                                        <x-data-table-action :action="$action">
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
<x-admin-modal>
    <form action="{{route('admin.sessions.store')}}" autocomplete="off" @submit.prevent="submit($event)"
        id="general-modal-form">
        <input type="hidden" name="active_session" id="active_session">
        <div class="form-group">
            <label>Student</label>
            <input class="form-control" placeholder="student name" type="text" readonly id="editing-student">
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                <label>Session</label>
                <input class="form-control" placeholder="session name" type="text" readonly id="editing-session">
            </div>
             <div class="form-group col-sm-6">
            <label>Level</label>
            <input class=" form-control" placeholder="Program" type="text" readonly id="editing-level">
        </div>
        </div>
        <div class="form-group">
            <label>Program</label>
            <input class=" form-control" placeholder="Program" type="text" readonly id="editing-program">
        </div>

        <div class="row">
            <div class="form-group col-sm-6">
                <label>Average</label>
                <input class=" form-control required" placeholder="average" type="text" id="editing-average" name="average">
            </div>
            <div class="form-group col-sm-6">
                <label>&nbsp;</label>
                <div class="checkbox checkbox-primary">
                    <input id="editing-passed"  type="checkbox"
                        class="form-check-input form-control" name="passed" value="1">
                    <label for="editing-passed">
                        Passed
                    </label>
                </div>
            </div>
        </div>

        <div class="my-2 text-right form-group">
            <button type="submit" class="btn btn-success">Update</button>
        </div>
    </form>
</x-admin-modal>
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

    $(document).on('click', '#dataTable .update-student', function () {
        let b = $(this);
       let item = b.data('item')
        let form = $('#general-modal-form')
        $('#student').val(item.student);

        $('#general-modal').modal('show');
    })

</script>
@endsection
