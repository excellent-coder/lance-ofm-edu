@extends('layouts.admin')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="/vendor/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/vendor/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="/vendor/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection

@section('content')
@php
    $auth = auth()->user();
@endphp
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="/storage/{{web_setting('general', 'logo')}}"
                       alt="website Logo">
                </div>

                <h3 class="text-center profile-username">
                    {{auth()->user()->name}}
                </h3>

                <p class="text-center text-muted">
                    Admin
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-9">
            <div class="card">
              <div class="p-2 card-header">
                <ul class="nav nav-pills">
                  <li class="nav-item">
                      <a class="nav-link active" href="#details" data-toggle="tab">details</a></li>
                  <li class="nav-item">
                      <a class="nav-link" href="#update" data-toggle="tab">
                          update
                        </a>
                    </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#password" data-toggle="tab">
                          password
                        </a>
                    </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="details">
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                         {{auth()->user()->name}}
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                         {{auth()->user()->email}}
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                         {{auth()->user()->username}}
                        </div>
                      </div>
                  </div>
                  <div class="tab-pane" id="update">
                    <form class="form-horizontal" @submit.prevent="submit($event)"
                    action="{{route('admin.profile.update')}}">
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" value="{{$auth->name}}" name="name" class="form-control required" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" value="{{$auth->email}}" name="email" class="form-control required" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                          <input type="text" value="{{$auth->username}}" name="username" class="form-control required" placeholder="Username">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Confirm Password</label>
                        <div class="col-sm-10">
                          <input type="password" name="password" class="form-control required"
                          placeholder="Confirm password">
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-success">Update</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="tab-pane" id="password">
                    <form class="form-horizontal" @submit.prevent>

                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Old Password</label>
                        <div class="col-sm-10">
                          <input type="password" name="old_password" class="form-control" placeholder="Email">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">New Password</label>
                        <div class="col-sm-10">
                          <input type="password" name="password" class="form-control"  placeholder="New Password">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Confirm Password</label>
                        <div class="col-sm-10">
                          <input type="password" name="confirm_password" class="form-control"  placeholder="Confirm New Password">
                        </div>
                      </div>


                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Change Password</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
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
