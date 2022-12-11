<div class="card-body">
    <div class="row">
        <div class="col-md-5">
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-5">
            <div class="form-group" style="margin-bottom: 0;">
                <label>Checklist</label>
            </div>
            <div class="row">
                @foreach(\App\Model\ChecklistPeriode::get() as $per)
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" required autofocus name="checklist_periode" value="{{$per->id_periode}}" disabled
                            @if(old('checklist_periode') == $per->id_periode || $task_detail->checklist_periode == $per->id_periode) checked @endif>
                            <label class="form-check-label text_name">{{$per->periode_name}}</label>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="col-sm-12">
                    <select class="form-control select2" style="width: 100%;" name="id_checklist_category" disabled>
                        <option selected="selected" disabled value="">-- Select Checklist Category --</option>
                        @foreach(\App\Model\ChecklistCategory::get() as $cat)
                            <option value="{{$cat->id_category}}" 
                            @if(old('id_checklist_category') == $cat->id_category || $task_detail->id_checklist_category == $cat->id_category) selected @endif
                            >
                                {{$cat->category_name}}
                            </option>
                        @endforeach
                    </select>
                </div>
                
            </div>
        </div>
    </div>
    <p class="judul1">Basic Information</p>
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label>Site ID</label>
                <select class="form-control select2" style="width: 100%;" disabled name="id_site_a">
                    <option selected="selected" disabled value="">-- Select Site --</option>
                    @foreach(\App\Model\Site::get() as $site)
                        <option value="{{$site->site_id}}" 
                        @if(old('id_site') == $site->site_id || $task->id_site_a == $site->site_id) selected @endif
                        >
                            {{$site->name_site}}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Task Category</label>
                <select class="form-control select2 select_category" style="width: 100%;" onchange="setSubCategory({{$id_template}}, this.value)" disabled name="id_category">
                    <option selected="selected" disabled value="">-- Select Category --</option>
                    @foreach(\App\Model\Category::where('id_task_type', $id_template)->get() as $cat)
                        <option value="{{$cat->id_category}}">{{$cat->category_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Task Sub Category</label>
                <select class="form-control searchSubCat select_sub_category" style="width: 100%;" name="id_sub_category" disabled></select>
            </div>
            <div class="form-group">
                <label for="request_start_time">Request Start Time</label>
                <input type="date" class="form-control" name="request_start_time" id="request_start_time" disabled 
                 @if(old('request_start_time')) value="{{old('request_start_time')}}" @elseif($task_detail->request_start_time) value="{{date('Y-m-d', strtotime($task_detail->request_start_time))}}"  @endif
                >
            </div>
            <div class="form-group">
                <label for="request_complete_time">Request Completion</label>
                <input type="date" class="form-control" name="request_complete_time" disabled 
                    @if(old('request_complete_time')) value="{{old('request_complete_time')}}" @elseif($task_detail->request_complete_time) value="{{date('Y-m-d', strtotime($task_detail->request_complete_time))}}" @endif
                >
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-5">
            <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" disabled 
                @if(old('subject')) value="{{old('subject')}}" @elseif($task->subject) value="{{$task->subject}}" @endif
                >
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid invalid @enderror" id="description" rows="4" placeholder="Description" disabled>@if(old('description')){{old('description')}}@elseif($task->description){{$task->description}}@endif</textarea>
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
        </div>
    </div>
    <p class="judul1">Site Information</p>
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label for="site_name">Site Name</label>
                <input type="text" class="form-control" name="site_name" id="site_name" placeholder="Site Name" readonly 
                @if(old('site_name')) value="{{old('site_name')}}" @elseif($task->getSite) value="{{isset($task->getSite)?$task->getSite->name_site:'-'}}" @endif
                >
            </div>
            <div class="form-group">
                <label for="site_address">Site Address</label>
                <textarea name="site_address" class="form-control" id="site_address" readonly rows="4" placeholder="Site Address">@if(old('site_address')){{old('site_address')}}@elseif($task->getSite){{isset($task->getSite)?$task->getSite->address:'-'}}@endif</textarea>
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-5">
            <div class="form-group">
                <label for="region_manager">Region Manager</label>
                <input type="text" class="form-control" name="region_manager" id="region_manager" placeholder="region_manager" readonly
                @if(old('region_manager')) value="{{old('region_manager')}}" @elseif($task->getSite) value="{{isset($task->getSite->manager)?$task->getSite->manager->name:'-'}}" @endif
                >
            </div>
            <div class="form-group">
                <label for="manager_phone_no">Manager Phone No</label>
                <input type="number" class="form-control" name="manager_phone_no" id="manager_phone_no" placeholder="manager_phone_no" readonly
                @if(old('manager_phone_no')) value="{{old('manager_phone_no')}}" @elseif($task->getSite) value="{{isset($task->getSite->manager)?$task->getSite->manager->telpone:'-'}}" @endif
                >
            </div>
            <div class="form-group">
                <label>Region</label>
                <input type="text" class="form-control" name="site_id_region" id="site_id_region" placeholder="site_id_region" readonly
                @if(old('site_id_region')) value="{{old('site_id_region')}}" @elseif($task->getSite) value="{{isset($task->getSite->region)?$task->getSite->region->region_name:'-'}}" @endif
                >
                <input hidden id="id_region" name="id_region"
                @if(old('id_region')) value="{{old('id_region')}}" @elseif($task->id_region) value="{{$task->id_region}}" @endif
                >
            </div>
        </div>
    </div>
    
    <br>
    <hr>
    <?php 
    $is_images = true;
    if($task_detail->checklist_periode == 1){
        $is_images = false;
    }elseif($task_detail->checklist_periode == 2){
        $is_images = false;
    }else{
        $is_images = true;
    }
    ?>
    @if($is_images)
    <p class="judul1">Images</p>
    <div class="card">
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
    @else
    <p class="judul1">Checklists</p>
    <div class="card">
        <div class="card-body">
        <table class="table" id="table_checklist" width="100%">
            <thead>
                <tr>
                    <th style="width: 52px">ID</th>
                    <th>Checklist</th>
                    <th>Is_Available</th>
                    <th>Answer</th>
                    <th>Image</th>
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
                    <td>{{$a->checklist_name}}</td>
                    <td>{{$a->is_avaiable}}</td>
                    <td>{{$a->answer}}</td>
                    <td>
                         @if(is_array($a->image))
                    
                     @foreach($a->image as $img => $val)
                    
                    <a href="/checklist_image/{{$val}}" target="new">
                        <img src="/checklist_image/{{$val}}" width="120px" height="150px">
                    </a>
                     @endforeach
                    
                  
                    @else 

                        <!--  @if(empty($a->image))
                   
                         <a href="/checklist_image/default.png" target="new">
                        <img src="/checklist_image/default.png" width="120px" height="150px">
                            </a>

                            @else -->
                      
                             <a href="/checklist_image/{{isset($a->image)?$a->image : ""  }}" target="new">
                        <img src="/checklist_image/{{isset($a->image)?$a->image : ""}}" width="150px">
                    </a>
                          @endif
                     
                     @endif
                    </td>
                </tr>
                @empty
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
    @endif
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
        
        $('#table_checklist').DataTable()
    });
</script>
<script>
    $('.select2').select2();
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
    
    $(document).ready(function(){
        $(document).on('change', 'select[name=id_site]', function(e){
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
                        $('#inp_id_region').val(data.region.region_name);
                        
                }else{
                    var message = result.message || 'Not found!';
                    failedAlert(message);
                }
            })
            .fail(ajax_fail);
        }) 
    });
</script>