
<table>
    <thead>
        <tr>
            <th colspan="10">Tabel 2 Pengecekan mekanikal dan kelistrikan {{$selected_region[0]->region_name}} Periode {{$form_bulan}} {{$form_tahun}}</th>
        </tr>
        <tr>
            <th>No</th>
            <th>Site</th>
            <th>Sistem Grounding  Penangkal Petir</th>
            <th>PLN  ACPDB</th>
            <th>Genset</th>
            <th>ATS</th>
            <th>Solar Cell</th>   
            <th>Rectifier</th>
            <th>Keterangan</th>
            <th>Rencana Perbaikan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($site_table_2 as $st2 )
            <tr>
                <th>{{++$no}}</th>
                
                <td>{{$st2->name_site}}</td>
                <td>{{$st2->power_ground}}</td>
                <td>{{$st2->pln}}</td>
                <td>{{$st2->genset}}</td>
                <td>{{$st2->ats}}</td>
                <td>{{$st2->solar}}</td>
                <td>{{$st2->rectifier}}</td>
                <td>{{$st2->keterangan}}</td>
            </tr>
        @endforeach
    </tbody>
</table>