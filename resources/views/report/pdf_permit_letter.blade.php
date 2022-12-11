<?php 
    $r = request();
    $report_columns = \App\Model\ReportColumn::where('id', request()->col_id)->where('type', 'PERMIT_LETTER')->first();
    
    $columns = [];
    if($report_columns){
        $columns = json_decode($report_columns->columns);
        if(!is_array($columns)) $columns = [$columns];
    }
    
    $data = new \App\Http\Controllers\ReportController;
    $data = $data->get_permit_letter($r)->original['data'];
?>
@if($report_columns)
<table border="1" class="display table table-striped" style="width:100%; border-collapse: collapse; text-align:center">
    <thead>
        <tr>
            @foreach($columns as $k => $val)
                <th>{{getPermitLetterColumns($val)['name']}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($data as $d)
        <tr>
            @foreach($columns as $k => $val)
            <td>{{$d[$val]}}</td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>
@else
@endif