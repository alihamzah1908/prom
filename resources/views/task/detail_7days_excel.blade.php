<?php 
$task = new \App\Http\Controllers\Task\TaskController;
$r = request();
$task = \App\Model\Task::where('id_task', $ids)->first();
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
            $i = 0;
            ?>
            @foreach($checklists as $c)
            @php
            $answers = $c->datas;
            @endphp
            @forelse(json_decode($answers) as $a)
            
            <tr>
                <td>{{++$i}}</td>
                <td>{{$a->checklist_name}}</td>
                <td>{{$a->is_avaiable}}</td>
                <td>{{$a->answer}}</td>
                @if(is_array($a->image))
                    
                     @foreach($a->image as $img => $val)
                <td>
                    <a href="{{ public_path().'/checklist_image/'.$val }}" target="new">
                        <img src="{{ public_path().'/checklist_image/'.$val }}" width="120px" height="150px">
                    </a>
                </td>
                @endforeach
                    
                  
                    @else
                    <td>
                     <a href="{{ public_path().'/default.png' }}" target="new">
                        <img src="{{ public_path().'/default.png' }}" width="120px" height="150px">
                    </a>
                     </td>
                     @endif
            </tr>
           
            @empty
            @endforelse
            @endforeach
        </tbody>
    </table>