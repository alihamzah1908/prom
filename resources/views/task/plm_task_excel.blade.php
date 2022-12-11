<title>Task PLM EXCEL</title>
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
           <th>Before</th>
           <th>After</th>
        </tr>
    </thead>
<tbody>
        <?php 
        $answers = isset($task->getImages)?$task->getImages:'[]';
        
        $before = [];
        $after = [];
        $before_after = [];
        
        foreach(json_decode($answers) as $a){
            if($a->type == "BEFORE") $before[] = $a;
            if($a->type == "AFTER") $after[] = $a;
        }
        
        $b_c = count($before);
        $b_a = count($after);
        
        $array_merge = $before;
        if($b_c >= $b_a) $array_merge = $before;
        if($b_c < $b_a) $array_merge = $after;
        
        foreach($array_merge as $k => $v){
            if($b_c >= $b_a){
                $before_after[$k] = [
                    "before" => $v,
                    "after" => isset($after[$k])?$after[$k]:[]
                ];
            }else{
                $before_after[$k] = [
                    "before" => isset($before[$k])?$before[$k]:[],
                    "after" => $v
                ];
            }
            
        }
        
        $i = 0;
        ?>
        
        @forelse($before_after as $a)
      
            
        <tr>
            <td>{{++$i}}</td>
           <td>
                @if($a['before'])
                    @php list($width, $height) = getimagesize(public_path().'/task_report/'.$a['before']->image) @endphp
                    @if($width > $height)  @else  @endif
                    <img src="{{ public_path().'/task_report/'.$a['before']->image}}"  width="200px" height="250px">
                @endif
            </td>
             <td>
                @if($a['after'])
                    @php list($width, $height) = getimagesize(public_path().'/task_report/'.$a['after']->image) @endphp
                    @if($width > $height)  @else  @endif
                    <img src="{{ (public_path().'/task_report/'.$a['after']->image)}}"  width="200px" height="250px">
                @endif
            </td>
        </tr>
        @empty
        @endforelse
    </tbody>
</table>