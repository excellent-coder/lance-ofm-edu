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
                                <span class="badge bg-pink"><?=count($courses)?></span>
                                Courses
                            </h4>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-danger bulk-action"
                                title="Delete all selected courses"
                                @click.prevent="destroy($event.target)"
                                data-action="{{route('admin.courses.destroy')}}"
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
            <x-admin-card-tool title="Courses">
                <button class="text-white btn btn-success btn-sm" data-target="#general-modal"
                    @click="modalEdit($event.target, true)" data-form="general-modal-form"
                    data-store_route="{{route('admin.courses.store')}}">
                  Quick Add new Course
                </button>
                <div class=" dropdown-divider"></div>
                <a href="{{route('admin.courses.create')}}" class=" btn btn-success btn-sm">
                    new Course With Desc
                </a>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="my-3 col-12" style="background-color: indigo;">
                        <div class="row justify-content-end">
                            <button class="mr-4 btn btn-success" data-target="#general-modal"
                                @click="modalEdit($event.target, true)" data-form="general-modal-form"
                                data-store_route="{{route('admin.courses.store')}}">
                                Quick Add new course
                            </button>
                            <a href="{{route('admin.courses.create')}}" class="btn btn-success">
                                new Course With Desc
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
                                    <th>Name</th>
                                    <th>Program</th>
                                    <th>Level</th>
                                    <th>Total Students</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @php
                                $action = [
                                'modal'=>'general',
                                'destroy'=> route('admin.courses.destroy'),
                                'form'=>'general-modal-form',

                                ];
                                @endphp
                                @foreach ($courses as $c)
                                <?php
                                $action['id'] = $c->id;
                                $action['update_route']= route("admin.courses.update", $c->id);
                                $action['rowid'] = ".tr-cats-$c->id";


                                $action['item']= json_encode([
                                    'name'=>$c->name,
                                    'code'=>$c->code,
                                    ]);

                                ?>
                                <tr class="tr-cats-{{$c->id}}">
                                    <td><input type="checkbox" value="{{$c->id}}" class="checking"></td>
                                    <td>{{$i++}}</td>
                                    <td>{{$c->name}}</td>
                                    <td>{{$c->program->title ??'false'}}</td>
                                    <td>{{$c->level->name ??'false'}}</td>
                                    <td>{{$c->students->count()}}</td>
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
                                    <th>Program</th>
                                    <th>Level</th>
                                    <th>Total Students</th>
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
    <x-admin-modal title="Managing Courses">
        <form action="{{route('admin.user-categories.store')}}" autocomplete="off" @submit.prevent="submit($event)"
            id="general-modal-form">
            <input type="hidden" name="modal" value="1">
            <div class="form-group">
                <label>Course name</label>
                <input class="form-control required" placeholder="course name" type="text" name="name"
                    id="editing-name">
            </div>
            <div class="form-group">
                <label>Course Code</label>
                <input class="form-control required" placeholder="course code" type="text" name="code"
                    id="editing-code">
            </div>
            <div class="form-group">
                <label for="editing-program">Program</label>
                <select data-placeholder="Select Program" id="editing-program" class="form-control select2"
                 name="program_id">
                    @foreach ($programs as $p)
                        <option value="{{$p->id}}">{{$p->title}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="editing-level">Level</label>
                <select data-placeholder="Select Level" id="editing-level" class="form-control select2" name="level_id">
                    @foreach ($levels as $l)
                        <option value="{{$l->id}}">{{$l->name}}</option>
                    @endforeach
                </select>
            </div>
             <div class="form-group">
                <label for="visibility">Available To</label>
                <select id="visibility" class="form-control select2"
                    name="visibility">
                    <option value="1" selected>All Studenst</option>
                    <option value="2">Program Students Only</option>
                    <option value="3">Schort Course Studenst Only</option>
                </select>
                <small class="form-text text-muted">
                    You can use this to specify those who are eligible to apply for
                    this
                    program
                </small>
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
