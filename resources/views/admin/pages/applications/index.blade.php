@extends('layouts.admin')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="/vendor/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/vendor/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="/vendor/datatables-buttons/css/buttons.bootstrap4.min.css">
<style>
    span.slant {
        transform: rotate(337deg) !important;
        display: inline-block;
        width: auto;
        top: 0;
        position: absolute;
    }

    th {
        position: relative;
    }

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
                                <span class="badge bg-pink"><?= App\Models\Application::count() ?></span>
                                Applicants
                            </h4>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-danger bulk-action" title="Delete all selected events"
                                @click.prevent="destroy($event.target)" data-action="{{route('admin.applications.destroy')}}">
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
                                    <th>Paid</th>
                                    <th>Approved On</th>
                                    <th>Member ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Applied For</th>
                                    <th>Category</th>
                                    <th>
                                        <span class="slant">
                                            Reviewed
                                        </span>
                                    </th>
                                    <th>
                                        <span class="slant">
                                            Applicant
                                        </span>
                                    </th>
                                    <th>Passport</th>
                                    <th>Applied On</th>

                                    <th>Rejected On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i=1;
                                $action = [
                                'destroy'=> route('admin.applications.destroy'),
                                'form' => "general-modal-form",
                                'modal' => "general",
                                'icon'=>'eye'
                                ];
                                @endphp
                                @foreach ($apps as $a)
                                <?php
                                     $x = $a->user($a->applying_for)->first();
                                    if($x){
                                        switch($a->applying_for){
                                                case 'member':
                                                default:
                                                $a->member_id = $x->member_id;
                                                break;
                                                case 'student':
                                                $a->member_id = $x->matric_no;
                                                break;
                                            }
                                    }
                                    $approve = $a->approved_at?'check':'times';
                                    $approve_title =$a->apprved_at?'un-approve':'Approve';
                                    $action['rowid'] = "#tr-app-$a->id";
                                    $action['id'] = $a->id;
                                    $a->password = Str::random(8);
                                    $b = $a;
                                    $b->reviewed =1;
                                    $action['item'] = json_encode($b);
                                    $action['update_route'] = route("admin.applications.update", $a->id);
                                ?>
                                <tr id="tr-app-{{$a->id}}">
                                    <td><input type="checkbox" class="checking" value="{{$a->id}}"></td>
                                    <td>{{$i++}}</td>
                                    <td>
                                        <button class="btn modal-edit-btn text-success" data-form="general-modal-form"
                                            data-item="{{$b}}" data-target="#general-modal"
                                            data-update_route="{{route("admin.applications.update", $a->id)}}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                    <td>
                                        @if ($a->payment)
                                            <a href="{{route('app.payments.show', $a->payment->id)}}"
                                            target="_blank" rel="noopener noreferrer">
                                            <i class="fa fa-eye text-{{$a->paid?'success':'danger'}}" aria-hidden="true"></i>
                                            </a>
                                        @endif
                                        {{Str::upper(bv($a->paid)) }}
                                        </td>
                                    <td>{{$a->approved_at}}</td>
                                    <td>{{$a->member_id }}</td>
                                    <td>{{$a->first_name }}</td>
                                    <td>{{$a->last_name }}</td>
                                    <td>{{ $a->applying_for }}</td>
                                    <td>{{ $a->item }}</td>
                                    <td>{{Str::upper(bv($a->reviewed)) }}</td>
                                    <td>{{ $a->applicant }}</td>
                                    <td>
                                        <img src="/storage/{{$a->passport}}" alt="{{$a->first_name}}">
                                    </td>
                                    <td>{{$a->created_at}}</td>

                                    <td>{{$a->rejected_at}}</td>
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
                                    <th>Paid</th>
                                    <th>Approved On</th>
                                    <th>Member ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Applied For</th>
                                    <th>Category</th>
                                    <th>
                                        <span class="slant">
                                            Reviewed
                                        </span>
                                    </th>
                                    <th>
                                        <span class="slant">
                                            Applicant
                                        </span>
                                    </th>
                                    <th>Passport</th>
                                    <th>Applied On</th>

                                    <th>Rejected On</th>
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
                        <div class="form-group col-12 col-md-6 col-lg-4">
                            <label>Date Of Birth</label>
                            <input class="form-control required wtk" type="date" name="dob" id="editing-dob">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-4">
                            <label> Applied For</label>
                            <input readonly class="form-control required" type="text" name="applying_for"
                                id="editing-applying_for" autocomplete="off">
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-4">
                            <label> Applied For Position</label>
                            <input class="form-control required" type="text" name="item" id="editing-item"
                                autocomplete="off">
                        </div>

                        <div class="form-group col-12 col-md-6 col-lg-4">
                            <label> Applied ON</label>
                            <input class="form-control" readonly type="text" id="editing-created_at" autocomplete="off">
                        </div>
                        <div class="checkbox checkbox-primary p-t-0 col-12 col-md-6 col-lg-4">
                            <input v-model="form.approved" :disabled="form.rejected" id="editing-approved_at"
                                type="checkbox" class="form-check-input form-control" name="approved" value="1">
                            <label for="editing-approved_at">
                                Approved
                            </label>
                        </div>
                        <div class="checkbox checkbox-primary p-t-0 col-12 col-md-6 col-lg-4">
                            <input id="editing-rejected_at" v-model="form.rejected" :disabled="form.approved"
                                type="checkbox" class="form-check-input form-control" name="rejected" value="1">
                            <label for="editing-rejected_at">
                                Reject
                            </label>
                            <small class="form-text text-muted">
                                Rejected request are not deleted, but user can be
                                notified while it is rejected
                            </small>
                        </div>
                        <div class="checkbox checkbox-primary p-t-0 col-12 col-md-6 col-lg-4">
                            <input id="editing-reviewed" type="checkbox" class="form-check-input form-control"
                                name="reviewed" value="1">
                            <label for="editing-reviewed">
                                Reviewed
                            </label>
                        </div>
                        <div class="my-4 col-12">
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label>MEMBER ID/ MATRIC NUMBER</label>
                                    <input name="member_id" v-if="form.member_id" v-model="form.member_id" type="text"
                                        class="form-control">
                                    <input v-else type="text" class="form-control" name="member_id"
                                        id="editing-member_id">
                                    <label class="mt-2 " v-if="form.applying_for">
                                        LAST MEMBER ID FOR @{{form.applying_for}} is @{{form.last_id}}
                                    </label>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label>Password </label>
                                    <input type="text" class="form-control" id="editing-password" name="password">
                                    <small class="form-text text-muted">
                                        This password will be emailed to them to use it and login
                                        <br>
                                        They will be promted to change it once they login
                                    </small>
                                </div>
                                <button id="modal-action" class="d-none btn btn-primary btn-lg"
                                    @click.prevent="generateMemberID()">
                                </button>
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Reason For Rejection</label>
                            <textarea id="editing-reject_reason" class=" form-control" rows="4"></textarea>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label> User Device</label>
                            <textarea readonly id="editing-device" class=" form-control" rows="4"></textarea>
                        </div>
                        <input type="hidden" id="editing-paid">

                        <div class="my-3 col-12" v-if="form.paid">
                            <h3 class="text-center d-block text-success fa-3x">
                                Payment Confirmed <i class="fas fa-check-square "></i>
                            </h3>
                        </div>
                        <div class="my-3 col-12" v-else>
                            <h3 class="text-center d-block text-danger fa-3x">
                                NO Payment has been Confirmed <i class="fas fa-times "></i>
                            </h3>
                        </div>
                    </div>

                    <div class="my-2 text-right form-group">
                        <button type="submit" class="btn btn-success dont-change btn-block"
                            data-update="APPROVE"></button>
                        <small class="form-text text-muted">
                            Clicking approve, The applicant can now login with member Id
                        </small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                Footer
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

</script>
@endsection
