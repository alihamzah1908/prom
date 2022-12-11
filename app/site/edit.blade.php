@extends('setup.template.default')
@section('title', 'Sites ')
@section('header-title', 'Sites')
@section('title_menu', 'Servicedesk Configurations')
@section('navbar')
    <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="padding: 0px !important">
    <ul class="navbar-nav menu_servicedesk">
        <li class="nav-item">
            <a href="{{ route('servicedesk') }}"
                class="{{  request()->is('setup/servicedesk') ? 'active' : '' }} nav-link text-header">Instance Setting</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('asset') }}"
                class="{{  request()->is('setup/servicedesk/asset') ? 'active' : '' }} nav-link text-header1">asset</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('sites') }}"
                class="{{  request()->is('setup//servicedesk/site') ? 'active' : '' }} nav-link text-header1">Sites</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('approver') }}"
                class="{{  request()->is('setup/servicedesk/approver') ? 'active' : '' }} nav-link text-header1">Approver</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('taskType') }}"
                class="{{  request()->is('setup/servicedesk/task_type') ? 'active' : '' }} nav-link text-header1">Task Type</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('segment') }}"
                class="{{  request()->is('setup/servicedesk/segment') ? 'active' : '' }} nav-link text-header1">Segment</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('asset') }}"
                class="{{  request()->is('setup/servicedesk/asset') ? 'active' : '' }} nav-link text-header1">Asset</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('rootcaused') }}"
                class="{{  request()->is('setup/servicedesk/rootcaused') ? 'active' : '' }} nav-link text-header1">rootcaused</a>
        </li>

    </ul>
</nav>
@endsection
@include('sweetalert::alert')
@section('content')
    <div class="content_header">
        <div class="content_menu">
            <h4 class="title_2">Site Edit</h4>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Site Form</h3>
                </div>
                <form action="{{ route('sites.update', $sites->site_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name_site" class="text_name">Site Nama</label>
                            <input name="name_site" type="text" value="{{ $sites->name_site }}"
                                class="placeholder_color form-control @error('name_site') is-invalid invalid @enderror"
                                id="name_site" aria-describedby="namaHelp" placeholder="Name">
                            @error('name_site')
                            <span class="invalid" style="color: red"><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="region_name" class="text_name form-control-label">Region Name</label>
                            <select class="form-control select2" id="region_name"  name="region_name">
                                @foreach ($regions as $reg)
                                    <option value="{{$reg->region_id}}"
                                        @if( $reg->id ==old('region_id',$sites->region_id )) selected @endif>
                                        {{$reg->region_name}}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-danger">{{ $errors->first('participant_id') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="site_cat_name" class="text_name form-control-label">Site Category Name</label>
                            <select class="form-control select2" id="site_cat_name" name="site_cat_name">
                                @foreach ($site_cats as $site_cat)
                                    <option value="{{$site_cat->site_cat_id}}"
                                        @if( $site_cat->id ==old('site_cat_id',$sites->site_cat_id )) selected @endif>
                                        {{$site_cat->site_cat_name}}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-danger">{{ $errors->first('site_cat_name') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="head_manager" class="text_name">Head Manager</label>
                            <input name="head_manager" type="number" value="{{ $sites->head_manager }}"
                                class="placeholder_color form-control @error('head_manager') is-invalid invalid @enderror" id="head_manager"
                                aria-describedby="namaHelp" placeholder="Head Manager">
                            @error('head_manager')
                            <span class="invalid"><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" class="form-control @error('address') is-invalid invalid @enderror" id="address" rows="3" placeholder="Place your Addres">{{ $sites->address }}</textarea>
                            @error('address')
                            <span class="invalid">{{ $errors->first('address') }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description" class="text_name">Description</label>
                            <input name="description" type="text" value="{{ $sites->site_desc }}"
                                class="placeholder_color form-control @error('description') is-invalid invalid @enderror" id="description"
                                aria-describedby="namaHelp" placeholder="Description">
                            @error('description')
                            <span class="invalid"><i>{{$message}}</i></span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer" style="margin-bottom: -15px;">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    $('.select2').select2()
</script>
@endpush
