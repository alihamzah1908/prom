<div class="row">
    <div class="col-md-7">
        <div class="card-header mb-4" style="border-bottom: 4px solid {{isset($data->status)?$data->status->color:'#000'}};">
            <h3 class="card-title">
                <b>
                    STATUS: <span style="color:{{$data->status?$data->status->color:'rgba(0,0,0,.125)'}};">{{isset($data->status)?$data->status->name:''}}</span>
                </b>
            </h3>
        </div>
        <br>
        
        <strong>UID</strong>
        <p class="text-muted">{{$data->active_uid}}</p>
        <hr>
        <strong>Customer</strong>
        <p class="text-muted">{{isset($data->id_customer)?$data->id_customer:'-'}}</p>
        <hr>
         <tr>
                                        <strong width="15%"><b>Memo</b></strong>
                                        <br>
                                        <td>
                                            <a href="/aktivasi/memo/{{$data->memo_file}}" target="new">
                                                <img src="/aktivasi/memo/{{$data->memo_file}}" width="20%">
                                            </a>
                                        </td>
                                    </tr>
                                    
    </div>
    <div class="col-md-5">
        <div class="card-header mb-4" style="border-bottom: 4px solid {{$data->getStatus?$data->getStatus->color:'rgba(0,0,0,.125)'}};">
            <h3 class="card-title">
                <b>
                    TYPE: {{$data->type?$data->type->service_name:''}}
                </b>
            </h3>
        </div>
        <br>
        
        <strong>Region</strong>
        <p class="text-muted">{{isset($data->region)?$data->region->region_name:'-'}}</p>
        <hr>
        <strong>Type Capacity</strong>
        <p class="text-muted">{{$data->capasity_type}}</p>
        <hr>
        <strong>Capacity</strong>
        <p class="text-muted">{{isset($data->capacity)?$data->capacity->capacity_name:'-'}}</p>
        <hr>
          
       
                                    <tr>
                                        <td width="15%"><b>Bakti</b></td>
                                        <br>
                                        <td>
                                            <a href="/aktivasi/bakti/{{$data->bakti_file}}" target="new">
                                                <img src="/aktivasi/bakti/{{$data->bakti_file}}" width="20%">
                                            </a>
                                        </td>
                                    </tr>
                                    </div>
    
    
</div>