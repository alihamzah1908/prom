<?php 
    $r = request();
    $report_columns = \App\Model\ReportColumn::where('id', request()->id)->where('type', 'TASK')->first();
    
    $columns = [];
    if($report_columns){
        $columns = json_decode($report_columns->columns);
        if(!is_array($columns)) $columns = [$columns];
    }
    
    $data = new \App\Http\Controllers\Task\TaskController;
    $data = $data->getData($r)->original['data'];
?>
@if($report_columns)
<table border="1" class="display table table-striped" style="width:100%; border-collapse: collapse; text-align:center">
    <thead>
        <tr>
            @foreach($columns as $k => $val)
                <th>{{getTaskColumns($val)['name']}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($data as $t)
        <tr>
            @foreach($columns as $k => $val)
            <td>{{$t->$val}}</td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>

@else
@endif