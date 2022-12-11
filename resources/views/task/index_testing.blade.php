@extends('template.default')
@section('title', 'Task')

@section('content')
<br>
@if(date('Y-m-d H:i:s') < date('2021-12-13 00:00:00'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <i class="fas fa-exclamation-triangle mr-2"></i> Welcome to new<strong> Task List</strong> <i>Candidate Release (CR) Version</i>,  with new interface, system, and speed improvement. This feature wil be able in <i>Stable Version</i> by system on 13-12-2021
<!--   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button> -->
</div>
 @else
 <div class="alert alert-success alert-dismissible fade show" role="alert">
  <i class="fas fa-exclamation-triangle mr-2"></i> Welcome to new<strong> Task List</strong> <i>Stable Version</i>,  with new interface, system, and speed improvement.
<!--   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button> -->
</div>
 @endif
@if(Session::has('message') || session('message'))
    @if(Session::has('data') || session('data'))
        <?php $m_data = Session::get('data'); if(session('data')) $m_data = session('data')?>
        <script>
            $(document).ready(function(){
                var message = '<div>' +
                                '<h3 class="card-title">{{Session::get("message")}}!</h3>' +
                                '<div class="row p-4">' +
                                    '<div class="col-md-6 text-left">' + 
                                        '<strong>Task UID</strong>' + 
                                        '<p class="text-muted">{{$m_data->task_uid}}</p>' +
                                        '<hr>' +
                                        '<strong>Subject</strong>' +
                                        '<p class="text-muted">{{$m_data->subject}}</p>' +
                                        '<hr>' +
                                        '<strong>Description</strong>' +
                                        '<p class="text-muted">{{$m_data->description}}</p>' +
                                        '<hr>' +
                                        '<strong>Created At</strong>' +
                                        '<p class="text-muted">{{$m_data->created_at}}</p>' +
                                        '<hr>' +
                                    '</div>' +
                                    '<div class="col-md-6 text-left">' + 
                                        '<strong>Impact Detail</strong>' +
                                        '<p class="text-muted">{{isset($m_data->impact_detail)?$m_data->impact_detail:"-"}}</p>' +
                                        '<hr>' +
                                        '<strong>Subject</strong>' +
                                        '<p class="text-muted">{{isset($m_data->getCategory)?$m_data->getCategory->category_name:"-"}}</p>' +
                                        '<hr>' +
                                        '<strong>Suspect</strong>' +
                                        '<p class="text-muted">-</p>' +
                                        '<hr>' +
                                        '<strong>Update Progress</strong>' +
                                        '<p class="text-muted">-</p>' +
                                        '<hr>' +
                                    '</div>' +
                                '</div>' +
                              '</div>';
                successAlertLarge(message);
            })
        </script>
    @else
        <div class="alert {{Session::get('alert-class')}} alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {{ Session::get('message') }}
        </div>
    @endif
@endif
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-3">
                <h3 class="card-title"> <strong>Task</strong></h3>
            </div>           
        </div>
        <form action="{{route('task.testing')}}" method="get">	
        <div class="row py-1">	
        	<div class="col-md-4">
        		<label>Tipe Task</label>
	        	<select class="form-control @if(request()->id_type) border border-success font-weight-bold text-dark @endif" name="id_type">	
	        		<option value="">--Choose Type Task</option>
	        		@foreach($types as $type)
	        		<option value="{{$type->id_type}}" @if(request()->id_type == $type->id_type) selected @endif>{{$type->type_name}}</option>
	        		@endforeach
	        	</select>	
        	</div>
        	<div class="col-md-4">
        		<label>Regional</label>
	        	<select class="form-control @if(request()->id_region) border border-success font-weight-bold text-dark  @endif" name="id_region">	
	        		<option value="">--Choose Regional Task</option>
	        		@foreach($regions as $region)
	        		<option value="{{$region->region_id}}" @if(request()->id_region == $region->region_id) selected @endif>{{$region->region_name}}</option>
	        		@endforeach
	        	</select>	
        	</div>
        	<div class="col-md-4">
        		<label>Status</label>
	        	<select class="form-control @if(request()->id_status) border border-success font-weight-bold text-dark  @endif" name="id_status">	
	        		<option value="">--Choose Status Task</option>
	        		@foreach($statuses as $status)
	        		<option value="{{$status->id_status}}" @if(request()->id_status == $status->id_status) selected @endif>{{$status->taskType->type_name}} {{$status->status_name}}</option>
	        		@endforeach
	        	</select>	
        	</div>
        </div>
        <div class="row py-1">
        	<div class="col-md-4">
        		<label>Priority</label>
	        	<select class="form-control @if(request()->id_priority) border border-success font-weight-bold text-dark  @endif" name="id_priority">	
	        		<option value="">--Choose Priority Task</option>
	        		@foreach($priorities as $priority)
	        		<option value="{{$priority->id_priority}}" @if(request()->id_priority == $priority->id_priority) selected @endif>{{$priority->taskType->type_name}} {{$priority->priority_name}}</option>
	        		@endforeach
	        	</select>	
        	</div>
        	<div class="col-md-4">
        		<label>Root Caused</label>
	        	<select class="form-control @if(request()->id_root) border border-success font-weight-bold text-dark  @endif" name="id_root">	
	        		<option value="">--Choose Root Caused Task</option>
	        		@foreach($roots as $root)
	        		<option value="{{$root->id_caused}}" @if(request()->id_root == $root->id_caused) selected @endif>{{$root->name_caused}}</option>
	        		@endforeach
	        	</select>	
        	</div>
        	<div class="col-md-2">
        		<label>Site A</label>
	        	<input type="text" name="name_site_a" placeholder="Tidore" class="form-control @if(request()->name_site_a) border border-success font-weight-bold text-dark @endif" value="{{ request()->name_site_a}}">
        	</div>
        	<div class="col-md-2">
        		<label>Site B</label>
	        	<input type="text" name="name_site_b" placeholder="Tidore" class="form-control @if(request()->name_site_b) border border-success font-weight-bold text-dark @endif" value="{{ request()->name_site_b}}">
        	</div>
        </div>
        <div class="row py-1">	
        	<div class="col-md-3">
        		<label>Waktu pembuatan dari</label>
	        	<input type="date" name="created_at_when" value="{{ request()->created_at_when}}" class="form-control @if(request()->created_at_when) border border-success font-weight-bold text-dark @endif">	
        	</div>
        	<div class="col-md-3">
        		<label>sampai</label>
	        	<input type="date" name="created_at_until" value="{{ request()->created_at_until}}" class="form-control @if(request()->created_at_until) border border-success font-weight-bold text-dark @endif">	
        	</div>
        	<div class="col-md-3">
        		<label>Waktu penyelesaian dari</label>
	        	<input type="date" name="completed_at_when" value="{{ request()->completed_at_when}}" class="form-control @if(request()->completed_at_when) border border-success font-weight-bold text-dark @endif">	
        	</div>
        	<div class="col-md-3">
        		<label>sampai</label>
	        	<input type="date" name="completed_at_until" value="{{ request()->completed_at_until}}" class="form-control @if(request()->completed_at_until) border border-success font-weight-bold text-dark @endif">	
        	</div>
        </div>
        <div class="row py-1">
        	<div class="col-md-4">
        		<label>ID TASK</label>
        		<input type="text" name="id_task" placeholder="PM-101010101" class="form-control @if(request()->id_task) border border-success font-weight-bold text-dark @endif" value="{{ request()->id_task}}">
        	</div>
        	<div class="col-md-4">
        		<label>Subject</label>
        		<input type="text" name="subject" placeholder="PM SITE BULANAN" class="form-control @if(request()->subject) border border-success font-weight-bold text-dark @endif" value="{{ request()->subject}}">
        	</div>	
        	<div class="col-md-4">
        		<label>Teknisi</label>
        		<input type="text" name="technician" placeholder="Nama Teknisi" class="form-control @if(request()->technician) border border-success font-weight-bold text-dark @endif" value="{{ request()->technician}}">
        	</div>
	    </div>
        <div class="row py-1">
        	<div class="col-md-4">
	    		<div class="form-group">
			    	<label>Link Task Dari</label>
			    	<input type="text" placeholder="PM-1010101010" value="{{ request()->link_task_from }}" name="link_task_from" class="form-control @if(request()->link_task_from) border border-success font-weight-bold text-dark @endif">
			    </div>
			</div>
			<div class="col-md-4">
			    <div class="form-group">
			    	<label>Link Task Ke</label>
			    	<input type="text" placeholder="PM-1010101010" value="{{ request()->link_task_to }}" name="link_task_to" class="form-control @if(request()->link_task_to) border border-success font-weight-bold text-dark @endif">
			    </div>
			</div>
        	<div class="col-md-2">
        		<label><small>Cari data</small></label><br>
        		<button type="submit" class="btn btn-md btn-success w-100"><i class="fas fa-search"></i></button>	
        	</div>
        </form>
        	<div class="col-md-1">
        		<label><small>Refresh laman</small></label><br>
        		<a href="{{route('task.testing', request()->query())}}" class="btn btn-md btn-secondary w-100"><i class="fas fa-sync"></i></a>	
        	</div>
        	<div class="col-md-1">
        		<label><small>Reset filter</small></label><br>
        		<a href="{{route('task.testing')}}" class="btn btn-md btn-warning w-100"><i class="fas fa-redo"></i></a>	
        	</div>
        </div>
    </div>
    <div class="card-body">
    	<div class="row pb-3">
    		<div class="col-md-3">
        		<div class="btn-group dropup w-100">
					<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    Create Task
					</button>
					<div class="dropdown-menu">
					    @foreach($types as $type)
			        		<a href="{{route('task.create',['id_template' => $type->id_type])}}" class="dropdown-item">Create {{$type->type_name}}</a>
			        	@endforeach
					</div>
				</div>	
        	</div>
        	<div class="col-md-3">
        		<div class="btn-group dropup w-100">
					<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    Create Task Schedule
					</button>
					<div class="dropdown-menu">
			        	<a href="{{route('task.create.schedule',['id_template' => 2])}}" class="dropdown-item">Create PM Task Schedule</a>   	
					</div>
				</div>		
        	</div>
        	<div class="col-md-2">
        		<a href="{{ route('export7days.excel') }}" class="btn btn-info w-100"><i class="fas fa-download mr-2"></i> 7 Days</a>
        	</div>
        	<div class="col-md-1">
        		<a href="{{route('exportlistexcel.excel', request()->query())}}" class="btn btn-info w-100"><i class="fas fa-file-excel"></i></a><br>
        		<label><small><i>*excel data</i></small></label>
        	</div>
        	<div class="col-md-1">
        		<a href="{{route('exportlistpdf.pdf', request()->query())}}" class="btn btn-info w-100"><i class="fas fa-file-pdf"></i></a><br>
        		<label><small><i>*pdf data</i></small></label>
        	</div>
        	<div class="col-md-2">
        		<button class="btn btn-info w-100" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
					Link Task
				</button>
        	</div>
    	</div>
    	<div class="row pb-3">
    		<div class="col-md-12">
				<div class="collapse" id="collapseExample">
			     	<div class="card card-body">
			     		<form action="{{route('task.new.link.task')}}" method="post">
			     			@csrf
					    <div class="row">
					    	<div class="col-md-6">
					    		<div class="form-group">
							    	<label>Link Task Dari</label>
							    	<input type="text" placeholder="empty" value="{{ request()->link_task_from }}" name="id_task_1" class="form-control bg-gray @if(request()->link_task_from) border border-success font-weight-bold text-dark @endif" readonly>
							    </div>
							    @if($link_task_1)
							    Task Found!
							    <table class="table table-sm table-dark">
									  <thead>
									  <tbody>
									    <tr>
									      <th>No</th>
									      <td>{{$link_task_1->id_task}}</td>
									    </tr>
									    <tr>
									      <th>ID</th>
									      <td>{{$link_task_1->task_uid}}</td>
									    </tr>
									    <tr>
									      <th>Subject</th>
									      <td>{{$link_task_1->subject}}</td>
									    </tr>
									    <tr>
									      <th>Teknisi</th>
									      <td>{{$link_task_1->technician->name_technician ?? ''}}</td>
									    </tr>
									    <tr>
									      <th>Dibuat</th>
									      <td>{{$link_task_1->created_at->format('Y-m-d H:i:s')}}</td>
									    </tr>
									  </tbody>
								</table>
							    @else
							    Not Found!
							    @endif

							</div>
							<div class="col-md-6">
							    <div class="form-group">
							    	<label>Link Task Ke</label>
							    	<input type="text" placeholder="empty" value="{{ request()->link_task_to }}" name="id_task_2" class="form-control bg-gray @if(request()->link_task_to) border border-success font-weight-bold text-dark @endif" readonly>
							    </div>
							    @if($link_task_2)
							    Task Found!
							    <table class="table table-sm table-dark">
									  <thead>
									  <tbody>
									    <tr>
									      <th>No</th>
									      <td>{{$link_task_2->id_task}}</td>
									    </tr>
									    <tr>
									      <th>ID</th>
									      <td>{{$link_task_2->task_uid}}</td>
									    </tr>
									    <tr>
									      <th>Subject</th>
									      <td>{{$link_task_2->subject}}</td>
									    </tr>
									    <tr>
									      <th>Teknisi</th>
									      <td>{{$link_task_2->technician->name_technician ?? ''}}</td>
									    </tr>
									    <tr>
									      <th>Dibuat</th>
									      <td>{{$link_task_2->created_at->format('Y-m-d H:i:s')}}</td>
									    </tr>
									  </tbody>
								</table>
							    @else
							    Not Found!
							    @endif
							    
							</div>
					    </div>
					    <div class="row">
					    	@if($link_task_1 && $link_task_2)
					    	<button type="submit" class="btn btn-sm btn-success"   > <i class="fas fa-link mr-2"></i> Link Task Now</button>
					    	@else
					    	<button class="btn btn-sm btn-success"  disabled> <i class="fas fa-link mr-2"></i> Cannot Link Task Now...</button>
					    	@endif
					    </div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<button type="submit" style="margin-bottom: 10px" class="btn btn-danger delete_all" id="deleteButtonSelected">Delete Selected</button>
        <div class="row">
			<div class="table-responsive-xl" style="overflow-x: auto; white-space:nowrap;">	
				<table class="table table-bordered w-100">	
					<thead class="thead-dark">	
							<tr>
								<th width="50px"><input type="checkbox" id="checkAll"></th>
								<th>No</th>
								<th>ID</th>
								<th>Status</th>
								<th>Subjek</th>
								<th>Prioritas</th>
								<th>Site A</th>
								<th>Site B</th>
								<th>Teknisi</th>
								<th>Waktu Dibuat</th>
								<th>Action</th>
							</tr>
					</thead>
					<tbody>	
						@foreach($tasks as $task)
							<tr @if($task->status_read == 1) style=" font-weight: bold;" @endif>
								<td width="50px"><input type="checkbox" name="ids" class="checkBoxClass"></td>	
								<td>{{$task->id_task}}</td>
								<td><a href="{{route('task-detail', $task->id_task)}}" target="_blank" type="submit">{{$task->task_uid}}</a></td>
								<td>{{$task->status->status_name ?? ''}}</td>
								<td>{{$task->subject}}</td>
								<td>{{$task->taskDetail->priority->priority_name ?? ''}}</td>
								<td>{{$task->siteA->name_site ?? ''}}</td>
								<td>{{$task->taskDetail->siteB->name_site ?? ''}}</td>
								<td>{{$task->technician->name_technician ?? ''}}</td>
								<td>{{$task->created_at->format('Y-m-d H:i:s')}}</td>
								<td>
									<!-- <a href="#" class="btn btn-md btn-danger btn-delete-task"><i class="fa fa-trash"></i></a> -->
									<form action="{{route('task.delete', $task->id_task)}}" method="post">
										@csrf
										@method('delete')
										<button type="submit" onclick="return confirm('Apa anda yakin ingin menghapus task ini?')" class="btn btn-sm btn-danger">Delete</button>
									</form>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>	
		</div>      
		<div class="row my-2">	
			<div class="col-md-6">
				Jumlah Task: {{number_format($tasks_count)}} task
			</div>
			<div class="col-md-6">
				<div class="float-right">
					{!! $tasks->appends(request()->query())->links() !!}
				</div>
			</div>	
		</div>  
		<div class="row my-2">	
			<div class="col-md-12">
				<p><i>*Catatan: <br>Untuk download <strong>Excel</strong> dan <strong>PDF</strong>, pastikan untuk filter data terlebih dahulu. Kecepatan download bergantung pada <strong>kemampuan server</strong> dan <strong>jumlah banyak data</strong>. <br> Jika anda memerlukan data dalam jumlah yang sangat banyak dan meningkatkan efisiensi waktu, anda dapat melakukan filter data lebih spesifik dan download secara berkala.</i></p>
			</div>
		</div>   
    </div>
</div>

<script>
	$(function(e){
		$("#checkAll").click(function(){
			$(".checkBoxClass").prop("checked", $(this).prop("checked"));
		});

		$("#deleteButtonSelected").click(function(e) {
			e.preventDefault();
			var allId = [];

			$("input:checkbox[name=ids]:checked").each(function() {
				allId.push($(this).val());
			});

			$.ajax({
				url: "",
				type: "DELETE",
				data: {
					_token:$("input[name=_token]").val(),
					ids:allId
				},
				success:function(response) {
					$.each(allId, function(key, val) {
						$("#uid"+val).remove();
					})
				}
			})
		})
	});
</script>
@endsection