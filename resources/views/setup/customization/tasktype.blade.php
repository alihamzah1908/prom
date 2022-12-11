@extends('setup.customization.customization')
@section('customization')

@if(Session::has('message'))
<div class="alert {{Session::get('alert-class')}} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{ Session::get('message') }}
</div>
@endif
<div id="menu6" class="content_header">
    <div class="content_menu">
        <h4 class="title_2">TaskType</h4>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal"
            data-target="#newTaskType">New Task Type
        </button>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 52px"></th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Color</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <a href="#" style="color: #828282"><i class="fas fa-cog"></i></a>
                            </td>
                            <td class="text_name">
                                Implementation
                            </td>
                            <td class="text_name">
                                Implementation of  the planned  work
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-md-1">
                                        <div style="background: #000; width: 10px; height: 10px; margin-top: 2px"></div>
                                    </div>
                                    <div class="col">
                                        <small class="text_name">#000</small>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="modal fade" id="newTaskType">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Priority</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="categoryName" class="text_name">Category Name</label>
                            <input name="categoryName" type="text" value=""
                                class="placeholder_color form-control @error('categoryName') is-invalid invalid @enderror"
                                id="categoryName" aria-describedby="namaHelp" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label for="categorydescription" class="text_name">Description</label>
                            <input name="categorydescription" type="text" value=""
                                class="placeholder_color form-control @error('categorydescription') is-invalid invalid @enderror"
                                id="categorydescription" aria-describedby="namaHelp" placeholder="Description">
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="button" class="btn btn-primary" style="width: 70px;">Save</button>
                            <button type="button" class="btn btn-default"
                                style="color: #fff; background: #CECECE">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $('.select2').select2()
</script>
@endpush

