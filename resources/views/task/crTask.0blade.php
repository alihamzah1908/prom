
<div class="card-body">
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label>Category</label>
                <select class="form-control select2 select_category"  style="width: 100%;" required autofocus name="id_category">
                    <option selected="selected" disabled value="">-- Select Category --</option>
                    @foreach(\App\Model\Category::get() as $cat)
                        <option value="{{$cat->id_category}}">{{$cat->category_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Region</label>
                <select class="form-control select2" style="width: 100%;" required autofocus name="id_region">
                    <option selected="selected" disabled value="">-- Select Region --</option>
                    @foreach(\App\Model\Region::get() as $region)
                        <option value="{{$region->region_id}}" @if(old('id_region') == $region->region_id || $task->id_region == $region->region_id) selected @endif>{{$region->region_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Location A</label>
                <select class="form-control select2" style="width: 100%;" required autofocus name="id_location_a">
                    <option selected="selected" disabled value="">-- Select Location --</option>
                    @foreach(\App\Model\Segment::get() as $segment)
                        <option value="{{$segment->id_segment}}" @if(old('id_location_a') == $segment->id_segment || $task->id_location_a == $segment->id_segment) selected @endif>{{$segment->segment_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required autofocus 
                @if(old('subject')) value="{{old('subject')}}" @elseif($task->subject) value="{{$task->subject}}" @endif>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid invalid @enderror" id="description" rows="4" placeholder="Description" required autofocus>@if(old('description')){{old('description')}}@elseif($task->description){{$task->description}}@endif</textarea>
            </div>
            @if(request()->path() == '/setup/template-form/{id_type}/create')
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
            @endif
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-5">
            <p class="judul1">Work time</p>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="request_start_time">Request Start Time</label>
                        <input type="date" class="form-control" name="request_start_time" id="request_start_time" required autofocus 
                        @if(old('request_start_time')) value="{{old('request_start_time')}}" @elseif($task_detail->request_start_time) value="{{date('Y-m-d', strtotime($task_detail->request_start_time))}}" @endif
                        >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="request_complete_time">Request Completion</label>
                        <input type="date" class="form-control" name="request_complete_time" required autofocus 
                            @if(old('request_complete_time')) value="{{old('request_complete_time')}}" @elseif($task_detail->request_complete_time) value="{{date('Y-m-d', strtotime($task_detail->request_complete_time))}}" @endif
                        >
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="subject">Total hari pekerjaan</label>
                <input type="text" class="form-control" name="total_hari_kerja" required autofocus 
                    @if(old('total_hari_kerja')) value="{{old('total_hari_kerja')}}" @elseif($task_detail->total_hari_kerja) value="{{$task_detail->total_hari_kerja}}" @endif
                >
            </div>
            <div class="form-group">
                <label>Assign To</label>
                <select class="form-control select2" style="width: 100%;" required autofocus name="id_technician">
                    <option selected="selected" disabled value="">-- Select Assign To --</option>
                    @foreach(\App\Model\Technician::get() as $tech)
                        <option value="{{$tech->id_technician}}" @if(old('id_technician') == $tech->id_technician || $task->id_technician == $tech->id_technician) selected @endif>{{$tech->name_technician}}</option>
                    @endforeach
                </select>
            </div>
            <p class="judul1 pt-5">Down Time</p>
            <div class="row">
                <div class="col-md-6 ">
                    <div class="form-group">
                        <label for="subject">Waktu Mulai</label>
                        <input type="date" class="form-control" name="down_start" id="down_start" required autofocus 
                        @if(old('down_start')) value="{{old('down_start')}}" @elseif($task_detail->down_start) value="{{date('Y-m-d', strtotime($task_detail->down_start))}}" @endif
                        >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="subject">Waktu Selesai</label>
                        <input type="date" class="form-control" name="down_end" id="down_end" required autofocus 
                        @if(old('down_end')) value="{{old('down_end')}}" @elseif($task_detail->down_end) value="{{date('Y-m-d', strtotime($task_detail->down_end))}}" @endif
                        >
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="subject">Total Waktu Kerja</label>
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
    
</script>
