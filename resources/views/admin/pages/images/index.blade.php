@extends('layouts.admin')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="/vendor/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/vendor/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="/vendor/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="/css/file.css">
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
                                <span class="badge bg-pink"><?=count($images)?></span>
                                Images
                            </h4>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-danger bulk-action" title="Delete all selected categories"
                                @click.prevent="destroy($event.target)" data-action="{{route('admin.images.destroy')}}"
                                data-id="">
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
            <x-admin-card-tool title="Post Categories">
                <button class="text-white btn btn-success btn-tool dropdown-toggle btn-sm" data-target="#general-modal"
                    @click="modalEdit($event.target, true)" data-form="general-modal-form"
                    data-store_route="{{route('admin.images.store')}}">
                    Upload Image
                </button>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="my-3 col-12" style="background-color: indigo;">
                        <div class="row justify-content-end">
                            <button class="btn btn-success" data-target="#img-parts" data-toggle="modal">
                                Tags
                            </button>

                            <button class="btn btn-success" data-target="#store-parts"
                                @click="modalEdit($event.target, true)" data-form="store-parts-form"
                                data-store_route="{{route('admin.images.store-parts')}}">
                                new Part
                            </button>

                            <button class="btn btn-success" data-target="#general-modal"
                                @click="modalEdit($event.target, true)" data-form="general-modal-form"
                                data-store_route="{{route('admin.images.store')}}">
                                Upload Image
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
                                    <th>Image</th>
                                    <th>Part Shown</th>
                                    <th>Active</th>
                                    {{-- <th>Order</th> --}}
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @php
                                $action = [
                                'modal'=>'general',
                                'destroy'=> route('admin.images.destroy'),
                                'form'=>'general-modal-form',
                                ];
                                @endphp
                                @foreach ($images as $img)
                                <?php
                                $action['id'] = $img->id;
                                $action['update_route']= route("admin.images.update", $img->id);
                                $action['rowid'] = "#tr-img-$img->id";

                                $action['item']= json_encode([
                                    'part_id'=>$img->part_id,
                                    'active'=>$img->active,
                                    'position'=>$img->position,
                                    ]);
                                ?>
                                <tr id="tr-img-{{$img->id}}">
                                    <td><input type="checkbox" value="{{$img->id}}" class="checking"></td>
                                    <td>{{$i++}}</td>
                                    <td>
                                        <img src="/storage/{{$img->src}}" alt="preview">
                                    </td>
                                    <td>{{$img->part->part}}</td>
                                    <td>{{json_encode(boolval($img->active))}}</td>
                                    <td>{{$img->created_at}}</td>
                                    <td>{{$img->updated_at}}</td>
                                    {{-- <td>{{ $img->position }}</td> --}}
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
                                    <th>Image</th>
                                    <th>Part Shown</th>
                                    <th>Active</th>
                                    {{-- <th>Order</th> --}}
                                    <th>Created</th>
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
    <x-admin-modal title="Managing Images">
        <form action="{{route('admin.images.store')}}" autocomplete="off" @submit.prevent="submit($event, ['images'])"
            id="general-modal-form">
            <div class="form-group">
                <h5 class="mb-3">Select Images</h5>
                <div class="form-group position-relative hide-on-edit" style="background-color:rgba(81, 32, 128, 0.787)">
                    <input @change.prevent="previewSelected($event, 'images', '{{route('admin.images.store')}}')"
                        id="images" class="form-control-file single-on-edit" type="file" name="image" accept="image/*" multiple>
                    <label for="images" class="text-center">
                        <i class="fas fa-plus deeppink"></i>
                    </label>
                </div>

                <div class="form-group position-relative show-on-edit" style="background-color:rgba(81, 32, 128, 0.787)">
                    <input @change.prevent="previewSelected($event, 'images', 0)"
                        id="image" class="form-control-file single-on-edit" type="file" name="image" accept="image/*" multiple>
                    <label for="image" class="text-center">
                        <i class="fas fa-plus deeppink"></i>
                    </label>
                </div>
                <div class="row selected-files" v-if="files.images && files.images.length">
                    <div class="px-3 col-6 select-cover-photo selected preview-file featured-photo"
                        v-for="(item, index) in files.images">
                        <img :src="fileSrc(item.file)" alt="preview" class="cursor-pointer preview-img">
                        <i class="remove-image" @click.prevent="removeFile('images', index)">×</i>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox checkbox-primary p-t-0">
                    <input id="editing-active" data-checked="true" type="checkbox" class="form-check-input"
                    name="active" value="1">
                    <label for="editing-active">
                        Active
                    </label>
                    <small class="form-text text-muted">
                        Toggle to determine the status of all that belongs to this tag
                    </small>
                </div>
            </div>
            <div class="form-group">
                <label for="part">Part To display</label>
                <select id="part" class="form-control select2" name="part">
                    <option value=" " disabled>-select-</option>
                    @foreach ($parts as $p)
                    <option value="{{$p->id}}">{{$p->part}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="editing-position">Order</label>
                <input id="editing-position" class="form-control" type="number" name="position">
                <small class="form-text text-muted">
                    Its order in Desc with one with position lowest order coming first
                </small>
            </div>
            <div class="my-2 text-right form-group">
                <button type="submit" class="btn btn-success">create</button>
            </div>
        </form>
    </x-admin-modal>

    <x-admin-modal title="Managing Images" id="store-parts">
        <form action="{{route('admin.images.store-parts')}}" autocomplete="off"
        @submit.prevent="submit($event)"
            id="store-parts-form">
            <div class="form-group">
                <input type="hidden" name="id" value="">
                <label>Part</label>
                <input  class="form-control" type="text" name="part">
            </div>
            <div class="my-2 text-right form-group">
                <button type="submit" class="btn btn-success">create</button>
            </div>
        </form>
    </x-admin-modal>
    <x-admin-modal id="img-parts">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Part</th>
                    <th>Total Images</th>
                    <th>Total Active</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; ?>
                <tr>
                    @foreach ($parts as $ps)
                        <td>{{$i}}</td>
                        <td>{{$ps->part}}</td>
                        <td>{{$ps->images->count()}}</td>
                        <td>{{$ps->active->count()}}</td>
                        <td>
                           <div class="btn-group" role="group" aria-label="Action buttons">
                               <button class=" btn btn-sm btn-primary">
                                   <i class="fas fa-pencil-alt"></i>
                                </button>
                           </div>
                        </td>
                    @endforeach
                </tr>
            </tbody>
            </thead>
        </table>
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
