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
                                <span class="badge bg-pink"><?=count($subjects)?></span>
                                subjects
                            </h4>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-danger bulk-action"
                                title="Delete all selected subjects"
                                @click.prevent="destroy($event.target)"
                                data-action="{{route('admin.subjects.destroy')}}"
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
                <button class="btn btn-success btn-tool dropdown-toggle btn-sm text-white" data-target="#general-modal"
                    @click="modalEdit($event.target, true)" data-form="general-modal-form"
                    data-store_route="{{route('admin.subjects.store')}}">
                    new Subject
                </button>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="col-12 my-3" style="background-color: indigo;">
                        <div class="row justify-content-end">
                            <button class="btn btn-success" data-target="#general-modal"
                                @click="modalEdit($event.target, true)" data-form="general-modal-form"
                                data-store_route="{{route('admin.subjects.store')}}">
                                new Subject
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
                                    <th>User Category</th>
                                    <th>Total Users</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @php
                                $action = [
                                'modal'=>'general',
                                'destroy'=> route('admin.subjects.destroy'),
                                'form'=>'general-modal-form',

                                ];
                                @endphp
                                @foreach ($subjects as $c)
                                <?php
                                $action['id'] = $c->id;
                                $action['update_route']= route("admin.subjects.update", $c->id);
                                $action['rowid'] = ".tr-cats-$c->id";
                                    $xcats = '';
                                    $idCats = [];
                                    foreach ($c->categories as $s) {
                                        $idCats[] = $s->id;
                                        $xcats.= "$s->name |";
                                    }
                                $action['item']= json_encode([
                                    'name'=>$c->name,
                                    'code'=>$c->code,
                                    'user_category_id'=>$idCats
                                    ]);
                                    $xcats = trim($xcats, '|');
                                ?>
                                <tr class="tr-cats-{{$c->id}}">
                                    <td><input type="checkbox" value="{{$c->id}}" class="checking"></td>
                                    <td>{{$i++}}</td>
                                    <td>{{$c->name}}</td>
                                    <td>{{$xcats}}</td>
                                    <td>{{$c->users??'nil'}}</td>
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
                                    <th>User Category</th>
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
        <form action="{{route('admin.user-categories.store')}}" autocomplete="off" @submit.prevent="submit($event)"
            id="general-modal-form">
            <div class="form-group">
                <label>Subject name</label>
                <input class="form-control required" placeholder="subject name" type="text" name="name"
                    id="editing-name">
            </div>
            <div class="form-group">
                <label for="editing-user_category_id">User Group</label>
                <select id="editing-user_category_id" class="form-control required select2" name="user_category_id[]"
                    id="editing-user_category_id" multiple data-placeholder="Student Group">
                    <option value="" disabled>Student Group</option>
                    @foreach ($cats as $c)
                    <option value="{{$c->id}}">{{$c->name}}</option>
                    @if ($c->children->count() > 0)
                    <optgroup label="{{$c->name}}">
                        @foreach ($c->children as $s)
                        <option value="{{$s->id}}">{{$s->name}}</option>
                        @endforeach
                    </optgroup>
                    @endif
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Subject Code</label>
                <input class="form-control required" placeholder="subject code" type="text" name="code"
                    id="editing-code">
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
