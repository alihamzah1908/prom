<style>
    .display-none{
        display:none;
    }
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
<div class="card-body">
    <div class="buttons">
		<button class="btn-green" onClick="window.location.reload();">
		     {{ __('setup-templateform-plmtask.reset-form_language') }}
		</button>
	</div>
    <div class="row">
        <div class="col-md-5">
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-5">
        </div>
    </div>
    <p class="judul1">{{ __('setup-templateform-plmtask.basic-information_language') }}</p>
    <div class="row">
        <div class="col-md-5">
            <div class="form-group margin-form">
                <button id="hide" class="close-icon my-button"></button>
                <label>{{ __('setup-templateform-plmtask.site-id_language') }}</label>
                <select class="form-control select2" style="width: 100%;" required autofocus name="id_site_a">
                    <option selected="selected" disabled value="">-- {{ __('setup-templateform-plmtask.select-site_language') }} --</option>
                    @foreach(\App\Model\Site::get() as $site)
                        <option value="{{$site->site_id}}" 
                        @if(old('id_site_a') == $site->site_id || $task->id_site_a == $site->site_id) selected @endif
                        >
                            {{$site->name_site}}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group margin-form">
                <button id="hide" class="close-icon my-button"></button>
                <label>{{ __('setup-templateform-plmtask.task-category_language') }}</label>
                <select class="form-control select2 select_category" style="width: 100%;" onchange="setSubCategory({{$id_template}}, this.value)" required autofocus name="id_category">
                    <option selected="selected" disabled value="">-- {{ __('setup-templateform-plmtask.select-category_language') }} --</option>
                    @foreach(\App\Model\Category::where('id_task_type', $id_template)->get() as $cat)
                        <option value="{{$cat->id_category}}">{{$cat->category_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group margin-form">
                <button id="hide" class="close-icon my-button"></button>
                <label>{{ __('setup-templateform-plmtask.task-sub-category_language') }}</label>
                <select class="form-control searchSubCat select_sub_category" style="width: 100%;" name="id_sub_category" required autofocus></select>
            </div>
            <div class="form-group margin-form">
                <button id="hide" class="close-icon my-button"></button>
                <label for="request_complete_time">{{ __('setup-templateform-plmtask.request-completion_language') }}</label>
                <input type="date" class="form-control" name="request_complete_time" required autofocus 
                    @if(old('request_complete_time')) value="{{old('request_complete_time')}}" @elseif($task_detail->request_complete_time) value="{{date('Y-m-d', strtotime($task_detail->request_complete_time))}}" @endif
                >
            </div>
            <div class="form-group margin-form">
                <button id="hide" class="close-icon my-button"></button>
                <label for="request_start_time">{{ __('setup-templateform-plmtask.request-start-time_language') }}</label>
                <input type="date" class="form-control" name="request_start_time" id="request_start_time" required autofocus
                 @if(old('request_start_time')) value="{{old('request_start_time')}}" @elseif($task_detail->request_start_time) value="{{date('Y-m-d', strtotime($task_detail->request_start_time))}}" @endif
                >
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-5">
            <div class="form-group margin-form">
                <button id="hide" class="close-icon my-button"></button>
                <label>{{ __('setup-templateform-plmtask.title_language') }}</label>
                <input type="text" class="form-control" name="subject" id="subject" placeholder="{{ __('setup-templateform-plmtask.subject_language') }}" required autofocus 
                @if(old('subject')) value="{{old('subject')}}" @elseif($task->subject) value="{{$task->subject}}" @endif
                >
            </div>
            <div class="form-group margin-form">
                <button id="hide" class="close-icon my-button"></button>
                <label for="description">{{ __('setup-templateform-plmtask.description_language') }}</label>
                <textarea name="description" class="form-control @error('description') is-invalid invalid @enderror" id="description" rows="4" placeholder="{{ __('setup-templateform-plmtask.description2_language') }}" required autofocus>@if(old('description')){{old('description')}}@elseif($task->description){{$task->description}}@endif</textarea>
            </div>
            <div class="form-group margin-form">
                <button id="hide" class="close-icon my-button"></button>
                <label>{{ __('setup-templateform-plmtask.technician_language') }}</label>
                <select class="form-control select2" style="width: 100%;" required autofocus name="id_technician">
                    <option selected="selected" disabled value="">-- {{ __('setup-templateform-plmtask.select-technician_language') }} --</option>
                    @foreach(\App\Model\Technician::get() as $tech)
                        <option value="{{$tech->id_technician}}" @if(old('id_technician') == $tech->id_technician || $task->id_technician == $tech->id_technician) selected @endif>{{$tech->name_technician}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <p class="judul1">{{ __('setup-templateform-plmtask.site-information_language') }}</p>
    <div class="row">
        <div class="col-md-5">
            <div class="form-group margin-form">
                <button id="hide" class="close-icon my-button"></button>
                <label for="site_name">{{ __('setup-templateform-plmtask.site-name_language') }}</label>
                <input type="text" class="form-control" name="site_name" id="site_name" placeholder="Site Name" readonly required autofocus
                @if(old('site_name')) value="{{old('site_name')}}" @elseif($task->getSite) value="{{isset($task->getSite)?$task->getSite->name_site:'-'}}" @endif
                >
            </div>
            <div class="form-group margin-form">
                <button id="hide" class="close-icon my-button"></button>
                <label for="site_address">{{ __('setup-templateform-plmtask.site-address_language') }}</label>
                <textarea name="site_address" class="form-control" id="site_address" readonly required autofocus rows="4" placeholder="Site Address">@if(old('site_address')){{old('site_address')}}@elseif($task->getSite){{isset($task->getSite)?$task->getSite->address:'-'}}@endif</textarea>
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-5">
            <div class="form-group margin-form">
                <button id="hide" class="close-icon my-button"></button>
                <label for="region_manager">{{ __('setup-templateform-plmtask.region-manager_language') }}</label>
                <input type="text" class="form-control" name="region_manager" id="region_manager" placeholder="region_manager" readonly required autofocus
                @if(old('region_manager')) value="{{old('region_manager')}}" @elseif($task->getSite) value="{{isset($task->getSite->manager)?$task->getSite->manager->name:'-'}}" @endif
                >
            </div>
            <div class="form-group margin-form">
                <button id="hide" class="close-icon my-button"></button>
                <label for="manager_phone_no">{{ __('setup-templateform-plmtask.manager-phone-no_language') }}</label>
                <input type="number" class="form-control" name="manager_phone_no" id="manager_phone_no" placeholder="manager_phone_no" readonly required autofocus
                @if(old('manager_phone_no')) value="{{old('manager_phone_no')}}" @elseif($task->getSite) value="{{isset($task->getSite->manager)?$task->getSite->manager->telpone:'-'}}" @endif
                >
            </div>
            <div class="form-group margin-form">
                <button id="hide" class="close-icon my-button"></button>
                <label>{{ __('setup-templateform-plmtask.region_language') }}</label>
                <input type="text" class="form-control" name="site_id_region" id="site_id_region" placeholder="site_id_region" readonly required autofocus
                @if(old('site_id_region')) value="{{old('site_id_region')}}" @elseif($task->getSite) value="{{isset($task->getSite->region)?$task->getSite->region->region_name:'-'}}" @endif
                >
                <input hidden id="id_region" name="id_region"
                @if(old('id_region')) value="{{old('id_region')}}" @elseif($task->getSite) value="{{isset($task->getSite)?$task->getSite->id_region:'-'}}" @endif
                >
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
        
    });
</script>
<script>
    $('.select2').select2();
    function setSubCategory(id_type, id_category){
        $(".searchSubCat").select2({
            placeholder: "{{ __('setup-templateform-plmtask.select-sub-category_language') }}",
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
    
    $(document).ready(function(){
        $(document).on('change', 'select[name=id_site_a]', function(e){
            e.preventDefault();
            var ini = $(this);
                id = ini.val();
            $.ajax({
                url: '/setup/servicedesk/site/getSite',
                type: "get",
                data: {
                        id: id
                      }
            })
            .done(function (result) {
                if(result.data[0]){
                    var data = result.data[0];
                        $('#site_name').val(data.name_site);
                        $('#site_address').val(data.address);
                        $('#region_manager').val(data.manager.name);
                        $('#manager_phone_no').val(data.manager.telpone);
                        $('#site_id_region').val(data.region.region_name);
                        $('#id_region').val(data.region.id_region);
                        
                }else{
                    var message = result.message || 'Not found!';
                    failedAlert(message);
                }
            })
            .fail(ajax_fail);
        })
        $('select[name=id_site_a]').trigger('change');
    });
    
    $(document).ready(function(){
    $(this).on("click","#hide", function(){
        var target_input = $(this).parent();
        target_input.remove();
    });
    });
</script>