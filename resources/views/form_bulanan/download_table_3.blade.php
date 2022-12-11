<table>
    <thead>
        <tr>
            <th colspan="8">Tabel 3 Pengecekan Sipil dan Lingkungan Site {{$selected_region[0]->region_name}} Periode {{$form_bulan}} {{$form_tahun}}</th>
        </tr>
        <tr>
            <th>No</th>
            <th>Site</th>
            <th>Tower and Lingkungan Site</th>
            <th>Shelter or Bangunan Perangkat ISP</th>
            <th>Site Environtment</th>
            <th>Akses</th>
            <th>Keterangan</th>
            <th>Rencana Perbaikan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($site_table_3 as $st3)
            <tr>
                <th>{{++$no_3}}</th>
                <td>{{$st3->name_site}}</td>
                <td>{{$st3->tower}}</td>
                <td>{{$st3->shelter}}</td>
                <td>{{$st3->site}}</td>
                <td>{{$st3->akses}}</td>
                <td>{{$st3->keterangan_3}}</td>
            </tr>
        @endforeach
    </tbody>
</table>