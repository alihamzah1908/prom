@extends('template.default')
@section('submenu')
<div class="row mb-2 pb-3">
    <div class="col-sm-6">
        <h3 class="m-0 text-dark"><strong>Aktivasi Port</strong></h3>
    </div>
</div>
@endsection
@section('content')
@if(Session::has('message'))
<div class="alert {{Session::get('alert-class')}} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{ Session::get('message') }}
</div>
@endif
<form method="POST" action="/aktivasi-layanan/new_aktivasi" enctype="multipart/form-data">
@csrf
<style>
    .display-none{
        display:none;
    }
</style>
<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">Activation Form</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="name">Type</label>
                    <select class="form-control btn-default" name="id_type_service" onchange="document.location.href='?id_type_service='+this.value" required autofocus>
                        <option value="" selected disabled> -- Type Aktivasi -- </option>
                        @foreach(\App\Model\AktivasiType::get() as $type)
                            <option value="{{$type->id_service}}" {{$id_type_service == $type->id_service ? 'selected':''}}>{{$type->service_name}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="name">Customer</label>
                    <input class="form-control" type="text" name="id_customer" required autofocus>
                        <!--<option value="" selected disabled> -- Customer -- </option>-->
                        <!--@foreach(\App\Model\Customer::get() as $c)-->
                        <!--    <option value="{{$c->id_customer}}">{{$c->name_customer}}</option>-->
                        <!--@endforeach-->
                    </input>
                </div>
                
                <!--<div class="form-group">-->
                <!--    <label>Region</label>-->
                <!--    <select class="form-control select2" style="width: 100%;" required autofocus name="id_region" required autofocus>-->
                <!--        <option selected="selected" disabled value="">-- Select Region --</option>-->
                <!--        @foreach(\App\Model\Region::get() as $region)-->
                <!--            <option value="{{$region->region_id}}">{{$region->region_name}}</option>-->
                <!--        @endforeach-->
                <!--    </select>-->
                <!--</div>-->
                
                <!--<div class="form-group">-->
                <!--    <label>Location</label>-->
                <!--    <select class="form-control select2" style="width: 100%;" required autofocus name="id_segment">-->
                <!--        <option selected="selected" disabled value="">-- Select Location --</option>-->
                <!--        @foreach(\App\Model\Segment::get() as $segment)-->
                <!--            <option value="{{$segment->id_segment}}">{{$segment->segment_name}}</option>-->
                <!--        @endforeach-->
                <!--    </select>-->
                <!--</div>-->
                
                <div class="form-group">
                    <label>Region</label>
                    <select class="form-control select2 select_region" style="width: 100%;" required autofocus name="id_region">
                        <option selected="selected" disabled value="">-- Select Region --</option>
                        @foreach(\App\Model\Region::get() as $site)
                            <option value="{{$site->region_id}}">{{$site->region_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Site A</label>
                    <select class="form-control select2 select_site" style="width: 100%;" required autofocus name="id_site" multiple></select>
                </div>
                
               
                 
                @if(request()->id_type_service != 3)
                 <div class="form-group">
                    <label>Site B</label>
                    <select class="form-control select2 select_site" style="width: 100%;" required autofocus name="id_site_b" multiple></select>
                </div>
                <div class="form-group">
                    <label>Layanan</label>
                    <select class="form-control" style="width: 100%;" name="capasity_type" required autofocus>
                        <option value="Sewa Kapasitas">Sewa Kapasitas</option>
                        <option value="Sewa Dark Fiber">Sewa Dark Fiber</option>
                    </select>
                    
                    <div id="capasity_parent">
                        <select class="form-control select2" style="width: 100%;" name="capasity" required autofocus>
                          
                             @foreach(\App\Model\Capacity::get() as $capacity)
                            <option value="{{$site->region_id}}">{{$capacity->capacity_name}}</option>
                        @endforeach
                        </select>
                  <!--//  </div>-->
                    <!--<div id="select_cord_parent">-->
                    <!--    <select class="form-control select2" style="width: 100%;" name="id_cord" required autofocus>-->
                            <!--@foreach(\App\Model\Cord::get() as $d)-->
                            <!--<option value="{{$d->id_cord}}">{{$d->name_cord}}</option>-->
                            <!--@endforeach-->
                    <!--    </select>-->
                  <!--  </div>-->
                </div>
                @endif
                <div class="form-group" >
                    <label>Memo</label>
                    <input  name="memo" type="file" class="form-control ">
                </div>
                <div class="form-group" >
                    <label>Rekomendasi Bakti</label>
                    <input  name="bakti" type="file" class="form-control ">
                </div>
                
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="active_desc" style="width: 100%;" class="form-control" rows="3" placeholder="Description" required autofocus></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary float-right">Submit</button>
    </div>
</div>
</form>
@endsection
@push('scripts')
    <script>
        $('.select2').select2();
        $(document).on('change', 'select[name=capasity_type]', function(e){
            e.preventDefault();
            setCapasity();
        });
        
        $(document).on('change', '.select_region', function(e){
            e.preventDefault();
            id = $(this).val();
            console.log(id);
            setSelectSite(id);
            
        })
        
        function setSelectSite(id_region){
            $(".select_site").val('');
            $(".select_site").select2({
                placeholder: "Site",
            ajax: {
                url: "/setup/servicedesk/site/getSite",
                data: {
                    'id_region': id_region
                },
                dataType: "json",
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.name_site,
                                id: item.site_id
                            };
                        })
                    };
                },
                cache: false
            }
            })
        }
        setCapasity()
        function setCapasity(){
            var ini = $('select[name=capasity_type]'),
                val = ini.val(),
                id_cord = $('select[name=id_cord]'),
                id_cord_parent = $('#select_cord_parent'),
                capasity = $('select[name=capasity]'),
                capasity_parent = $('#capasity_parent');
                
            if(val === "Sewa Kapasitas"){
                is_req(capasity_parent, capasity)
                un_req(id_cord_parent, id_cord)
                console.log(val, 1)
            }else if(val === "Sewa Dark Fiber"){
                is_req(id_cord_parent, id_cord)
                un_req(capasity_parent, capasity)
                console.log(val, 2)
            }else{
                is_req(capasity_parent, capasity)
                un_req(id_cord_parent, id_cord)
                console.log(val, 3)
            }
        }
        function is_req(parent, el){
            parent.removeClass('display-none');
            el.attr('required','required');
            el.attr('autofocus','autofocus');
            console.log(el, 'show')
        }
        function un_req(parent, el){
            parent.addClass('display-none');
            el.attr('required',false);
            el.attr('autofocus',false);
            console.log(el, 'hide')
        }
    </script>
@endpush
