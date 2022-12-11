<div style="pointer-events: none;">
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
                        @foreach(\App\Model\Status::get() as $s)
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
</div>
<br>
<br>
<hr>
<br>
<?php 
$update_type = "IMAGE";
if($task->id_task_type == 2){
    if($task_detail->checklist_periode == 1){
        $update_type = "CHECKLIST";
    }elseif($task_detail->checklist_periode == 2){
        $update_type = "CHECKLIST";
    }
}
if($task->id_task_type == 3) $update_type = "NONE";
if($task->id_task_type == 4){
    $update_type = "IMAGE";
}

?>
@if($next_status == '5')
<div class="card collapsed-card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-11">
                <h3 class="card-title">SUBMIT {{$update_type}}</h3>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-tool float-right" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($update_type == "IMAGE")
        <form method="POST" action="/task/image_before_after/{{$task->id_task}}" enctype="multipart/form-data"> 
        @csrf
        <div class="row">
            <div class="col-md-6 image_before_wrapper">
                <div class="form-group">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-success btn-add-image-before"><i class="fa fa-plus"></i></button>
                        <button class="btn btn-sm btn-warning btn-min-image-before"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="form-group fc_image_before">
                    <label>Image Before</label>
                    <input class="form-control" type="file" name="image_before[]" accept="image/*">
                </div>
            </div>
            <div class="col-md-6 image_after_wrapper">
                <div class="form-group">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-success btn-add-image-after"><i class="fa fa-plus"></i></button>
                        <button class="btn btn-sm btn-warning btn-min-image-after"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="form-group fc_image_after">
                    <label>Image After</label>
                    <input class="form-control" type="file" name="image_after[]" accept="image/*">
                </div>
            </div>
        </div>
        
        <div class="card-footer bg-transparent">
            <button type="submit" class="btn btn-info float-right btn-md">Upload</button>
        </div>
        </form>
        @elseif($update_type == "CHECKLIST")
        <form method="POST" action="/task/submit_task_checklist/{{$task->id_task}}" enctype="multipart/form-data"> 
        @csrf
            <div style="height:80vh; overflow:auto">
                <table id="table_submit_checklit" class="table">
                    <thead>
                        <tr>
                            <th style="width: 52px">ID</th>
                            <th width="35%">Checklist</th>
                            <th>Is_Available</th>
                            <th>Answer</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $c = 0;
                        ?>
                        @forelse(\App\Model\Checklist::where('id_region', $task->id_region)->where('checklist_periode', $task_detail->checklist_periode)->whereIn('id_checklist_category', json_decode($task_detail->id_checklist_category))->get() as $ch)
                        <tr>
                            <td>{{++$c}}</td>
                            <td>{{$ch->checklist_name}}</td>
                            <td>
                                <input name="checklist[{{$c}}]" value="{{$ch->id_checklist}}" hidden>
                                <select class="form-control" name="is_available[{{$c}}]">
                                    <option>OK</option>
                                    <option>NOT OK</option>
                                </select>
                            </td>
                            <td>
                                <input class="form-control" name="answers[{{$c}}]" required autofocus>
                            </td>
                            <td>
                                <input class="form-control" name="image[{{$c}}]" type="file">
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-transparent">
                <button type="submit" class="btn btn-info float-right btn-md">Upload</button>
            </div>
        </form>
        @else
        @endif
    </div>
</div>
@endif
@if($update_type == "IMAGE")
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Images</h3>
         <div class="card-tools">
         <form method="GET" action="/task/download2">
                @csrf
                <div name="download_type2"class="btn-group">
                    <a href="/task/plm_task_excel/excel?id_task={{$task->id_task}}" value="EXCEL" class="btn btn-sm btn-success"> <i class="fa fa-file-excel"></i> EXCEL</a>
                    <a href="/task/pdf_task_plm/pdf?id_task={{$task->id_task}}" class="btn btn-sm btn-danger" target="new"><i class="fa fa-file-pdf"></i> PDF</a>
                </div>
            </form>
            </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Before</th>
                            @if($technician)
                            <th></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $angka1=0;
                        @endphp
                        @foreach($before as $b)
                        <tr>
                            <td>{{++$angka1}}</td>
                            <td>
                                <a href="/task_report/{{$b->image}}" target="new">
                                    <img src="/task_report/{{$b->image}}" width="150px">
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>After</th>
                            @if($technician)
                            <th></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $angka2=0;
                        @endphp
                        @foreach($after as $b)
                        <tr>
                            <td>{{++$angka2}}</td>
                            <td>
                                <a href="/task_report/{{$b->image}}" target="new">
                                    <img src="/task_report/{{$b->image}}" width="150px">
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@elseif($update_type == "CHECKLIST")
<p class="judul1"></p>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Checklists</h3>
        <div class="card-tools">
            <form method="GET" action="/task/download2">
                @csrf
                <div name="download_type2"class="btn-group">
                    <a href="/task/checklist_answers/excel?id_task={{$task->id_task}}" value="EXCEL" class="btn btn-sm btn-success"> <i class="fa fa-file-excel"></i> EXCEL</a>
                    <a href="/task/checklist_answers/pdf?id_task={{$task->id_task}}" class="btn btn-sm btn-danger" target="new"><i class="fa fa-file-pdf"></i> PDF</a>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body">
    <table class="table" id="table_checklist" width="100%">
        <thead>
            <tr>
                <th style="width: 52px">ID</th>
                <th>Checklist</th>
                <th>Is_Available</th>
                <th>Answer</th>
                <th>Images</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $answers = isset($task->checklist_answers)?$task->checklist_answers->datas:'[]';
            $i = 0;
            ?>
            @forelse(json_decode($answers) as $a)
                <tr>
                <td>{{++$i}}</td>
                <td>{{$a->checklist_name ?? 'empty'}}</td>
                <td>{{$a->is_avaiable ?? 'empty'}}</td>
                <td>{{$a->answer ?? 'empty'}}</td>
                <td>
                    @if(isset($a->image))
                    
                     @foreach($a->image as $img => $val)
                     
                    
                    <a href="/checklist_image/{{$val}}" target="new">
                        <img src="/checklist_image/{{$val}}" width="120px" height="150px">
                    </a>
                     @endforeach
                    
                  
                    @else 

                             <a href="/checklist_image/{{isset($a->image)?$a->image : ""  }}" target="new">
                        <img src="/checklist_image/{{isset($a->image)?$a->image : ""}}" width="150px">
                    </a>
                     
                     @endif
                    
                    
                    
                </td>
            </tr>
            @empty
            @endforelse
        </tbody>
    </table>
    </div>
</div>
@else
@endif

<script>
    var image_before = '<div class="form-group fc_image_before"><label>Image Before</label><input class="form-control" type="file" name="image_before[]" accept="image/*"></div>';
    var image_after  = '<div class="form-group fc_image_after"><label>Image After</label><input class="form-control" type="file" name="image_after[]" accept="image/*"></div>';
    
    var image_before_wrapper = $('.image_before_wrapper');
    var image_after_wrapper  = $('.image_after_wrapper');
    
    $(document).on('click', '.btn-add-image-before', function(e){
        e.preventDefault();
        image_before_wrapper.append(image_before);
    });
    $(document).on('click', '.btn-add-image-after', function(e){
        e.preventDefault();
        image_after_wrapper.append(image_after);
    });
    
    $(document).on('click', '.btn-min-image-before', function(e){
        e.preventDefault();
        $(".fc_image_before").last().remove();
    });
    $(document).on('click', '.btn-min-image-after', function(e){
        e.preventDefault();
        $(".fc_image_after").last().remove();
    });
    
    
    $(document).ready(function(){
        $('#table_checklist').DataTable();
    });
</script>














