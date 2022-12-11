<title>Task</title>
<?php 
$task = new \App\Http\Controllers\Task\TaskController;
$r = request();
$task = \App\Model\Task::where('id_task', $r->id_task)->first();
$i = 0;
$url = main_url(); 
?>
<table class="display table table-striped" style="width:100%; border: none; text-align:left">
<thead>
	    <tr>
	        <th>{{$task->task_uid}}</th>
	    </tr>
	    <tr>
	        <th>{{$task->subject}}</th>
	   </tr>
	   <tr>
	        <th>{{$task->getTechnician->name_technician}}</th>
	   </tr>
	    <tr>
	        <th>{{$task->created_at}}</th>
	   </tr>
	</thead>
</table>
<br><br>
<table border="1" class="display table table-striped" style="width:100%; border-collapse: collapse; text-align:center">
	<thead>
	    <tr>
	        <th>No</th>
	        <th>Checklist</th>
	        <th>Availability</th>
	        <th>Answer</th>
	         <th>Site ID</th>
	        <th>Image</th>
	    </tr>
	</thead>
	<tbody>
        <?php 
        $answers = isset($task->checklist_answers)?$task->checklist_answers->datas:'[]';
        $id_site = isset($task->getSite->uid_site)?$task->getSite->uid_site : "" ;
        $i = 0;
        ?>
        @forelse(json_decode($answers) as $a)
        <tr>
            <td>{{++$i}}</td>
            <td>{{$a->checklist_name}}</td>
            <td>{{$a->is_avaiable}}</td>
           <td>{{$a->answer}}</td>
              <td>{{$id_site}}</td>
           @if(is_array($a->image))
                    
                     @foreach($a->image as $img => $val)
                
                    <a href="{{ public_path().'/checklist_image/'.$val }}" target="new">
                        <img src="{{ public_path().'/checklist_image/'.$val }}" width="120px" height="150px" >
                    </a>
                <!--</td>-->
                @endforeach
                    
                  
                    @else
                    <!--<td style="padding-top:40px">-->
                     <a href="{{ public_path().'/checklist_image/'.$a->image }}" target="new">
                        <img src="{{ public_path().'/checklist_image/'.$a->image }}" width="120px" height="150px" >
                    </a>
                     
                     @endif
        </tr>
        @empty
        @endforelse
    </tbody>
</table>