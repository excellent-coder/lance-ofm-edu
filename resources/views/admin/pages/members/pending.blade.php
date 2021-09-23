@extends('layouts.admin')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="/vendor/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/vendor/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="/vendor/datatables-buttons/css/buttons.bootstrap4.min.css">
<style>

    @media (min-width: 760px) {
        .modal-dialog {
            max-width: 700px;
            margin: 1.75rem auto;
        }
    }

    @media (min-width: 992px) {
        .modal-dialog {
            max-width: 900px;
            margin: 1.75rem auto;
        }
    }

</style>

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
                                <span class="badge bg-pink"><?= $members->count() ?></span>
                                Applicants
                            </h4>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-danger bulk-action" title="Delete all selected events"
                                @click.prevent="destroy($event.target)" data-action="{{route('admin.member-r.destroy')}}">
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
            <x-admin-card-tool title="Applications">
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="my-3 col-12 " style="background-color: rgb(16, 17, 90);">
                        <div class="row justify-content-between">
                            <h4 class="px-3 text-white ">{{$title}}</h4>
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
                                    <th>View</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Email Verified</th>
                                    <th>Program</th>
                                    <th>Applied On</th>
                                    <th>Passport</th>
                                    <th>Certificates</th>
                                    <th>Documents</i> </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i=1;
                                $action = [
                                'destroy'=> route('admin.member-r.destroy'),
                                'form' => "general-modal-form",
                                'modal' => "general",
                                'icon'=>'eye'
                                ];
                                @endphp
                                @foreach ($members as $a)
                                <?php
                                    $approve = $a->approved_at?'check':'times';
                                    $approve_title =$a->apprved_at?'un-approve':'Approve';
                                    $action['rowid'] = "#tr-app-$a->id";
                                    $action['id'] = $a->id;
                                    $a->reviewed =1;
                                    $a->membership_name = $a->membership->name??'N/A';
                                    $action['item'] = json_encode($a);
                                    $action['update_route'] = route("admin.member-r.approve", $a->id);
                                ?>
                                <tr id="tr-app-{{$a->id}}">
                                    <td><input type="checkbox" class="checking" value="{{$a->id}}"></td>
                                    <td>{{$i++}}</td>
                                    <td>
                                        <button class="btn modal-edit-btn text-success" data-form="general-modal-form"
                                            data-item="{{$a}}" data-target="#general-modal"
                                            data-update_route="{{route("admin.member-r.approve", $a->id)}}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                    <td>{{$a->first_name }}</td>
                                    <td>{{$a->last_name }}</td>
                                    <td>{{$a->email }}</td>
                                    <td>{{$a->email_verified_at }}</td>
                                    <td>{{ $a->membership->name??'N/A' }}</td>
                                    <td>{{$a->created_at}}</td>
                                    <td>
                                        <img src="/storage/{{$a->passport}}" alt="{{$a->first_name}}">
                                    </td>
                                    <td>
                                        @if ($a->certificates)
                                            @php
                                                $certs = explode(',', $a->certificates);
                                            @endphp
                                            @foreach ($certs as $k=>$c)
                                                <a class="mr-2 badge badge-btn badge-info" href="/storage/{{$c}}" target="_blank" rel="noopener noreferrer">
                                                    {{$k+1}}
                                                </a>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @if ($a->documents)
                                            @php
                                                $certs = explode(',', $a->documents);
                                            @endphp
                                            @foreach ($certs as $k=>$c)
                                                <a  class="mr-2 badge badge-btn badge-info" href="/storage/{{$c}}" target="_blank" rel="noopener noreferrer">
                                                    {{$k+1}}
                                                </a>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        <x-data-table-action :action="$action">
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
                                     <th>View</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Email Verified</th>
                                    <th>Program</th>
                                    <th>Applied On</th>
                                    <th>Passport</th>
                                    <th>Certificates</th>
                                    <th>Documents</i> </th>
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
<div id="general-modal" class="modal fade w-100" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Manage - Applicant</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="admin-modal-content">
                <form spellcheck="off" action="" autocomplete="off" @submit.prevent="submit($event)"
                    id="general-modal-form">
                    <input type="text" id="editing-item_id" name="item_id" class="d-none">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label> First Name</label>
                                <input class="form-control required" type="text" name="first_name"
                                    id="editing-first_name" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-4">
                            <label> Last Name</label>
                            <input class="form-control required" type="text" name="last_name" id="editing-last_name"
                                autocomplete="off">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-4">
                            <label> Middle Name</label>
                            <input class="form-control" type="text" name="middle_name" id="editing-middle_name"
                                autocomplete="off">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-4">
                            <label> Phone</label>
                            <input class="form-control required" type="tel" name="phone" id="editing-phone"
                                autocomplete="off">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-4">
                            <label> Email</label>
                            <input class="form-control required" type="email" name="email" id="editing-email"
                                autocomplete="off">
                        </div>
                        <div class="checkbox checkbox-primary p-t-0 col-12 col-md-6 col-lg-4">
                            <br>
                            <input id="editing-email_verified_at" readonly type="checkbox" class="form-check-input form-control">
                            <label for="editing-email_verified_at">
                                Email Verified
                            </label>
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-4">
                            <label>Date Of Birth</label>
                            <input class="form-control required wtk" type="date" name="dob" id="editing-dob">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-4">
                            <label>Membership</label>
                            <input readonly class="form-control" type="text"
                                id="editing-membership_name" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="checkbox checkbox-primary p-t-0 col-12 col-md-6 col-lg-4">
                            <input v-model="form.approved" :disabled="form.rejected" id="editing-approved_at"
                                type="checkbox" class="form-check-input form-control" name="approve" value="1">
                            <label for="editing-approved_at">
                                Approve
                            </label>
                        </div>
                        <div class="checkbox checkbox-primary p-t-0 col-12 col-md-6 col-lg-4">
                            <input id="editing-rejected_at" v-model="form.rejected" :disabled="form.approved"
                                type="checkbox" class="form-check-input form-control" name="reject" value="1">
                            <label for="editing-rejected_at">
                                Reject
                            </label>
                        </div>
                        <div class="checkbox checkbox-primary p-t-0 col-12 col-md-6 col-lg-4">
                            <input id="editing-reviewed" type="checkbox" class="form-check-input form-control"
                                name="reviewed" value="1">
                            <label for="editing-reviewed">
                                Reviewed
                            </label>
                        </div>
                        <div class="form-group col-12 col-md-6" v-if="form.rejected">
                            <label>Reason For Rejection</label>
                            <textarea id="editing-reject_reason" class="form-control required" rows="4"></textarea>
                        </div>
                    </div>

                    <div class="my-2 text-right form-group">
                        <button type="submit" class="btn btn-success btn-block"></button>
                    </div>
                </form>
            </div>
            <div class="modal-footer"></div>
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
