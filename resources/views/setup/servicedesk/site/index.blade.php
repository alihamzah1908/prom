@extends('setup.servicedesk.service_desk')
@section('title', 'Site')
@section('title_menu', 'Servicedesk Configurations')

@section('service_desk_content')
@include('sweetalert::alert')
<div id="menu3" class="content_header"> 
    <div class="content_menu">
        <h4 class="title_2">{{ __('setup-servicedesk-site-index2.site_language') }}</h4>
        <!--<button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal"-->
        <!--    data-target="#newSiteModal">New Site-->
        <!--</button>-->
        <a href="/setup/servicedesk/site/new" style="margin-bottom: 10px" class="btn btn-md btn-primary">{{ __('setup-servicedesk-site-index2.new-site_language') }}</a>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table" id="site_table">
                    <thead>
                        <tr>
                            <th width="8%"></th>
                            <th>{{ __('setup-servicedesk-site-index2.sid_language') }}</th>
                            <th>{{ __('setup-servicedesk-site-index2.site-name_language') }}</th>
                            <th>{{ __('setup-servicedesk-site-index2.region-name_language') }}</th>
                            <th>{{ __('setup-servicedesk-site-index2.site-category_language') }}</th>
                            <th>{{ __('setup-servicedesk-site-index2.site-description_language') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sites as $site)
                            <tr>
                                <td>
                                    <button style="background-color: Transparent;background-repeat:no-repeat;border: none;  cursor:pointer;overflow: hidden;   " class="delete" data-title="{{ $site->name_site}}"
                                        href="{{ route('sites.delete',$site->site_id)}}"><i
                                            class="fa fa-trash"></i></button>
                                    <form action="" method="post" id="deleteForm">
                                        @csrf
                                        <input type="submit" value="" style="display:none">
                                    </form>
                                </td>
                                <td class="text_name">{{ $site->uid_site }}</td>
                                <td class="text_name">
                                    <a href="{{ route('sites.edit',$site->site_id)}}">
                                    {{ $site->name_site }}
                                    </a>
                                </td>
                                <td class="text_name">{{ $site->region->region_name }}</td>
                                <td class="text_name">{{ isset($site->site_cat)?$site->site_cat->site_cat_name:'' }}</td>
                                <td class="text_name">{{ $site->site_desc }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="modal fade" id="newSiteModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup-servicedesk-site-index2.new-site_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('sites.add') }}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="uid_site" class="text_name">{{ __('setup-servicedesk-site-index2.sid2_language') }}</label>
                            <input name="uid_site" type="text" value="{{ old('uid_site') }}"
                                class="placeholder_color form-control @error('uid_site') is-invalid invalid @enderror"
                                id="uid_site" aria-describedby="uid_site" placeholder="{{ __('setup-servicedesk-site-index2.uid_language') }}">
                            @error('name_site')
                            <span class="invalid" style="color: red"><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name_site" class="text_name">{{ __('setup-servicedesk-site-index2.site-name2_language') }}</label>
                            <input name="name_site" type="text" value="{{ old('name_site') }}"
                                class="placeholder_color form-control @error('name_site') is-invalid invalid @enderror"
                                id="name_site" aria-describedby="namaHelp" placeholder="{{ __('setup-servicedesk-site-index2.name_language') }}">
                            @error('name_site')
                            <span class="invalid" style="color: red"><i>{{$message}}</i></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="region_name" class="text_name form-control-label">{{ __('setup-servicedesk-site-index2.region-name2_language') }}</label>
                            <select class="form-control searchRegion select2" id="region_name"  name="region_name"></select>
                            <p class="text-danger">{{ $errors->first('participant_id') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="id_site_category" class="text_name form-control-label">{{ __('setup-servicedesk-site-index2.region-site-category-name_language') }}</label>
                            <select class="form-control select2" id="id_site_category" name="id_site_category">
                                @foreach(\App\Model\Site_Cat::get() as $site_cat)
                                    <option value="{{$site_cat->site_cat_id}}">
                                        {{$site_cat->site_cat_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="head_manager" class="text_name">{{ __('setup-servicedesk-site-index2.head-manager_language') }}</label>
                            <select class="form-control select2" id="head_manager" name="head_manager">
                                @foreach(\App\User::get() as $head_manager)
                                    <option value="{{$head_manager->id}}">
                                        {{$head_manager->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="address">{{ __('setup-servicedesk-site-index2.address_language') }}</label>
                            <textarea name="address" class="form-control @error('address') is-invalid invalid @enderror" id="address" rows="3" placeholder="{{ __('setup-servicedesk-site-index2.place-your-address_language') }}">{{ old('address') }}</textarea>
                            @error('address')
                            <span class="invalid">{{ $errors->first('address') }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">{{ __('setup-servicedesk-site-index2.desc_language') }}</label>
                            <textarea name="description" class="form-control @error('description') is-invalid invalid @enderror" id="address" rows="3" placeholder="{{ __('setup-servicedesk-site-index2.place-your-desc_language') }}">{{ old('description') }}</textarea>
                            @error('description')
                            <span class="invalid">{{ $errors->first('description') }}</span>
                            @enderror
                        </div>
                        
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-servicedesk-site-index2.save_language') }}</button>
                            <button type="submit" class="btn btn-default" style="color: #fff; background: #CECECE">{{ __('setup-servicedesk-site-index2.cancel_language') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
    $('#site_table').DataTable();
    
    $('button.delete').on('click', function () {
        var href = $(this).attr('href');
        var title = $(this).data('title')
        swal({
                title: "{{ __('setup-servicedesk-site-index2.ask_language') }} " + title + "?",
                text: "{{ __('setup-servicedesk-site-index2.notif_language') }}",
                icon: "warning",
                buttons: ["{{ __('setup-servicedesk-site-index2.cancel2_language') }}", "{{ __('setup-servicedesk-site-index2.yes_language') }}"],
            })
            .then((willDelete) => {
                if (willDelete) {
                    document.getElementById('deleteForm').action = href;
                    document.getElementById('deleteForm').submit();
                    swal("{{ __('setup-servicedesk-site-index2.message_language') }}", {
                        icon: "success",
                    });
                }
            });
    });

    $(".searchRegion").select2({
        placeholder:"Place your region name",
        ajax: {
            url: "/getRegion",
            dataType: "json",
            delay: 150,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                            item_text =  item.region_name;
                            return {
                                text: item_text,
                                id: item.region_id
                            };
                    })
                };
            },
            cache: false
        }
    }).on('change', function (e) {

    });
    </script>
    <script>
    $("#searchCatSite").select2({
        placeholder:"Place your category name",
        ajax: {
            url: "/getSiteCat",
            dataType: "json",
            delay: 150,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                            item_text =  item.site_cat_name;
                            return {
                                text: item_text,
                                id: item.site_cat_id
                            };
                    })
                };
            },
            cache: false
        }
    }).on('change', function (e) {

    });
    </script>

@endpush
