<?php 
$task = new \App\Http\Controllers\Task\TaskController;
$r = request();
$datas = $task->getData($r)->original;
$i = 0;
?>
<table border="1" class="display table table-striped" style="width:100%; border-collapse: collapse; text-align:center">
	<thead>
	    <tr>
	        <th>No</th>
	        <th>Uid</th>
	        <th>Type</th>
	        <th>Status</th>
	        <th>Title</th>
	        <th>Site</th>
	        <th>Creation Time</th>
	        <th>Completion Time</th>
	    </tr>
	</thead>
	<tbody>
	    @foreach($datas['data'] as $task)
	    <tr>
	        <td>{{++$i}}</td>
	        <td>{{$task->task_uid}}</td>
	        <td>{{$task->getType?$task->getType->type_name:''}}</td>
	        <td>{{isset($task->getStatus)?$task->getStatus->status_name:''}}</td>
	        <td>{{$task->subject}}</td>
	        <td>{{isset($task->getSite)?$task->getSite->name_site:'-'}}</td>
	        <td>{{$task->created_at}}</td>
	        <td>{{isset($task->time_complete)?$task->time_complete : "00-00-00 00:00:00"}}</td>
	    </tr>
	    @endforeach
	</tbody>
</table>