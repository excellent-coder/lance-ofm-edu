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
            <x-admin-card-tool title="Memberships">
                <button class="text-white btn btn-success btn-tool dropdown-toggle btn-sm" data-target="#general-modal"
                    @click="modalEdit($event.target, true)" data-form="general-modal-form"
                    data-store_route="{{route('admin.memberships.store')}}">
                    new membership
                </button>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="my-3 col-12" style="background-color: indigo;">
                        <div class="row justify-content-end">
                            <button class="btn btn-primary btn-success" data-target="#general-modal"
                                @click="modalEdit($event.target, true)" data-form="general-modal-form"
                                data-store_route="{{route('admin.memberships.store')}}">
                                new membership
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
                                    <th>Form</th>
                                    <th>Members</th>
                                    <th>pending Approvals</th>
                                    <th>Status</th>
                                    <th>Updated</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @php
                                $action = [
                                'modal'=>'general',
                                'destroy'=> route('admin.memberships.destroy'),
                                'form'=>'general-modal-form',

                                ];
                                @endphp
                                @foreach ($memberships as $c)
                                <?php
                                $action['id'] = $c->id;
                                $action['update_route']= route("admin.memberships.update", $c->id);
                                $action['rowid'] = "#tr-$c->id";
                                $action['item']= json_encode([
                                    'name'=>$c->name,
                                    'active'=>$c->active,
                                ]);
                                $fa_icon = $c->active?'check':'times';

                                $active =$c->active?'remove':'activate';
                                ?>
                                <tr id="tr-{{$c->id}}">
                                    <td><input type="checkbox" class="checking"></td>
                                    <td>{{$i++}}</td>
                                    <td>{{$c->name}}</td>
                                    <td>
                                        @if ($c->form)
                                        @php
                                            $f = explode('/', $c->form);
                                        @endphp
                                        <a href="/storage/{{$c->form}}" target="_blank"
                                         rel="noopener noreferrer">
                                         {{ end($f) }}
                                         </a>
                                            @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{$c->members->count()??'nil'}}</td>
                                    <td>{{$c->pending->count()??'nil'}}</td>
                                    <td>{{bv($c->active)}}</td>
                                    <td>{{$c->updated_at??'nil'}}</td>
                                    <td>
                                        <x-data-table-action :action="$action">
                                            <button data-route="{{route('admin.memberships.activate', $c->id)}}"
                                                title="{{$active}}" class="btn activate-btn" data-rowid="#tr-$c->id">
                                                <i class="fas fa-{{$fa_icon}} text-success"></i>
                                            </button>
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
                                    <th>Name</th>
                                    <th>Form</th>
                                    <th>Total Approved</th>
                                    <th>pending Approvals</th>
                                    <th>Status</th>
                                    <th>Updated</th>
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
        <form action="{{route('admin.memberships.store')}}" autocomplete="off" @submit.prevent="submit($event)"
            id="general-modal-form">
            <div class="form-group">
                <label>Membership Name</label>
                <input class="form-control required" placeholder="membership name" type="text" name="name"
                    id="editing-name">
            </div>
            <div class="form-group">
                <label for="form">Form</label>
                <input type="file" accept=".pdf,.docx,.doc,.txt" class="form-control-file" name="form" id="form" placeholder="Form"
                    aria-describedby="appForm">
                <small id="appForm" class="form-text text-muted">Application Form</small>
            </div>
            <div class="my-2 checkbox checkbox-primary">
                <input id="editing-active" data-checked="1" type="checkbox"
                class="form-check-input form-control filled-in" name="active" value="1">
                <label for="editing-active">
                    Active
                    <small class=" text-muted">Check to allow this membership to accept applications</small>
                </label>
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
