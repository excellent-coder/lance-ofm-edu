@extends('layouts.admin')

@section('css')
{{-- DataTables --}}
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
                                <span class="badge bg-pink"><?=$events->count()?></span>
                               Events
                            </h4>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-danger bulk-action"
                                title="Delete all selected events"
                                @click.prevent="destroy($event.target)"
                                data-action="{{route('admin.events.destroy')}}"
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
            <x-admin-card-tool title="Events">
                <a href="{{route('admin.events.create')}}" class="text-white btn btn-success btn-sm">
                    New Event
                </a>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="my-3 col-12" style="background-color: indigo;">
                        <div class="row justify-content-end">
                            <a href="{{route('admin.events.create')}}" class="btn btn-success">
                                New Event
                            </a>
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
                                    <th>Title</th>
                                    <th>image</th>
                                    <th>category</th>
                                    <th>views</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @php
                                $action = [
                                    'destroy'=> route('admin.events.destroy'),
                                ];
                                @endphp
                                @foreach ($events as $p)
                                <?php
                                $action['id'] = $p->id;
                                $action['route'] = route('admin.events.edit', $p->id);
                                $action['rowid'] = "#tr-post-$p->id";
                                ?>
                                <tr id="tr-post-{{$p->id}}">
                                    <td><input type="checkbox" value="{{$p->id}}" class="checking"></td>
                                    <td>{{$i++}}</td>
                                    <td>
                                        <a href="{{route('events.show', $p->slug)}}" target="_blank" rel="noopener noreferrer">
                                            {{ Str::limit($p->title, 100, '...')}}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($p->image)
                                         <img src="/storage/{{$p->image}}" alt="">
                                         @else
                                         N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if ($p->category)
                                        <a href="{{route('event-cats.show', $p->category->slug)}}" target="_blank" rel="noopener noreferrer">
                                            {{ $p->category->name }}
                                        </a>
                                        @else
                                          N/A
                                        @endif
                                    </td>
                                    <td>{{'views'}}</td>
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
                                    <th>Title</th>
                                    <th>image</th>
                                    <th>category</th>
                                    <th>views</th>
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
