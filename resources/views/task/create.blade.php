@extends('template.default')
@section('submenu')
<style>
    .container-fluid {
    width: 100%;
    padding-right: 7.5px;
    padding-left: 7.5px;
    margin-right: auto;
    margin-left: auto;
    padding-top: 7px;
    }
    .card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 0rem 1rem 0rem 1rem;
    }
    label {
    display: inline-block;
    margin-bottom: 0.1rem;
    }
    p {
    margin-top: 0.1rem;
    margin-bottom: 0.2rem;
    }
    .form-group {
    margin-bottom: 0.3rem;
    }
</style>
<!--dihilangkan untuk judul-->
<!--<div class="row mb-2 pb-3">-->
<!--    <div class="col-sm-6">-->
<!--        <h3 class="m-0 text-dark"><strong>{{$template_name}}</strong></h3>-->
<!--        <small>Task > {{$template_name}}</small>-->
<!--    </div>-->
<!--</div>-->
@endsection
@section('content')

@if(Session::has('message'))
<div class="alert {{Session::get('alert-class')}} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{ Session::get('message') }}
</div>
@endif

<form method="POST" action="/task/new_task" enctype="multipart/form-data"> 
@csrf
<div class="card card-default">
    <!--<div class="card-header">-->
    <!--</div>-->
    <!--style="border-bottom: 1px solid rgba(0, 0, 0, .125);"-->
    <div class="card-body col-md-12" style="padding: 1rem 1rem 0rem 1rem !important;">
        <div class="form-group row">
                        <div class="col-sm-1 text-center">
                            <label>Task Type</label>
                        </div>
                        
                        <div class="col-sm-3">
                            <select class="form-control select2" style="width: 100%;" name="id_template" onchange="document.location.href='/task/create?id_template='+this.value">
                                @foreach(\App\Model\TaskType::get() as $type)
                                <option value="{{$type->id_type}}" {{$id_template == $type->id_type ? 'selected':''}}>{{$type->type_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-1 text-right">
                            <label>Template</label>
                        </div>
                        
                        <div class="col-sm-3">
                            <select class="form-control select2" style="width: 100%;" name="template_devault_value" onchange="document.location.href='/task/create?id_template={{$id_template}}&template_default_value='+this.value">
                                <option value="" selected disabled>-- Select Template --</option>
                                @foreach(\App\Templates::where('id_task_type', $id_template)->get() as $tmp)
                                <option value="{{$tmp->id}}" {{$template_default_value == $tmp->id ? 'selected':''}}>{{$tmp->template_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-1 text-right">
                            <label>Status</label>
                        </div>
                        
                        <div class="col-sm-3">
                            <input class="form-control" readonly value="OPEN">
                        </div>
        </div>
        
    </div>
    @include($task_type)
    @if($add_ons)
        @if(count($add_ons))
            @foreach($add_ons as $add_on)
                <div class="card-body" >
                    <div class="row">
                        <div class="col-md-5">
                            <p class="judul1">{{$add_on->name}}</p>
                            <input hidden name="section_name[]" value="{{$add_on->name}}">
                            <input hidden name="section_id[]" value="{{$add_on->section_id}}">
                        </div>
                        <div class="col-md-7">
                        </div>
                    </div>
                </div>
                <div class="card-body" id="{{$add_on->section_id}}" >
                    <div class="row">
                    @foreach(\App\TemplatesAddOns::where('id_section', $add_on->id)->orderBy('id','ASC')->get() as $field)
                        <div class="form-group col-md-6" data-type="{{$field->type}}">
                            <?php $encode = ['id' => $field->field_id, 'name' => $field->name, 'type' => $field->type, 'default_value' => $field->default_value, 'parent' => isset($field->section)?$field->section->section_id:'',]; ?>
                            <input name="field_parent[]" value="{{$add_on->section_id}}" hidden>
                            <input name="arr_field[]" value="{{json_encode($encode)}}" hidden>
                            @if($field->type == "EMPTY_ROW")
                            <input id="{{$field->field_id}}" hidden name="{{$field->field_id}}" value="EMPTY_ROW">
                            <input name="fields[]" value="{{$field->field_id}}" hidden>
                            @else
                            <label>{{$field->name}}</label>
                            <input class='form-control' placeholder="{{$field->name}}" name="{{$field->name}}" type="{{$field->type}}" id="{{$field->field_id}}" value="{{$field->default_value}}">
                            <input name="fields[]" value="{{$field->name}}" hidden>
                            @endif
                        </div>
                    @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    @endif
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Add</button>
    </div>
</div>
</form>
@endsection
@push('scripts')
    
@endpush
