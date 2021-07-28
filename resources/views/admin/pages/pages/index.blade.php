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
            <x-admin-card-tool title="All Pages" :links="$cardLinks">
            </x-admin-card-tool>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                <table id="dataTable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th>
                      <input type="checkbox" name="" id="checkbox">
                      </th>
                      @foreach ($thead as $th)
                        <th>{{$th}}</th>
                      @endforeach
                  </tr>
                  </thead>
                  <tbody>
                      @php
                          $i=1;
                      @endphp
                      @foreach ($pages as $page)
                        <tr>
                          <td><input type="checkbox" class="checking"></td>
                          <td>{{$i}}</td>
                          <td>
                              <a href="{{route('page.show', $page->slug)}}" target="_blank">
                              {{$page->title}}
                              </a>
                              </td>
                          <td>{{$page->slug}}</td>
                          <td>
                              <img src="/storage/{{$page->image}}" alt="">
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{route('admin.pages.edit', $page->id)}}">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <button class="btn">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                      @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>
                        <i class="fa fa-check-square" aria-hidden="true"></i>
                    </th>
                      @foreach ($thead as $th)
                    <th>{{$th}}</th>
                      @endforeach
                  </tr>
                  </tfoot>
                </table>
              </div>
                </div>
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
<script src="/vendor/jszip/jszip.min.js"></script>
<script src="/vendor/pdfmake/pdfmake.min.js"></script>
<script src="/vendor/pdfmake/vfs_fonts.js"></script>
<script src="/vendor/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/vendor/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/vendor/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
    $("#dataTable").DataTable({
          "responsive": true,
          "lengthChange": false,
           "autoWidth": false,
          "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');
</script>
@endsection
