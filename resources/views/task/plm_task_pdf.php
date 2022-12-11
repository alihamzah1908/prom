<title>Task PLM PDF</title>
<?php 
$task = new \App\Http\Controllers\Task\TaskController;
$r = request();
$task = \App\Model\Task::where('id_task', $r->id_task)->first();
$i = 0;
$url = main_url(); 
return "dd";
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
	       <th>Before</th>
	       <th>After</th>
	    </tr>
	</thead>
	<tbody>
        <?php 
        $answers = isset($task->getImages)?$task->getImages:'';
        $i = 0;
        ?>
        @forelse(json_decode($answers) as $a)
        <tr>
            <td>{{++$i}}</td>
            <td style="padding-top:40px">
            @if($a->type == "BEFORE")
                    
                    
                    <a href="{{ public_path().'/task_report/'.$a->image }}" target="new">
                        <img src="{{ public_path().'/task_report/'.$val }}" width="120px" height="150px" >
                    </a>
                <!--</td>-->
                @endforeach
             
                     </td>
                     <td style="padding-top:40px">
            @if($a->type == "AFTER")
                    
                    
                    <a href="{{ public_path().'/task_report/'.$a->image }}" target="new">
                        <img src="{{ public_path().'/task_report/'.$val }}" width="120px" height="150px" >
                    </a>
                <!--</td>-->
                @endforeach
             
                     </td>
        </tr>
        @empty
        @endforelse
    </tbody>
</table>