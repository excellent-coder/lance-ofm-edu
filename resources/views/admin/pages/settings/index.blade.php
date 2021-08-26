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
            <x-admin-card-tool title="Settings">
                <button class="text-white btn btn-success btn-tool dropdown-toggle btn-sm"
                     data-target="#general-modal" @click="modalEdit($event.target, true)"
                     data-form="general-modal-form"
                     data-store_route="{{route('admin.settings.storetag')}}">
                        New Tag
                    </button>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="col-12">
                        <table id="dataTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Icon</th>
                                    <th>setting</th>
                                    <th>Key</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                 @php
                                $action = [
                                'modal'=>'general',
                                'destroy'=> route('admin.settings.destroytag'),
                                'form'=>'general-modal-form',
                                ];
                                @endphp
                                @foreach ($settings as $s)
                                @php
                                $action['id'] = $s->id;
                                $action['update_route']= route("admin.settings.updatetag", $s->id);
                                $action['rowid'] = "#tr-$s->id";
                                $action['item']= json_encode([
                                    'tag'=>$s->tag,
                                    'slug'=>$s->slug
                                ]);
                                @endphp
                                <tr id="tr-{{$s->id}}">
                                    <td>{{$i++}}</td>
                                    <td>
                                        @if ($s->icon)
                                        <img src="/storage/{{$s->icon}}" alt="{{$s->tag}} icon">
                                            @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{$s->tag}}</td>
                                    <td>{{$s->slug}}</td>
                                    <td>
                                        <a title="edit {{$s->tag}} settings" href="{{route('admin.settings.edit', $s->slug)}}">
                                            <i class="fas fa-edit "></i>
                                        </a>
                                        <x-data-table-action :action="$action"></x-data-table-action>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Icon</th>
                                    <th>Setting</th>
                                    <th>Key</th>
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
        <form action="{{route('admin.settings.storetag')}}" autocomplete="off" @submit.prevent="submit($event)"
            id="general-modal-form">
            <div class="form-group">
                <label>Setting Tag</label>
                <input class="form-control required"
                placeholder="tag" type="text" name="tag" id="editing-tag">
            </div>
            <div class="form-group">
                <label>Key</label>
                <input class="form-control required"
                placeholder="key" type="text" name="slug" id="editing-slug">
            </div>
            <div class="form-group">
                <label for="icon">Icon</label>
               <input class="form-control" accept="image/*" type="file" name="icon" id="icon">
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
<script src="/vendor/jszip/jszip.min.js"></script>
<script src="/vendor/pdfmake/pdfmake.min.js"></script>
<script src="/vendor/pdfmake/vfs_fonts.js"></script>
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
