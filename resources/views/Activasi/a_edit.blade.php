<style>
    .display-none{
        display:none;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="name">Type</label>
            <select class="form-control btn-default" name="id_type_service" disabled>
                <option value="" selected disabled> -- Type Aktivasi -- </option>
                @foreach(\App\Model\AktivasiType::get() as $type)
                    <option value="{{$type->id_service}}" {{$data->id_type_service == $type->id_service ? 'selected':''}}>{{$type->service_name}}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="name">Status</label>
            <select class="form-control btn-default" type="text" name="id_status" @if(is_admin(Auth::user())) required autofocus @else disabled @endif>
                <option value="" selected disabled> -- Status -- </option>
                @if($data->id_type_service == 3)
                    @foreach(\App\Model\AktivasiStatusCollocation::get() as $c)
                        <option value="{{$c->id}}" {{$data->id_status == $c->id ? 'selected':''}}>{{$c->name}}</option>
                    @endforeach
                @else
                    @foreach(\App\Model\AktivasiStatus::get() as $c)
                        <option value="{{$c->id}}" {{$data->id_status == $c->id ? 'selected':''}}>{{$c->name}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        
        <div class="form-group">
            <label for="name">Customer</label>
       
            <textarea name="id_customer" style="width: 100%;" class="form-control"  placeholder="Customer" required autofocus>{{$data->id_customer}}</textarea>
        
        </div>
        
        <!--<div class="form-group">-->
        <!--    <label>Region</label>-->
        <!--    <select class="form-control select2" style="width: 100%;" required autofocus name="id_region">-->
        <!--        <option selected="selected" disabled value="">-- Select Region --</option>-->
        <!--        @foreach(\App\Model\Region::get() as $region)-->
        <!--            <option value="{{$region->region_id}}">{{$region->region_name}}</option>-->
        <!--        @endforeach-->
        <!--    </select>-->
        <!--</div>-->
        
    
        
        
        <div class="form-group">
            <label>Region</label>
            <select class="form-control select2 select_region" style="width: 100%;" disabled name="id_region">
                <option selected="selected" disabled value="">-- Select Region --</option>
                @foreach(\App\Model\Region::get() as $site)
                    <option value="{{$site->region_id}}" {{$data->id_region == $site->region_id ? 'selected':''}}>{{$site->region_name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Site A</label>
            <select class="form-control select_site" style="width: 100%;" multiple name="id_site">
                <?php 
                $id_site = json_decode($data->id_site);
                if(!is_array($id_site)) $id_site = [$id_site];
                ?>
                @foreach(\App\Model\Site::where('region_id', $data->id_region)->get() as $site)
                    <option value="{{$site->site_id}}" {{in_array($site->site_id, $id_site) ? 'selected':''}}>{{$site->name_site}}</option>
                @endforeach
            </select>
        </div>
         <div class="form-group">
            <label>Site B</label>
            <select class="form-control select_site" style="width: 100%;" multiple name="id_site_b">
                <?php 
                $id_site = json_decode($data->id_site_b);
                if(!is_array($id_site)) $id_site = [$id_site];
                ?>
                 @foreach(\App\Model\Site::where('region_id', $data->id_region)->get() as $site)
                    <option value="{{$site->site_id}}" {{in_array($site->site_id, $id_site) ? 'selected':''}}>{{$site->name_site}}</option>
                @endforeach
            </select>
        </div>
        
        @if($data->id_type_service != 3)        
        <div class="form-group">
            <label>Kapasitas</label>
            <select class="form-control" style="width: 100%;" name="capasity_type" required autofocus>
                <option value="Sewa Kapasitas">Sewa Kapasitas</option>
                <option value="Sewa Dark Fiber" {{$data->capasity_type == "Sewa Dark Fiber" ? 'selected':''}}>Sewa Dark Fiber</option>
            </select>
            
            <div id="capasity_parent">
                <select class="form-control select2" style="width: 100%;" name="capasity">
                    <option value="1 GB" {{$data->capasity == "1 GB" ? 'selected':''}}>1 GB</option>
                    <option value="10 GB" {{$data->capasity == "10 GB" ? 'selected':''}}>10 GB</option>
                </select>
            </div>
            <div id="select_cord_parent">
                <select class="form-control select2" style="width: 100%;" name="id_cord" required autofocus>
                    @foreach(\App\Model\Cord::get() as $d)
                    <option value="{{$d->id_cord}}" {{$data->id_cord == $d->id_cord ? 'selected':''}} >{{$d->name_cord}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif
        
        <div class="form-group row">
            @if($data->memo_file)
            <div class="col-md-6">
                <label>Memo</label>
                <br>
                <a href="/aktivasi/memo/{{$data->memo_file}}" target="new">
                    <img src="/aktivasi/memo/{{$data->memo_file}}" width="20%">
                </a>
            </div>
            @endif
            <div class="col-md-6">
                <label>Change Memo @if($data->memo_file)<small>(Leave Empty to keep Memo as it is)</small>@endif</label>
                <input name="subject" type="file" class="form-control " id="subject" aria-describedby="namaHelp">
            </div>
        </div>
        <div class="form-group row" >
            @if($data->bakti_file)
            <div class="col-md-6">
                <label>Rekomendasi Bakti</label>
                <br>
                <a href="/aktivasi/bakti/{{$data->bakti_file}}" target="new">
                    <img src="/aktivasi/bakti/{{$data->bakti_file}}" width="20%">
                </a>
            </div>
            @endif
            <div class="col-md-6">
                <label>Change Bakti @if($data->bakti_file)<small>(Leave Empty to keep Memo as it is)</small>@endif</label>
                <input  name="bakti" type="file" class="form-control " aria-describedby="namaHelp">
            </div>
        </div>
        
        <div class="form-group">
            <label>Description</label>
            <textarea name="active_desc" style="width: 100%;" class="form-control" rows="3" placeholder="Description" required autofocus>{{$data->active_desc}}</textarea>
        </div>
    </div>
</div>

<script>
    $('.select2').select2();
    $('.select_site').select2({
        laceholder: "Site"
    });
    
    $(document).on('change', 'select[name=capasity_type]', function(e){
        e.preventDefault();
        setCapasity();
    });
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