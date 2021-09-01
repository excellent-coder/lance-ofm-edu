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
                <button class="text-white btn btn-success btn-sm" data-target="#general-modal"
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
                                    <th>Application Fee</th>
                                    <th>Induction Fee</th>
                                    <th>Annual Fee</th>
                                    <th>Parent</th>
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
                                $action['item']= $c;
                                $fa_icon = $c->active?'check':'times';

                                $active =$c->active?'remove':'activate';
                                ?>
                                <tr id="tr-{{$c->id}}">
                                    <td><input type="checkbox" class="checking"></td>
                                    <td>{{$i++}}</td>
                                    <td>{{$c->name}}</td>
                                    <td>{{$currency .' '. number_format( $c->application_fee, 2)}}</td>
                                    <td>{{$currency .' '. number_format($c->induction_fee, 2)}}</td>
                                    <td>{{$currency .' '. number_format( $c->annual_fee, 2)}}</td>
                                    <td>{{$c->parent->name ?? 'N/A'}}</td>
                                    <td>{{$c->members->count()??'nil'}}</td>
                                    <td>{{$c->pending->count()??'nil'}}</td>
                                    <td>{{bv($c->active)}}</td>
                                    <td>{{$c->updated_at??'nil'}}</td>
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
                                    <th>Application Fee</th>
                                    <th>Induction Fee</th>
                                    <th>Annual Fee</th>
                                    <th>Parent</th>
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
                <label class=" position-relative">
                    Application Fee
                    <span class=" fa-2x position-relative" style="top: .3rem;">•</span>
                    Administrative Fee
                </label>
                <input id="editing-application_fee" class="form-control" type="text" inputmode="numeric"
                    pattern="([\d]+)(\.)?(\d{1,2})" name="application_fee" placeholder="Application Fee">
            </div>
            <div class="form-group">
                <label>
                    Induction Fee
                </label>
                <input id="editing-induction_fee" class="form-control" type="text" inputmode="numeric"
                    pattern="([\d]+)(\.)?(\d{1,2})" name="induction_fee" placeholder="Induction Fee">
            </div>
            <div class="form-group">
                <label>
                   Annual Dues
                </label>
                <input id="editing-annual_fee" class="form-control" type="text" inputmode="numeric"
                    pattern="([\d]+)(\.)?(\d{1,2})" name="annual_fee" placeholder="Annual Fee">
            </div>
            <div class="form-group">
                <label for="editing-parent_id">Parent</label>
                <select data-value="" data-placeholder="parent Memebership" id="editing-parent_id"
                    class="form-control select2" name="parent">
                    <option value=" ">-None-</option>
                    @foreach ($memberships as $m)
                    <option value="{{$m->id}}">{{$m->name}}</option>
                    @endforeach
                </select>
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
