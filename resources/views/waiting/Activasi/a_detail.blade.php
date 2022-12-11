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
        <p class="text-muted">{{isset($data->customer)?$data->customer->name_customer:'-'}}</p>
        <hr>
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
        <strong>Segment</strong>
        <p class="text-muted">{{isset($data->segment)?$data->segment->segment_name:'-'}}</p>
        <hr>
        <strong>Site</strong>
        <p class="text-muted">{{isset($data->site)?$data->site->name_site:'-'}}</p>
        <hr>
    </div>
</div>