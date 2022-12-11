<table>
    <thead>
        <tr>
            <th colspan="12">Tabel 4 Pemakaian Kapasitas Daya PLN {{$selected_region[0]->region_name}} Periode {{$form_bulan}} {{$form_tahun}}</th>
        </tr>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Site</th>
            <th scope="col">Kapasitas Kwh PLN (VA)</th>
            <th scope="col">Kapasitas Beban Aman (80 %) (VA)</th>
            <th scope="col">Tegangan Ukur R-S (V)</th>  
            <th scope="col">Tegangan Ukur R-T (V)</th>  
            <th scope="col">Tegangan Ukur S-T (V)</th>  
            <th scope="col">Beban Phasa R (A)</th>               
            <th scope="col">Beban Phasa S (A)</th>  
            <th scope="col">Beban Phasa T (A)</th>  
            <th scope="col">Beban total (VA)</th>  
            <th scope="col">Persentase Beban</th>  
        </tr>
    </thead>
    <tbody>
        @foreach($site_table_4 as $s4)
            <tr>
                <td>{{++$no_4}}</td>
                <td>{{$s4->name_site ?? 'empty'}}</td>
                <td>{{$s4->beban_kapasitas_kwh ?? 'empty'}}</td>
                <td>{{$s4->beban_aman ?? 'empty'}}</td>
                <td>{{$s4->r_s->answer ?? 'empty'}}</td>
                <td>{{$s4->r_t->answer ?? 'empty'}}</td>
                <td>{{$s4->s_t->answer ?? 'empty'}}</td>
                <td>{{$s4->r->answer ?? 'empty'}}</td>
                <td>{{$s4->s->answer ?? 'empty'}}</td>
                <td>{{$s4->t->answer ?? 'empty'}}</td>
                <td>{{ $s4->beban_total ?? 'empty'}}</td>
                <td>{{ $s4->persentase_beban ?? 'empty'}}</td>
            </tr>
        @endforeach
    </tbody>
</table>