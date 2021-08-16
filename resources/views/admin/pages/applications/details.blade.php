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
th{
    position: relative;
}
</style>

@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <x-admin-card-tool title="Applications">
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="my-3 col-12 " style="background-color: rgb(16, 17, 90);">
                        <div class="row justify-content-between">
                            <h4 class="mr-3 text-white ">{{$app->applying_for}} Request</h4>
                        </div>
                    </div>
                    <div class="col-12">
                      <form action="" method="post">
                          <div class="form-group">
                              <label>Applied For</label>
                              <input class="form-control" type="text" name="">
                          </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
    <x-admin-modal>
        <form action="{{route('admin.user-categories.store')}}" autocomplete="off" @submit.prevent="submit($event)"
            id="general-modal-form">
            <div class="form-group">
                <label>Category Name</label>
                <input class="form-control required" type="text" name="name" id="editing-name">
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
