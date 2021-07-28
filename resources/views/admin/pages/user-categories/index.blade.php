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
            <x-admin-card-tool title="User Categories" :links="$cardLinks">
                <button class="btn  btn-success btn-tool dropdown-toggle btn-sm text-white"
                     data-target="#general-modal" @click="modalEdit($event.target, true)"
                     data-form="general-modal-form"
                     data-store_route="{{route('admin.user-categories.store')}}">
                        new Category
                    </button>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="col-12 my-3" style="background-color: indigo;">
                    <div class="row justify-content-end">
                    <button class="btn  btn-success"
                     data-target="#general-modal" @click="modalEdit($event.target, true)"
                     data-form="general-modal-form"
                     data-store_route="{{route('admin.user-categories.store')}}">
                        new Category
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
                                    <th>parent</th>
                                    <th>Visibility</th>
                                    <th>Total Users</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @php
                                    $action = [
                                        'modal'=>'general',
                                        'destroy'=> route('admin.user-categories.destroy'),
                                        'form'=>'general-modal-form',

                                    ];
                                 @endphp
                                @foreach ($categories as $c)
                                <?php
                                $action['id'] = $c->id;
                                $action['update_route']= route("admin.user-categories.update", $c->id);
                                $action['rowid'] = ".tr-cats-$c->id";
                                $action['item']= json_encode([
                                    'name'=>$c->name,
                                    'parent_id'=>$c->parent_id,
                                    'visibility'=>$c->visibility
                                    ]);
                                ?>
                                <tr class="tr-cats-{{$c->id}}">
                                    <td><input type="checkbox" class="checking"></td>
                                    <td>{{$i++}}</td>
                                    <td>{{$c->name}}</td>
                                    <td>{{$c->parent_id}}</td>
                                    <td>{{$c->visible_to}}</td>
                                    <td>{{$c->users}}</td>
                                    <td>
                                        <x-data-table-action :action="$action"></x-data-table-action>
                                    </td>
                                </tr>
                                @if ($c->children)
                                    @foreach ($c->children as $d)
                                    @php
                                        $action['id'] = $d->id;
                                        $action['update_route']= route("admin.user-categories.update", $d->id);
                                         $action['rowid'] = "#tr-cats-$d->id";
                                        $action['item']=  json_encode([
                                            'name'=>$d->name,
                                            'parent_id'=>$d->parent_id,
                                            'visibility'=>$d->visibility
                                            ]);
                                    @endphp
                                <tr class="tr-cats-{{$c->id}}" id="tr-cats-{{$d->id}}">
                                    <td><input type="checkbox" class="checking"></td>
                                    <td>{{$i++}}</td>
                                    <td>{{$d->name}}</td>
                                    <td>{{$d->parent->name}}</td>
                                    <td>{{$d->visible_to}}</td>
                                    <td>{{$d->users}}</td>
                                    <td>
                                        <x-data-table-action :action="$action"></x-data-table-action>
                                    </td>
                                </tr>
                                    @endforeach
                                @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>
                                        <i class="fa fa-check-square" aria-hidden="true"></i>
                                    </th>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>parent</th>
                                    <th>Visibility</th>
                                    <th>Total Users</th>
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
        <form action="{{route('admin.user-categories.store')}}" autocomplete="off"
         @submit.prevent="submit($event)" id="general-modal-form">
        <div class="form-group">
            <label>Category Name</label>
            <input class="form-control required" type="text" name="name" id="editing-name">
        </div>
        <div class="form-group">
            <label for="editing-parent_id">Parent</label>
            <select id="editing-parent_id" class="form-control select2" name="parent_id">
            <option value="" selected>Parent Category</option>
                @foreach ($categories as $c)
                    <option value="{{$c->id}}" >{{$c->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="editing-visibility">Visibility</label>
            <select id="editing-visibility" class="form-control select2" name="visibility">
            <option value="1">All</option>
            <option value="2">Admin only</option>
            </select>
            <small class="form-text text-muted">
                If visibility is all,
                users can be able to see it
                and apply to the program
            </small>
        </div>
        <div class="form-group" >
            <label for="editing-children">Categories Under this</label>
            <select id="editing-children" class="form-control select2"
            name="children[]" multiple data-placeholder="Categories under this cat">
                <option value="" >Parent Category</option>
                <optgroup label="major Categories">
                    @foreach ($categories as $c)
                        <option value="{{$c->id}}" >{{$c->name}}</option>
                    @endforeach
                </optgroup>
                <optgroup label="Other Sub Categories ">
                    @foreach ($categories as $d)
                        @if ($d->children)
                        @foreach ($d->children as $c)
                    <option value="{{$c->id}}" >{{$c->name}}</option>
                        @endforeach
                        @endif
                    @endforeach
                </optgroup>
            </select>
            <small class="form-text text-muted">
                This is used to organize for subject sharing,
                Or anything that you want to pass to all users who registered for
                the children category
                </small>
        </div>
        <div class="form-group text-right my-2">
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
