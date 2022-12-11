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
    <div class="row">
        <div class="col-md-5">
            <p class="judul1">{{ __('setup-templateform-cmtask.site-information_language') }}</p>
        </div>
        <div class="col-md-7"></div>
    </div>
    <div class="buttons">
		<button class="btn-green" onClick="window.location.reload();">
			{{ __('setup-templateform-cmtask.reset-form_language') }}
		</button>
</div>
</div>

<div class="card-body" style="padding-top: 30px;">
    <div class="row">
        <div class="col-md-5">
             <div class="form-group">
                <button id="hide" class="close-icon my-button"></button>
                <label for="subject">{{ __('setup-templateform-cmtask.subject_language') }}</label>
                <input type="text" class="form-control" name="subject" id="subject" placeholder="{{ __('setup-templateform-cmtask.subject2_language') }}" required autofocus 
                @if(old('subject')) value="{{old('subject')}}" @elseif($task->subject) value="{{$task->subject}}" @endif>
            </div>
            <!--region-->
            <div class="form-group">
                <button id="hide" class="close-icon my-button"></button>
                <label>{{ __('setup-templateform-cmtask.region_language') }}</label>
                <select class="form-control select2 select_region" style="width: 100%;" required autofocus name="id_region">
                    <option selected="selected" disabled value="">-- {{ __('setup-templateform-cmtask.select-region_language') }} --</option>
                    @foreach(\App\Model\Region::get() as $region)
                        <option value="{{$region->region_id}}" @if(old('id_region') == $region->region_id || $task->id_region == $region->region_id) selected @endif>{{$region->region_name}}</option>
                    @endforeach
                </select>
            </div>
             <div class="form-group">
                <button id="hide" class="close-icon my-button"></button>
                <label>{{ __('setup-templateform-cmtask.priority_language') }}</label>
                <select class="form-control select2" style="width: 100%;" required autofocus name="id_priority">
                    <option selected="selected" disabled value="">-- {{ __('setup-templateform-cmtask.select-priority_language') }} --</option>
                    @foreach(\App\Model\Priority::where('id_task_type', $id_template)->get() as $priority)
                        <option value="{{$priority->id_priority}}" @if(old('id_priority') == $priority->id_priority || $task_detail->id_priority == $priority->id_priority) selected @endif>{{$priority->priority_name}}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <button id="hide" class="close-icon my-button"></button>
                <label>{{ __('setup-templateform-cmtask.location-a_language') }}</label>
                <select class="form-control select2" style="width: 100%;" required autofocus name="id_location_a">
                    <option selected="selected" disabled value="">-- {{ __('setup-templateform-cmtask.select-location_language') }} --</option>
                    @foreach(\App\Model\Segment::get() as $segment)
                        <option value="{{$segment->id_segment}}" @if(old('id_location_a') == $segment->id_segment || $task->id_location_a == $segment->id_segment) selected @endif>{{$segment->segment_name}}</option>
                    @endforeach
                </select>
            </div>
            <!--site a-->
            <div class="form-group">
                <button id="hide" class="close-icon my-button"></button>
                <label>{{ __('setup-templateform-cmtask.site-a_language') }}</label>
                <select class="form-control select2 select_site_a" style="width: 100%;" required autofocus name="id_site_a"></select>
            </div>
            
             <div class="form-group">
                <button id="hide" class="close-icon my-button"></button>
                <label>{{ __('setup-templateform-cmtask.impact_language') }}</label>
                <select class="form-control select2" style="width: 100%;" required autofocus name="id_impact">
                    <option selected="selected" disabled value="">-- {{ __('setup-templateform-cmtask.select-impact_language') }} --</option>
                    @foreach(\App\Model\Impact::where('id_task_type', $id_template)->get() as $impact)
                        <option value="{{$impact->id_impact}}"  @if(old('id_impact') == $impact->id_impact || $task_detail->id_impact == $impact->id_impact) selected @endif >
                            {{$impact->impact_name}}
                        </option>
                    @endforeach
                </select>
            </div>
             <div class="form-group">
                <button id="hide" class="close-icon my-button"></button>
                <label for="impact_detail">{{ __('setup-templateform-cmtask.impact-detail_language') }}</label>
                <textarea name="impact_detail" class="form-control @error('impact_detail') is-invalid invalid @enderror" id="impact_detail" rows="4" placeholder="{{ __('setup-templateform-cmtask.impact-detail2_language') }}" required autofocus>@if(old('impact_detail')){{old('impact_detail')}}@elseif($task_detail->impact_detail){{$task_detail->impact_detail}}@endif</textarea>
            </div>
           
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-5">
            <div class="form-group">
                <button id="hide" class="close-icon my-button"></button>
                <label>{{ __('setup-templateform-cmtask.group-internal_language') }}</label>
                <select class="form-control select2" style="width: 100%;" required autofocus name="id_group_internal">
                    <option selected="selected" disabled value="">-- {{ __('setup-templateform-cmtask.select-group-internal_language') }} --</option>
                    @foreach(\App\Model\GroupInternal::get() as $group)
                        <option value="{{$group->id_group}}" @if(old('id_group_internal') == $group->id_group || $task_detail->id_group_internal == $group->id_group) selected @endif>{{$group->name_group}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button id="hide" class="close-icon my-button"></button>
                <label>{{ __('setup-templateform-cmtask.group-customer_language') }}</label>
                <?php 
                $id_group_customer = [];
                if($task_detail->id_group_customer){
                    $id_group_customer = json_decode($task_detail->id_group_customer);
                }
                if(old('id_group_customer')){
                    $id_group_customer = old('id_group_customer');
                }
                if(!is_array($id_group_customer)){
                    $id_group_customer = [];
                }
                ?>
                <select class="form-control select2-multiple" style="width: 100%;" required autofocus name="id_group_customer[]" multiple>
                    <!--<option selected="selected" disabled value="">-- Select Group Customer --</option>-->
                    <!--if(old('id_group_customer') == $g_customer->id_group || $task_detail->id_group_customer == $g_customer->id_group) -->
                    @foreach(\App\Model\GroupCustomer::get() as $g_customer)
                        <option value="{{$g_customer->id_group}}" 
                            @if(in_array($g_customer->id_group , $id_group_customer))
                                selected 
                            @endif
                        >{{$g_customer->group_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button id="hide" class="close-icon my-button"></button>
                <label>{{ __('setup-templateform-cmtask.assign-to_language') }}</label>
                <select class="form-control select2" style="width: 100%;" required autofocus name="id_technician">
                    <option selected="selected" disabled value="">-- {{ __('setup-templateform-cmtask.select-assign-to_language') }} --</option>
                    @foreach(\App\Model\Technician::get() as $tech)
                        <option value="{{$tech->id_technician}}" @if(old('id_technician') == $tech->id_technician || $task->id_technician == $tech->id_technician) selected @endif>{{$tech->name_technician}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button id="hide" class="close-icon my-button"></button>
                <label>{{ __('setup-templateform-cmtask.location-b_language') }}</label>
                <select class="form-control select2" style="width: 100%;" required autofocus name="id_location_b">
                    <option selected="selected" disabled value="">-- {{ __('setup-templateform-cmtask.select-location2_language') }} --</option>
                    @foreach(\App\Model\Segment::get() as $segment)
                        <option value="{{$segment->id_segment}}" @if(old('id_location_b') == $segment->id_segment || $task_detail->id_location_b == $segment->id_segment) selected @endif>{{$segment->segment_name}}</option>
                    @endforeach
                </select>
            </div>
            <!--site_b-->
            <div class="form-group">
                <button id="hide" class="close-icon my-button"></button>
                <label>{{ __('setup-templateform-cmtask.site-b_language') }}</label>
                <select class="form-control select2 select_site_b" style="width: 100%;" required autofocus name="id_site_b"></select>
            </div>
            <div class="form-group">
                <button id="hide" class="close-icon my-button"></button>
                <label>{{ __('setup-templateform-cmtask.category_language') }}</label>
                <select class="form-control select2 select_category" style="width: 100%;" onchange="setSubCategory({{$id_template}}, this.value)" required autofocus name="id_category">
                    <option selected="selected" disabled value="">-- {{ __('setup-templateform-cmtask.select-category_language') }} --</option>
                    @foreach(\App\Model\Category::get() as $cat)
                        <option value="{{$cat->id_category}}">{{$cat->category_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button id="hide" class="close-icon my-button"></button>
                <label>{{ __('setup-templateform-cmtask.sub-category_language') }}</label>
                <select class="form-control searchSubCat select_sub_category" style="width: 100%;" name="id_sub_category" onchange="setItem({{$id_template}}, this.value)" required autofocus></select>
            </div>
            <div class="form-group">
                <button id="hide" class="close-icon my-button"></button>
                <label>{{ __('setup-templateform-cmtask.item_language') }}</label>
                <select class="form-control searchItem select_item" style="width: 100%;"  name="id_item" required autofocus></select>
            </div>
            @if($task->id_task)
            <div class="form-group">
                <button id="hide" class="close-icon my-button"></button>
                <label>{{ __('setup-templateform-cmtask.root-caused_language') }}</label>
                <select class="form-control select2" style="width: 100%;" name="id_root_caused" required autofocus>
                    <option selected="selected" value="" disabled>-- {{ __('setup-templateform-cmtask.select-root-caused_language') }} --</option>
                    @foreach(\App\Model\RootCaused::get() as $root)
                        <option value="{{$root->id_caused}}" @if(old('id_root_caused') == $root->id_caused || $task_detail->id_root_caused == $root->id_caused) selected @endif>{{$root->name_caused}}</option>
                    @endforeach
                </select>
            </div>
            @endif
        </div>
    </div>
</div>
<div class="card-body" style="border-bottom: 1px solid rgba(0, 0, 0, .125);">
    <div class="row">
        <div class="col-md-5">
            <!--<div class="form-group">-->
            <!--    <label for="subject">Subject</label>-->
            <!--    <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required autofocus -->
            <!--    @if(old('subject')) value="{{old('subject')}}" @elseif($task->subject) value="{{$task->subject}}" @endif>-->
            <!--</div>-->
            @if(request()->path() == 'task/create' || request()->path() == "task/detail/$task->id_task")
            <div class="form-group">
                <button id="hide" class="close-icon my-button"></button>
                <label>{{ __('setup-templateform-cmtask.attacment_language') }}</label>
                @if($task->attachment)
                <a href="/task_attachment/{{$task->attachment}}" target="new">
                    <input type="text" class="form-control" value="{{$task->attachment}}" readonly>
                </a>
                <br>
                <label>{{ __('setup-templateform-cmtask.change-attachment_language') }} @if($task->id_task)<small>{{ __('setup-templateform-cmtask.message_language') }}</small>@endif</label>
                @endif
                <input  name="attachment" type="file" class="form-control "  aria-describedby="namaHelp" accept="image/*">
            </div>
            @endif
            
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-12">
            <div class="form-group">
                <button id="hide" class="close-icon my-button"></button>
                <label for="description">{{ __('setup-templateform-cmtask.desc_language') }}</label>
                <textarea name="description" style="width: 100%;" class="form-control @error('description') is-invalid invalid @enderror" id="description" rows="6" placeholder="{{ __('setup-templateform-cmtask.desc2_language') }}" required autofocus>@if(old('description')){{old('description')}}@elseif($task->description){{$task->description}}@endif</textarea>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        @if($task->id_category)
            $('.select_category').val({{$task->id_category}}).trigger('change');
        @endif 
        @if($task->id_sub_category)
        var $newOption = $("<option selected='selected'></option>").val({{$task->id_sub_category}}).text("{{$task->sub_category_name}}")
        $(".select_sub_category").append($newOption).trigger('change');
        @endif
        
        @if($task->id_item)
        var $newOption = $("<option selected='selected'></option>").val({{$task->id_item}}).text("{{$task->item_name}}")
        $(".select_item").append($newOption).trigger('change');
        @endif
    });
</script>
<script>
    <?php 
        $id_site_a = $task->id_site_a;
        if(!$id_site_a){
           $id_site_a = old('id_site_a');
        }
        if(!$id_site_a) $id_site_a = '';
        
        $id_site_b = $task_detail->id_site_b;
        if(!$id_site_b){
           $id_site_b = old('id_site_b'); 
        }
        if(!$id_site_b) $id_site_b = '';
        
        echo ("var id_site_a = '$id_site_a';");
        echo ("var id_site_b = '$id_site_b';");
        
        $name_site_a = \App\Model\Site::where('site_id', $id_site_a)->first();
        $name_site_a  = isset($name_site_a)?$name_site_a->name_site:'';
        
        $name_site_b = \App\Model\Site::where('site_id', $id_site_b)->first();
        $name_site_b  = isset($name_site_b)?$name_site_b->name_site:'';
        
        echo ("var name_site_a = '$name_site_a';");
        echo ("var name_site_b = '$name_site_b';");
        
        $id_region = $task->id_region;
        if(!$id_region){
           $id_region = old('id_region'); 
        }
        if(!$id_region) $id_region = '';
        echo ("var id_region = '$id_region';");
    ?>
    $('.select2').select2();
    $('.select2-multiple').select2({
        placeholder: "Select"
    });
    
    $(document).on('change', '.select_region', function(e){
        e.preventDefault();
        id = $(this).val();
        setSelectSite(id);
    })
    
    setSelectSite(id_region);
    setSelectSiteB(id_region);
    
    function setSelectSite(id_region){
        $(".select_site_a").val('');
        $(".select_site_a").select2({
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
        
        if($('.select_region').val() === id_region){
            if(id_site_a){
                var $newOption = $("<option selected='selected'></option>").val(id_site_a).text(name_site_a);
                $(".select_site_a").append($newOption).trigger('change');
            }
        }
    }    
    function setSelectSiteB(id_region){
        $(".select_site_b").val('');
        $(".select_site_b").select2({
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
        
        if($('.select_region').val() === id_region){
            if(id_site_b){
            var $newOption = $("<option selected='selected'></option>").val(id_site_b).text(name_site_b);
            $(".select_site_b").append($newOption).trigger('change');
        }
        }
    }    
    function setSubCategory(id_type, id_category){
        $(".searchSubCat").select2({
            placeholder: "Select Sub Category",
            ajax: {
                url: "/setup/Customization/"+id_type+"/getSubCategory",
                dataType: "json",
                data:{
                    id_category: id_category
                },
                delay: 250,
                processResults: function (data) {
                    data = data.data;
                    return {
                        results: $.map(data, function (item) {
                                return {
                                    text: item.sub_category_name,
                                    id: item.id_sub_category
                                };
                        })
                    };
                },
                cache: false
            }
        });
    }
    function setItem(id_type, id_sub_category){
        $(".searchItem").select2({
            placeholder: "Select Item",
            ajax: {
                url: "/setup/Customization/"+id_type+"/getItem",
                dataType: "json",
                data:{
                    id_sub_category: id_sub_category
                },
                delay: 250,
                processResults: function (data) {
                    data = data.data;
                    return {
                        results: $.map(data, function (item) {
                                return {
                                    text: item.item_name,
                                    id: item.id_item
                                };
                        })
                    };
                },
                cache: false
            }
        });
    }
    
    $(document).ready(function(){
    $(this).on("click","#hide", function(){
        var target_input = $(this).parent();
        target_input.remove();
    });
    });
</script>
