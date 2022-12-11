<style>
/*reset*/
.buttons{
    padding-top: 10px;
    padding-bottom: 5px;
    float:right; 
    overflow:auto;
}
.btn-green {
    display: inline-block;
    font-weight: 400;
    background: #28a745;
    text-align: center;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    color: white;
    border: 1px solid transparent;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: .25rem;
    transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}


/*x--reset--x*/
    .close-icon
    {
        display:block;
        box-sizing:border-box;
        width:20px;
        height:20px;
        border-width:3px;
        border-style: solid;
        border-color:gray;
        border-radius:100%;
        background: -webkit-linear-gradient(-45deg, transparent 0%, transparent 46%, white 46%,  white 56%,transparent 56%, transparent 100%), -webkit-linear-gradient(45deg, transparent 0%, transparent 46%, white 46%,  white 56%,transparent 56%, transparent 100%);
        background-color:gray;
        box-shadow:0px 0px 5px 2px rgba(0,0,0,0.5);
        transition: all 0.3s ease;
        content: "×";
    }
    
    .my-button{
        float:right; 
        overflow:auto;
    }
    .margin-form{
        margin-top:30px;
    }
</style>


<div class="card-body" >
    <div class="buttons">
		<button class="btn-green" onClick="window.location.reload();">
			{{ __('setup-templateform-crtask.reset-form_language') }}
		</button>
	</div>
    <div class="row" style="padding-top: 30px;">
        <div class="col-md-5">
            <div class="form-group">
                    <button id="hide" class="close-icon my-button"></button>
                    <label>{{ __('setup-templateform-crtask.category_language') }}</label><br>
                
                
                   
                    <select class="form-control select2 select_category" required autofocus name="id_category">
            
                            <option selected="selected" disabled value="">-- {{ __('setup-templateform-crtask.select-category_language') }} --</option>
                        @foreach(\App\Model\Category::get() as $cat)
                            <option value="{{$cat->id_category}}">{{$cat->category_name}}</option>
                        @endforeach
                        
                    </select> 
            </div>
            <div class="form-group margin-form">
                <button id="hide" class="close-icon my-button"></button>
                <label for="priority">{{ __('setup-templateform-crtask.priority_language') }}</label>
                <select class="form-control select2" style="width: 100%;" required autofocus name="id_priority">
                    <option selected="selected" disabled value="">-- {{ __('setup-templateform-crtask.select-priority_language') }} --</option>
                    @foreach(\App\Model\Priority::where('id_task_type', $id_template)->get() as $priority)
                        <option value="{{$priority->id_priority}}" @if(old('id_priority') == $priority->id_priority || $task_detail->id_priority == $priority->id_priority) selected @endif>{{$priority->priority_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group margin-form">
                <button id="hide" class="close-icon my-button"></button>
                <label>{{ __('setup-templateform-crtask.region_language') }}</label><br>
                
                <select class="form-control select2" style="width: 100%;" required autofocus name="id_region">
                    <option selected="selected" disabled value="">-- {{ __('setup-templateform-crtask.select-region_language') }} --</option>
                    @foreach(\App\Model\Region::get() as $region)
                        <option value="{{$region->region_id}}" @if(old('id_region') == $region->region_id || $task->id_region == $region->region_id) selected @endif>{{$region->region_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group margin-form">
                <button id="hide" class="close-icon my-button"></button>
                <label>{{ __('setup-templateform-crtask.location-a_language') }}</label><br>
                <select class="form-control select2" style="width: 100%;" required autofocus name="id_location_a">
                    <option selected="selected" disabled value="">-- {{ __('setup-templateform-crtask.select-location_language') }} --</option>
                    @foreach(\App\Model\Segment::get() as $segment)
                        <option value="{{$segment->id_segment}}" @if(old('id_location_a') == $segment->id_segment || $task->id_location_a == $segment->id_segment) selected @endif>{{$segment->segment_name}}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group margin-form">
                <button id="hide" class="close-icon my-button"></button>
                <label for="description">{{ __('setup-templateform-crtask.description_language') }}</label>
                <textarea name="description" class="form-control @error('description') is-invalid invalid @enderror" id="description" rows="4" placeholder="{{ __('setup-templateform-crtask.description2_language') }}" required autofocus>@if(old('description')){{old('description')}}@elseif($task->description){{$task->description}}@endif</textarea>
            </div>
            @if(request()->path() == '/setup/template-form/{id_type}/create')
            <div class="form-group" >
                <label>{{ __('setup-templateform-crtask.attacment_language') }}</label>
                @if($task->attachment)
                <a href="/task_attachment/{{$task->attachment}}" target="new">
                    <input type="text" class="form-control" value="{{$task->attachment}}" readonly>
                </a>
                <br>
                @endif
                <label>{{ __('setup-templateform-crtask.change-attachment_language') }} @if($task->id_task)<small>{{ __('setup-templateform-crtask.message_language') }}</small>@endif</label>
                <input  name="attachment" type="file" class="form-control " id="subject" aria-describedby="namaHelp" accept="image/*">
            </div>
            @endif
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-5">
            <p class="judul1">{{ __('setup-templateform-crtask.work-time_language') }}</p>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-form">
                        <button id="hide" class="close-icon my-button"></button>
                        <label for="request_start_time">{{ __('setup-templateform-crtask.request-start-time_language') }}</label><br>
                        
                        <input type="date" class="form-control" name="request_start_time" id="request_start_time" required autofocus 
                        @if(old('request_start_time')) value="{{old('request_start_time')}}" @elseif($task_detail->request_start_time) value="{{date('Y-m-d', strtotime($task_detail->request_start_time))}}" @endif
                        >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group margin-form">
                        <button id="hide" class="close-icon my-button"></button>
                        <label for="request_complete_time">{{ __('setup-templateform-crtask.request-completion_language') }}</label><br>
                        
                        <input type="date" class="form-control" name="request_complete_time" required autofocus 
                            @if(old('request_complete_time')) value="{{old('request_complete_time')}}" @elseif($task_detail->request_complete_time) value="{{date('Y-m-d', strtotime($task_detail->request_complete_time))}}" @endif
                        >
                    </div>
                </div>
            </div>
            <div class="form-group margin-form">
                <button id="hide" class="close-icon my-button"></button>
                <label for="subject">{{ __('setup-templateform-crtask.work-day-result_language') }}</label><br>
                
                <input type="text" class="form-control" name="total_hari_kerja" required autofocus 
                    @if(old('total_hari_kerja')) value="{{old('total_hari_kerja')}}" @elseif($task_detail->total_hari_kerja) value="{{$task_detail->total_hari_kerja}}" @endif
                >
            </div>
            <div class="form-group margin-form">
                <button id="hide" class="close-icon my-button"></button>
                <label>{{ __('setup-templateform-crtask.assign-to_language') }}</label><br>
                
                <select class="form-control select2" style="width: 100%;" required autofocus name="id_technician">
                    <option selected="selected" disabled value="">-- {{ __('setup-templateform-crtask.select-technician_language') }} --</option>
                    @foreach(\App\Model\Technician::get() as $tech)
                        <option value="{{$tech->id_technician}}" @if(old('id_technician') == $tech->id_technician || $task->id_technician == $tech->id_technician) selected @endif>{{$tech->name_technician}}</option>
                    @endforeach
                </select>
            </div>
            <p class="judul1 pt-5">{{ __('setup-templateform-crtask.down-time_language') }}</p>
            <div class="row">
                <div class="col-md-6 ">
                    <div class="form-group margin-form">
                        <button id="hide" class="close-icon my-button"></button>
                        <label for="subject">{{ __('setup-templateform-crtask.start-time_language') }}</label><br>
                        
                        <input type="date" class="form-control" name="down_start" id="down_start" required autofocus 
                        @if(old('down_start')) value="{{old('down_start')}}" @elseif($task_detail->down_start) value="{{date('Y-m-d', strtotime($task_detail->down_start))}}" @endif
                        >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group margin-form">
                        <button id="hide" class="close-icon my-button"></button>
                        <label for="subject">{{ __('setup-templateform-crtask.finish-time_language') }}</label><br>
                        
                        <input type="date" class="form-control" name="down_end" id="down_end" required autofocus 
                        @if(old('down_end')) value="{{old('down_end')}}" @elseif($task_detail->down_end) value="{{date('Y-m-d', strtotime($task_detail->down_end))}}" @endif
                        >
                    </div>
                </div>
            </div>
            <div class="form-group margin-form">
                <button id="hide" class="close-icon my-button"></button>
                <label for="subject">{{ __('setup-templateform-crtask.work-time-result_language') }}</label><br>
                
                <input type="text" class="form-control" name="total_waktu_kerja" required autofocus 
                    @if(old('total_waktu_kerja')) value="{{old('total_waktu_kerja')}}" @elseif($task_detail->total_waktu_kerja) value="{{$task_detail->total_waktu_kerja}}" @endif
                >
            </div>
        </div>
    </div>
</div>


<script>
    $('.select2').select2();
    $(document).ready(function(){
        @if($task->id_category)
            $('.select_category').val({{$task->id_category}}).trigger('change');
        @endif
    });
    
    $(document).ready(function(){
    $(this).on("click","#hide", function(){
        var target_input = $(this).parent();
        target_input.remove();
    });
    });
</script>
