<table class="table">
    <thead>
        <tr>
            <th colspan="7">Tabel 5 Konsumsi Solar {{$selected_region[0]->region_name}} Periode {{$form_bulan}} {{$form_tahun}}</th>
        </tr>
        <tr>
            <th rowspan=2>#</th>
            <th rowspan=2>Site</th>
            <th colspan=5>Pemakaian solar ( Liter )</th>            
        </tr>
        <tr>
            <th>W 1</th>
            <th>W 2</th>
            <th>W 3</th> 
            <th>W 4</th>
            <th>Total</th>   
        </tr>
    </thead>
    <tbody>
        @foreach($site_table_5 as $st5)
        <tr>
            <td>{{++$no_5}}</td>
            <td>{{ $st5->name_site }}</td>
            <td>{{$st5->w_1}}</td>
            <td>{{$st5->w_2}}</td>
            <td>{{$st5->w_3}}</td>
            <td>{{$st5->w_4}}</td>
            <td>{{$st5->w_total}}</td>  
        </tr>
        @endforeach
    </tbody>
</table>