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
            <x-admin-card-tool title="{{$app->student->first_name }}'s Program Registration">
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="mt-5 col-12">
                        <div class="text-center bg-gradient-success">
                            <h4 class="p-2 mb-4 ">{{$app->student->first_name}}'s Programs</h4>
                        </div>
                        <form @submit.prevent="submit($event)" action="{{route('admin.scs.program.approve', $app->id)}}" method="post">
                        <div class="row">
                            <div class="col-12 col-lg-8 offset-lg-2">
                                <div class=" row">
                                    <div class="col-12 col-md-3">
                                        <label>
                                        Student
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        {{$app->student->first_name .' '. $app->student->last_name}}
                                    </div>
                                    <hr class="bg-black col-12">
                                </div>
                                <div class=" row">
                                    <div class="col-12 col-md-3">
                                        <label>Program</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        {{$app->program->title}}
                                    </div>
                                    <hr class="bg-black col-12">
                                </div>
                                <div class=" row">
                                    <div class="col-12 col-md-3">
                                        <label>Session</label>
                                    </div>
                                    <div class="col-12 col-md-9 form-group">
                                        <select id="session" class="form-control select2 required" name="session" data-placeholder="Session">
                                            @if ($app->approved)
                                            @foreach ($sessions as $s)
                                                <option {{$s->id == $app->session_id?'selected':''}} value="{{$s->id}}">
                                                    {{$s->name}}
                                                </option>
                                            @endforeach
                                            @else
                                            @foreach ($sessions as $s)
                                                <option {{$s->active?'selected':''}} value="{{$s->id}}">
                                                    {{$s->name}}
                                                </option>
                                            @endforeach

                                            @endif
                                        </select>
                                    </div>
                                    <hr class="bg-black col-12">
                                </div>
                                <div class=" row">
                                    <div class="col-12 col-md-3">
                                        <label>Level</label>
                                    </div>
                                    <div class="col-12 col-md-9 form-group">
                                        <select id="level" class="form-control select2 required" name="level" data-placeholder="Level">
                                            @foreach ($levels as $s)
                                                <option {{$s->id == $app->level_id?'selected':''}} value="{{$s->id}}">
                                                    {{$s->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted">
                                            The level at which a usre will be before taking this program
                                        </small>
                                    </div>
                                    <hr class="bg-black col-12">
                                </div>
                                <div class=" row">
                                    <div class="col-12 col-md-3">
                                        <label>Starting Date</label>
                                    </div>
                                    <div class="col-12 col-md-9 form-group">
                                        <input value="{{dt($app->start_at)}}" type="datetime-local" name="start_at"
                                        class=" form-control wtk">
                                    </div>
                                    <hr class="bg-danger col-12">
                                </div>
                                <div class=" row">
                                    <div class="col-12 col-md-3">
                                        <label>Ending Date</label>
                                    </div>
                                    <div class="col-12 col-md-9 form-group">
                                        <input value="{{dt($app->end_at)}}" type="datetime-local" name="end_at"
                                        class="form-control wtk">
                                        <small class="form-text text-muted">
                                            The date at which the user will stop seeing this
                                            studies wil expire for this student
                                        </small>
                                    </div>
                                    <hr class="bg-primary col-12">
                                </div>
                                <div class=" row">
                                    <div class="col-12 col-md-3">
                                        <label>Approve</label>
                                    </div>
                                    @if ($app->approved_at)
                                    <label>
                                        {{$app->approved_at}}
                                    </label>
                                    @else
                                    <div class="col-12 col-md-9 form-group">
                                        <div class="checkbox checkbox-primary">
                                            <input id="approved" type="checkbox" class="form-check-input form-control"
                                                name="approve" value="1">
                                            <label for="approved">
                                                Approve
                                            </label>
                                        </div>
                                    </div>
                                    @endif
                                    <hr class="bg-primary col-12">
                                </div>

                                <div class="form-group">
                                   <button type="submit" class="btn btn-success btn-block">update</button>
                                </div>
                            </div>
                        </div>
                        </form>
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
