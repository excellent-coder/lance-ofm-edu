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
                                <span class="badge bg-pink"><?=count($tags)?></span>
                               Tags
                            </h4>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-danger bulk-action" title="Delete all selected categories"
                                @click.prevent="destroy($event.target)"
                                data-action="{{route('admin.tags.destroy')}}" data-id="">
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
            <x-admin-card-tool title="Post Categories">
                <button class="text-white btn btn-success btn-tool dropdown-toggle btn-sm" data-target="#general-modal"
                    @click="modalEdit($event.target, true)" data-form="general-modal-form"
                    data-store_route="{{route('admin.tags.store')}}">
                    new Tag
                </button>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="my-3 col-12" style="background-color: indigo;">
                        <div class="row justify-content-end">
                            <button class="btn btn-success" data-target="#general-modal"
                                @click="modalEdit($event.target, true)" data-form="general-modal-form"
                                data-store_route="{{route('admin.tags.store')}}">
                                new Tag
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
                                    <th>tag</th>
                                    <th>Active</th>
                                    <th>Total Post</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @php
                                $action = [
                                'modal'=>'general',
                                'destroy'=> route('admin.tags.destroy'),
                                'form'=>'general-modal-form',
                                ];
                                @endphp
                                @foreach ($tags as $c)
                                <?php
                                $action['id'] = $c->id;
                                $action['update_route']= route("admin.tags.update", $c->id);
                                $action['rowid'] = "#tr-cats-$c->id";

                                $action['item']= json_encode([
                                    'tag'=>$c->tag,
                                    'active'=>$c->active,
                                    ]);
                                ?>
                                <tr id="tr-cats-{{$c->id}}">
                                    <td><input type="checkbox" value="{{$c->id}}" class="checking"></td>
                                    <td>{{$i++}}</td>
                                    <td>
                                        <a href="{{route('tags.show', $c->slug)}}" target="_blank" rel="noopener noreferrer">
                                            {{$c->tag}}
                                        </a>
                                    </td>
                                    <td>{{json_encode(boolval($c->active))}}</td>
                                    <td>{{$c->posts->count()}}</td>
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
                                    <th>tag</th>
                                    <th>Active</th>
                                    <th>Total Post</th>
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
    <x-admin-modal title="Managing Post Tags">
        <form action="{{route('admin.tags.store')}}" autocomplete="off" @submit.prevent="submit($event)"
            id="general-modal-form">

            <div class="form-group">
                <label>Tag</label>
                <input class="form-control required" placeholder="Tag" type="text"
                 name="tag" id="editing-tag">
            </div>
            <div class="form-group">
                <div class="checkbox checkbox-primary p-t-0">
                    <input data-checked="true" id="editing-active" checked type="checkbox" class="form-check-input form-control" name="active" value="1">
                    <label for="editing-active">
                       Active
                    </label>
                    <small class="form-text text-muted">
                        Toggle to determine the status of all that belongs to this tag
                    </small>
                </div>
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
