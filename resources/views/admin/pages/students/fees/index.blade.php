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
            <x-admin-card-tool title="Student Fees">
                <button class="text-white btn btn-success btn-tool dropdown-toggle btn-sm" data-target="#general-modal"
                    @click="modalEdit($event.target, true)" data-form="general-modal-form"
                    data-store_route="{{route('admin.students.fees.store')}}">
                    Add Fee
                </button>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="my-3 col-12" style="background-color: indigo;">
                        <div class="row justify-content-end">
                            <button class="btn btn-primary btn-success" data-target="#general-modal"
                                @click="modalEdit($event.target, true)" data-form="general-modal-form"
                                data-store_route="{{route('admin.students.fees.store')}}">
                                Add Fee
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
                                    <th>Session</th>
                                    <th>program</th>
                                    <th>Level</th>
                                    <th>Fee</th>
                                    <th>Currency</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @php
                                $action = [
                                'destroy'=> route('admin.students.fees.destroy'),
                                'form'=>'general-modal-form',
                                'modal'=>'general',
                                ];
                                @endphp
                                @foreach ($fees as $c)
                                <?php
                                $action['id'] = $c->id;
                                $action['rowid'] = "#tr-$c->id";
                                $action['update_route']= route("admin.students.fees.update", $c->id);
                                $action['item'] = $c;
                                ?>
                                <tr id="tr-{{$c->id}}">
                                    <td><input type="checkbox" value="{{$c->id}}" class="checking"></td>
                                    <td>{{$i++}}</td>
                                    <td>{{$c->session->name??'N/A'}}</td>
                                    <td>{{$c->program->abbr??'N/A'}}</td>
                                    <td>{{$c->level->name??'N/A'}}</td>
                                    <td>{{ucfirst($c->fee)}}</td>
                                    <td>{{$c->currency}}</td>
                                    <td>{{$c->amount}}</td>
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
<x-admin-modal title="Main Student Fees">
    <form action="{{route('admin.sessions.store')}}" autocomplete="off" @submit.prevent="submit($event)"
        id="general-modal-form">
        <p class="form-text text-muted">
            Leave any value empty to default to be a general setting
        </p>
        <div class="row">
            <div class="form-group col-sm-6">
                <label for="session">Session</label>
                <select id="editing-session" data-value="{{activeSession()->id??''}}" class="form-control select2" name="session" data-placeholder="Session">
                    <option value=" ">Select</option>
                    @foreach ($sessions as $s)
                    <option value="{{$s->id}}">{{$s->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-6">
                <label for="editing-level">Level</label>
                <select id="editing-level" class="form-control select2" name="level" data-placeholder="Level">
                    <option value=" ">Select</option>
                    @foreach ($levels as $s)
                    <option value="{{$s->id}}">{{$s->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-6">
                <label for="editing-program">Program</label>
                <select id="editing-program" class="form-control select2" name="program" data-placeholder="Program">
                    <option value=" ">Select</option>
                    @foreach ($programs as $s)
                    <option value="{{$s->id}}">{{$s->abbr}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-6">
                <label for="editing-fee">Type of Fee</label>
                <select id="editing-fee" class="form-control select2 required" name="fee" data-placeholder="Fee">
                    <option value=" ">Select</option>
                    <option value="exam">Exam</option>
                    <option value="tuition">Tuition</option>
                </select>
            </div>
            <div class="form-group col-sm-6">
                <label>Currency</label>
                <input class=" form-control required text-uppercase" data-value="{{$currency}}" minlength="3" maxlength="3" placeholder="Currency"
                type="text"  name="currency" id="editing-currency">
            </div>
            <div class="form-group col-sm-6">
                <label>Amount</label>
                <input class=" form-control required" placeholder="Amount" type="text"  name="amount" id="editing-amount">
            </div>

            <div class="form-group col-12">
                <label>Reason</label>
                <textarea class=" form-control required" placeholder="Payment Reason"  name="reason" id="editing-reason"></textarea>
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
</script>
@endsection
