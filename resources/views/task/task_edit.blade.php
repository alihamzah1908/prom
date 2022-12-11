<div class="card-body" style="border-bottom: 1px solid rgba(0, 0, 0, .125);">
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label>Template Name</label>
                <input class="form-control" readonly value="{{\App\Model\TaskType::where('id_type', $task->id_task_type)->first()->type_name}}">
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-5">
            <div class="form-group">
                <label>Status</label>
                <select class="form-control select2" style="width: 100%;" name="id_status">
                    @foreach(\App\Model\Status::where('task_type_id',$task->id_task_type)->get() as $s)
                    <option value="{{$s->id_status}}" {{$task->id_status == $s->id_status ? 'selected':''}}>{{$s->status_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
@include($task_type)

@if($add_ons)
    @if(count($add_ons))
        @foreach($add_ons as $add_on)
            <div class="card-body" style="border-bottom: 1px solid rgba(0, 0, 0, .125);">
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
            <div class="card-body" id="{{$add_on->section_id}}" style="border-bottom: 1px solid rgba(0, 0, 0, .125);">
                <div class="row">
                @foreach(\App\TaskAddOns::where('id_section', $add_on->id)->orderBy('id','ASC')->get() as $field)
                    <div class="form-group col-md-6" data-type="{{$field->type}}">
                        <?php $encode = ['id' => $field->field_id, 'name' => $field->name, 'type' => $field->type, 'value' => $field->value, 'parent' => isset($field->section)?$field->section->section_id:'',]; ?>
                        <input name="field_parent[]" value="{{$add_on->section_id}}" hidden>
                        <input name="arr_field[]" value="{{json_encode($encode)}}" hidden>
                        @if($field->type == "EMPTY_ROW")
                        <input id="{{$field->field_id}}" hidden name="{{$field->field_id}}" value="EMPTY_ROW">
                        <input name="fields[]" value="{{$field->field_id}}" hidden>
                        @else
                        <label>{{$field->name}}</label>
                        <input class='form-control' placeholder="{{$field->name}}" name="{{$field->name}}" type="{{$field->type}}" id="{{$field->field_id}}" value="{{$field->value}}">
                        <input name="fields[]" value="{{$field->name}}" hidden>
                        @endif
                    </div>
                @endforeach
                </div>
            </div>
        @endforeach
    @endif
@endif