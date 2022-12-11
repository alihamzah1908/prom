@extends('setup.template.default')
@section('title_menu', 'Customization')
@section('navbar')
<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="padding: 0px !important">
    <ul class="navbar-nav menu_servicedesk">
        {{-- <li class="nav-item">
            <a href="#" class="nav-link">PALAPA RING OPERATION & MAINTENEANCE</a>
        </li> --}}
        <li class="nav-item">
            <a href="#menu1" class="nav-link text-header active">Category</a>
        </li>
        <li class="nav-item">
            <a href="#menu2" class="nav-link text-header1">Status</a>
        </li>
        <li class="nav-item">
            <a href="#menu3" class="nav-link text-header1">Mode</a>
        </li>
        <li class="nav-item">
            <a href="#menu4" class="nav-link text-header1">Impact</a>
        </li>
        <li class="nav-item">
            <a href="#menu5" class="nav-link text-header1">Priority</a>
        </li>
        <li class="nav-item">
            <a href="#menu6 " class="nav-link text-header1">Task Type</a>
        </li>

    </ul>
</nav>
@endsection
@section('content')
<div id="menu1"  class="content_header">
    <div class="content_menu">
        <h4 class="title_2">Category</h4>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal"
            data-target="#newCategory">New Category
        </button>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal"
            data-target="#subCategory">New Sub Category
        </button>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal"
            data-target="#newItem">New Item
        </button>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 42px"></th>
                            <th>Category Name</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <a href="#" style="color: #828282"><i class="fas fa-caret-right"></i></a>
                            </td>
                            <td class="text_name">
                                Complaint
                            </td>
                            <td class="text_name">
                                Description
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="modal fade" id="newCategory">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="categoryname" class="text_name">Category Nama</label>
                            <input name="categoryname" type="text" value=""
                                class="placeholder_color form-control @error('categoryname') is-invalid invalid @enderror"
                                id="categoryname" aria-describedby="namaHelp" placeholder="Name">
                            @error('categoryname')
                            <span class="invalid"><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description" class="text_name">Description</label>
                            <input name="description" type="text" value=""
                                class="placeholder_color form-control @error('description') is-invalid invalid @enderror"
                                id="description" aria-describedby="namaHelp" placeholder="Description">
                            @error('description')
                            <span class="invalid"><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="segment" class="text_name form-control-label">Assign to Technician</label>
                            <select class="form-control select2">
                                <option selected="selected">--Select--</option>
                                <option>Alaska</option>
                                <option>California</option>
                                <option>Delaware</option>
                                <option>Tennessee</option>
                                <option>Texas</option>
                                <option>Washington</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary">Save and Add Sub Category</button>
                            <button type="button" class="btn btn-primary" style="width: 70px;">Save</button>
                            <button type="button" class="btn btn-default"
                                style="color: #fff; background: #CECECE">Cancle</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="subCategory">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Sub Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="segment" class="text_name form-control-label">Sub Category</label>
                            <select class="form-control select2">
                                <option selected="selected">--Select--</option>
                                <option>Alaska</option>
                                <option>California</option>
                                <option>Delaware</option>
                                <option>Tennessee</option>
                                <option>Texas</option>
                                <option>Washington</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="segment" class="text_name form-control-label">Assign to Technician</label>
                            <select class="form-control select2">
                                <option selected="selected">Description</option>
                                <option>Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore dolores autem at id, aspernatur, eum laboriosam, fugiat voluptate voluptatem quidem voluptas aliquam sed sapiente soluta optio doloribus obcaecati repellat ducimus.</option>
                                <option>California</option>
                                <option>Delaware</option>
                                <option>Tennessee</option>
                                <option>Texas</option>
                                <option>Washington</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="segment" class="text_name form-control-label">Category</label>
                            <select class="form-control select2">
                                <option selected="selected">--Select--</option>
                                <option>Alaska</option>
                                <option>California</option>
                                <option>Delaware</option>
                                <option>Tennessee</option>
                                <option>Texas</option>
                                <option>Washington</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" style="width: 70px; margin-right: 35px;">Save</button>
                            <button type="button" class="btn btn-primary">Save and Add Item</button>
                            <button type="button" class="btn btn-default"
                                style="color: #fff; background: #CECECE; margin-left: 35px">Cancle</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="newItem">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="segment" class="text_name form-control-label">Item</label>
                            <select class="form-control select2">
                                <option selected="selected">Item</option>
                                <option>Alaska</option>
                                <option>California</option>
                                <option>Delaware</option>
                                <option>Tennessee</option>
                                <option>Texas</option>
                                <option>Washington</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="segment" class="text_name form-control-label">Description</label>
                            <select class="form-control select2">
                                <option selected="selected">Description</option>
                                <option>Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore dolores autem at id, aspernatur, eum laboriosam, fugiat voluptate voluptatem quidem voluptas aliquam sed sapiente soluta optio doloribus obcaecati repellat ducimus.</option>
                                <option>California</option>
                                <option>Delaware</option>
                                <option>Tennessee</option>
                                <option>Texas</option>
                                <option>Washington</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="segment" class="text_name form-control-label">Category</label>
                            <select class="form-control select2">
                                <option selected="selected">--Select--</option>
                                <option>Alaska</option>
                                <option>California</option>
                                <option>Delaware</option>
                                <option>Tennessee</option>
                                <option>Texas</option>
                                <option>Washington</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="segment" class="text_name form-control-label">SUb Category</label>
                            <select class="form-control select2">
                                <option selected="selected">--Select--</option>
                                <option>Alaska</option>
                                <option>California</option>
                                <option>Delaware</option>
                                <option>Tennessee</option>
                                <option>Texas</option>
                                <option>Washington</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" style="width: 70px; margin-right: 35px;">Save</button>
                            <button type="button" class="btn btn-primary">Save and Add Item</button>
                            <button type="button" class="btn btn-default"
                                style="color: #fff; background: #CECECE; margin-left: 35px">Cancle</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<div id="menu2" class="content_header">
    <div class="content_menu">
        <h4 class="title_2">Status</h4>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal"
            data-target="#newStatus">New Status
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
                            <th>Stop</th>
                            <th>Color</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <a href="#" style="color: #828282"><i class="fas fa-cog"></i></a>
                            </td>
                            <td class="text_name">
                                Complaint
                            </td>
                            <td class="text_name">
                                Description
                            </td>
                            <td class="text_name">
                                Running
                            </td>
                            <td>
                                <div class="bg-warning" style="width: 100px; height: 10px; border-radius: 10px;"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="modal fade" id="newStatus">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Status</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="name_status" class="text_name">Name</label>
                            <input name="name_status" type="text" value=""
                                class="placeholder_color form-control @error('name_status') is-invalid invalid @enderror"
                                id="name_status" aria-describedby="namaHelp" placeholder="Name">
                            @error('name_status')
                            <span class="invalid"><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description" class="text_name">Description</label>
                            <input name="description" type="text" value=""
                                class="placeholder_color form-control @error('description') is-invalid invalid @enderror"
                                id="description" aria-describedby="namaHelp" placeholder="Description">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="customRadio1" name="customRadio">
                                        <label for="customRadio1" class="custom-control-label">In Progress</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="customRadio2" name="customRadio" checked>
                                        <label for="customRadio2" class="custom-control-label">Completed</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="text_name">Stop Timer</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                <label class="custom-control-label" for="customSwitch1"></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="color" class="text_name">Color</label>
                            <input name="color" type="text" value=""
                                class="placeholder_color form-control @error('color') is-invalid invalid @enderror"
                                id="color" aria-describedby="namaHelp" placeholder="Color">
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="button" class="btn btn-primary" style="width: 70px;">Save</button>
                            <button type="button" class="btn btn-default"
                                style="color: #fff; background: #CECECE">Cancle</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<div id="menu3" class="content_header">
    <div class="content_menu">
        <h4 class="title_2">Mode</h4>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal"
            data-target="#newMode">New Mode
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
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <a href="#" style="color: #828282"><i class="fas fa-cog"></i></a>
                            </td>
                            <td class="text_name">
                                Dashboard
                            </td>
                            <td class="text_name">
                                Technician is accept the ticket..
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="modal fade" id="newMode">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Mode</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="modeName" class="text_name">Name</label>
                            <input name="modeName" type="text" value=""
                                class="placeholder_color form-control @error('modeName') is-invalid invalid @enderror"
                                id="modeName" aria-describedby="namaHelp" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label for="Modedescription" class="text_name">Description</label>
                            <input name="Modedescription" type="text" value=""
                                class="placeholder_color form-control @error('Modedescription') is-invalid invalid @enderror"
                                id="Modedescription" aria-describedby="namaHelp" placeholder="Description">
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="button" class="btn btn-primary" style="width: 70px;">Save</button>
                            <button type="button" class="btn btn-default"
                                style="color: #fff; background: #CECECE">Cancle</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<div id="menu4" class="content_header">
    <div class="content_menu">
        <h4 class="title_2">Impact</h4>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal"
            data-target="#newImpact">New Impact
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
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <a href="#" style="color: #828282"><i class="fas fa-cog"></i></a>
                            </td>
                            <td class="text_name">
                                Critical
                            </td>
                            <td class="text_name">
                                If Customer Service Down
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="modal fade" id="newImpact">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Impact</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="impactName" class="text_name">Name</label>
                            <input name="impactName" type="text" value=""
                                class="placeholder_color form-control @error('impactName') is-invalid invalid @enderror"
                                id="impactName" aria-describedby="namaHelp" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label for="Impactdescription" class="text_name">Description</label>
                            <input name="Impactdescription" type="text" value=""
                                class="placeholder_color form-control @error('Impactdescription') is-invalid invalid @enderror"
                                id="Impactdescription" aria-describedby="namaHelp" placeholder="Description">
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="button" class="btn btn-primary" style="width: 70px;">Save</button>
                            <button type="button" class="btn btn-default"
                                style="color: #fff; background: #CECECE">Cancle</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<div id="menu5" class="content_header">
    <div class="content_menu">
        <h4 class="title_2">Priority</h4>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal"
            data-target="#newPriority">New Priority
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
                                Critical
                            </td>
                            <td class="text_name">
                                If Customer Service Down
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
    <div class="modal fade" id="newPriority">
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
                            <label for="PriorityName" class="text_name">Name</label>
                            <input name="PriorityName" type="text" value=""
                                class="placeholder_color form-control @error('PriorityName') is-invalid invalid @enderror"
                                id="PriorityName" aria-describedby="namaHelp" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label for="Prioritydescription" class="text_name">Description</label>
                            <input name="Prioritydescription" type="text" value=""
                                class="placeholder_color form-control @error('Prioritydescription') is-invalid invalid @enderror"
                                id="Prioritydescription" aria-describedby="namaHelp" placeholder="Description">
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="button" class="btn btn-primary" style="width: 70px;">Save</button>
                            <button type="button" class="btn btn-default"
                                style="color: #fff; background: #CECECE">Cancle</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
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
                                style="color: #fff; background: #CECECE">Cancle</button>
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
        $('.menu_servicedesk li a').click(function (e) {
        e.preventDefault();

        $('.menu_servicedesk li a').removeClass('active');

        let parent = $(".content-wrapper");
        let target = $(this).attr('href');

        parent.find('.content_header').removeClass('active');
        parent.find(target).addClass('active');
    });
    $('.select2').select2()
</script>
@endpush
