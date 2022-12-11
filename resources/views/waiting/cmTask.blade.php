
<div class="card-body" style="border-bottom: 1px solid rgba(0, 0, 0, .125);">
    <div class="row">
        <div class="col-md-5">
            <p class="judul1">Site Information</p>
        </div>
        <div class="col-md-7"></div>
    </div>
</div>
<div class="card-body" style="border-bottom: 1px solid rgba(0, 0, 0, .125);">
    <div class="row">
        <div class="col-md-5">
             <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" disabled 
                @if(old('subject')) value="{{old('subject')}}" @elseif($task->subject) value="{{$task->subject}}" @endif>
            </div>
            <div class="form-group">
                <label>Region</label>
                <select class="form-control select2" style="width: 100%;" disabled name="id_region">
                    <option selected="selected" disabled value="">-- Select Region --</option>
                    @foreach(\App\Model\Region::get() as $region)
                        <option value="{{$region->region_id}}" @if(old('id_region') == $region->region_id || $task->id_region == $region->region_id) selected @endif>{{$region->region_name}}</option>
                    @endforeach
                </select>
            </div>
             <div class="form-group">
                <label>Priority</label>
                <select class="form-control select2" style="width: 100%;" disabled name="id_priority">
                    <option selected="selected" disabled value="">-- Select Priority --</option>
                    @foreach(\App\Model\Priority::where('id_task_type', $id_template)->get() as $priority)
                        <option value="{{$priority->id_priority}}" @if(old('id_priority') == $priority->id_priority || $task_detail->id_priority == $priority->id_priority) selected @endif>{{$priority->priority_name}}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label>Location A</label>
                <select class="form-control select2" style="width: 100%;" disabled name="id_location_a">
                    <option selected="selected" disabled value="">-- Select Location --</option>
                    @foreach(\App\Model\Segment::get() as $segment)
                        <option value="{{$segment->id_segment}}" @if(old('id_location_a') == $segment->id_segment || $task->id_location_a == $segment->id_segment) selected @endif>{{$segment->segment_name}}</option>
                    @endforeach
                </select>
            </div>
             <div class="form-group">
                <label>Site A</label>
                <select class="form-control select2" style="width: 100%;" disabled name="id_site_a">
                    <option selected="selected" disabled value="">-- Select Site --</option>
                    @foreach(\App\Model\Site::get() as $site)
                        <option value="{{$site->site_id}}" @if(old('id_site_a') == $site->site_id || $task->id_site_a == $site->site_id) selected @endif>{{$site->name_site}}</option>
                    @endforeach
                </select>
            </div>
            
             <div class="form-group">
                <label>Impact</label>
                <select class="form-control select2" style="width: 100%;" disabled name="id_impact">
                    <option selected="selected" disabled value="">-- Select Impact --</option>
                    @foreach(\App\Model\Impact::where('id_task_type', $id_template)->get() as $impact)
                        <option value="{{$impact->id_impact}}"  @if(old('id_impact') == $impact->id_impact || $task_detail->id_impact == $impact->id_impact) selected @endif >
                            {{$impact->impact_name}}
                        </option>
                    @endforeach
                </select>
            </div>
             <div class="form-group">
                <label for="impact_detail">Impact Detail</label>
                <textarea name="impact_detail" class="form-control @error('impact_detail') is-invalid invalid @enderror" id="impact_detail" rows="4" placeholder="Impact Detail" disabled>@if(old('impact_detail')){{old('impact_detail')}}@elseif($task_detail->impact_detail){{$task_detail->impact_detail}}@endif</textarea>
            </div>
           
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-5">
            
            
            <div class="form-group">
                <label>Group Internal</label>
                <select class="form-control select2" style="width: 100%;" disabled name="id_group_internal">
                    <option selected="selected" disabled value="">-- Select Group Internal --</option>
                    @foreach(\App\Model\GroupInternal::get() as $group)
                        <option value="{{$group->id_group}}" @if(old('id_group_internal') == $group->id_group || $task_detail->id_group_internal == $group->id_group) selected @endif>{{$group->name_group}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Group Customer</label>
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
                <label>Technician</label>
                <select class="form-control select2" style="width: 100%;" disabled name="id_technician">
                    <option selected="selected" disabled value="">-- Select Technician --</option>
                    @foreach(\App\Model\Technician::get() as $tech)
                        <option value="{{$tech->id_technician}}" @if(old('id_technician') == $tech->id_technician || $task->id_technician == $tech->id_technician) selected @endif>{{$tech->name_technician}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Location B</label>
                <select class="form-control select2" style="width: 100%;" disabled name="id_location_b">
                    <option selected="selected" disabled value="">-- Select Location --</option>
                    @foreach(\App\Model\Segment::get() as $segment)
                        <option value="{{$segment->id_segment}}" @if(old('id_location_b') == $segment->id_segment || $task_detail->id_location_b == $segment->id_segment) selected @endif>{{$segment->segment_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Site B</label>
                <select class="form-control select2" style="width: 100%;" disabled name="id_site">
                    <option selected="selected" disabled value="">-- Select Site --</option>
                    @foreach(\App\Model\Site::get() as $site)
                        <option value="{{$site->site_id}}" @if(old('id_site') == $site->site_id || $task->id_site == $site->site_id) selected @endif>{{$site->name_site}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Category</label>
                <select class="form-control select2 select_category" style="width: 100%;" onchange="setSubCategory({{$id_template}}, this.value)" disabled name="id_category">
                    <option selected="selected" disabled value="">-- Select Category --</option>
                    @foreach(\App\Model\Category::get() as $cat)
                        <option value="{{$cat->id_category}}">{{$cat->category_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Sub Category</label>
                <select class="form-control searchSubCat select_sub_category" style="width: 100%;" name="id_sub_category" onchange="setItem({{$id_template}}, this.value)" disabled></select>
            </div>
            <div class="form-group">
                <label>Item</label>
                <select class="form-control searchItem select_item" style="width: 100%;"  name="id_item" disabled></select>
            </div>
            @if($task->id_task)
            <div class="form-group">
                <label>Root Caused</label>
                <select class="form-control select2" style="width: 100%;" name="id_root_caused" disabled>
                    <option selected="selected" value="" disabled>-- Select Root Caused --</option>
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
            <!--    <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" disabled -->
            <!--    @if(old('subject')) value="{{old('subject')}}" @elseif($task->subject) value="{{$task->subject}}" @endif>-->
            <!--</div>-->
            <!--@if(request()->path() == '/setup/template-form/{id_type}/create')-->
            <div class="form-group" >
                <label>Attacment</label>
                @if($task->attachment)
                <a href="/task_attachment/{{$task->attachment}}" target="new">
                    <input type="text" class="form-control" value="{{$task->attachment}}" readonly>
                </a>
                <br>
                @endif
                <label>Change Attachment @if($task->id_task)<small>(Leave Empty to keep attachment as it is)</small>@endif</label>
                <input  name="attachment" type="file" class="form-control " id="subject" aria-describedby="namaHelp" accept="image/*">
            </div>
            <!--@endif-->
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" style="width: 100%;" class="form-control @error('description') is-invalid invalid @enderror" id="description" rows="6" placeholder="Description" disabled>@if(old('description')){{old('description')}}@elseif($task->description){{$task->description}}@endif</textarea>
            </div>
        </div>
    </div>
</div>
<div class="card-body" style="border-bottom: 1px solid rgba(0, 0, 0, .125);">
    <div class="row">
        <div class="col-md-5">
            <p class="judul1">CIR</p>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-5"></div>
    </div>
    <div class="row">
        <div class="card col-md-12">
            <div class="card-body">
                 @if($task->task_doc_cir)
               <a href="/task_attachment/{{$task->task_doc_cir}}" target="new">
                    <input type="text" class="form-control" value="{{$task->task_doc_cir}}" accept="image/*" readonly>
                </a>
                <br>
                @endif
                <!--<label>Change Attachment @if($task->id_task)<small>(Leave Empty to keep CIR as it is)</small>@endif</label>-->
                <!--<input  name="attachment" type="file" class="form-control " id="subject" aria-describedby="namaHelp" accept="image/*">-->
            </div>
        </div>
    </div>
</div>
<div class="card-body" style="border-bottom: 1px solid rgba(0, 0, 0, .125);">
    <div class="row">
        <div class="col-md-5">
            <p class="judul1">Images</p>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-5"></div>
    </div>
    <div class="row">
        <div class="card col-md-12">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table" width="100%">
                            <thead>
                                <tr>
                                    <th>Before</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $image_before = getTaskImages($task->id_task, 'BEFORE');
                                ?>
                                @forelse($image_before as $b)
                                <tr>
                                    <td>
                                        <a href="/task_report/{{$b->image}}" target="new">
                                            <img src="/task_report/{{$b->image}}" width="150px">
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table" width="100%">
                            <thead>
                                <tr>
                                    <th>After</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $image_after = getTaskImages($task->id_task, 'AFTER');
                                ?>
                                @forelse($image_after as $a)
                                <tr>
                                    <td>
                                        <a href="/task_report/{{$a->image}}" target="new">
                                            <img src="/task_report/{{$a->image}}" width="150px">
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card-body" style="border-bottom: 1px solid rgba(0, 0, 0, .125);">
    <div class="row">
        <div class="col-md-5">
            <p class="judul1">Images</p>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-5"></div>
    </div>
    <div class="row">
        <div class="card col-md-12">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table" width="100%">
                            <thead>
                                <tr>
                                    <th>Before</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $image_before = getTaskImages($task->id_task, 'BEFORE');
                                ?>
                                @forelse($image_before as $b)
                                <tr>
                                    <td>
                                        <a href="/task_report/{{$b->image}}" target="new">
                                            <img src="/task_report/{{$b->image}}" width="150px">
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table" width="100%">
                            <thead>
                                <tr>
                                    <th>After</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $image_after = getTaskImages($task->id_task, 'AFTER');
                                ?>
                                @forelse($image_after as $a)
                                <tr>
                                    <td>
                                        <a href="/task_report/{{$a->image}}" target="new">
                                            <img src="/task_report/{{$a->image}}" width="150px">
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
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
    $('.select2').select2();
    $('.select2-multiple').select2({
        placeholder: "Select"
    });
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
</script>
