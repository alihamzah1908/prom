@extends('template.default')
@section('title', 'Task')

@section('submenu')
<!--<div class="row mb-2">-->
<!--    <div class="col-sm-6">-->
<!--        <h3 class="m-0 text-dark"><strong>Task</strong></h3>-->
<!--    </div>-->
<!--</div>-->
@endsection
@section('content')

<link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<div class="card">
    <div class="row">
        <div class="col-lg-12">
            <div class="btn-group w-100">
            @foreach($regions as $region)
                <a class="btn btn-sm btn-secondary" type="button" href="{{route('form_bulanan.index', $region->region_id)}}" target="_blank">{{$region->region_name}}</a>
            @endforeach                      
            </div>
        </div>
    </div>
    <div class="card-header">
        <div class="row">
            <div class="col-md-12">
                <h3 class="card-title"> <strong>Testing Form Bulanan {{$selected_region[0]->region_name}} per November 2021</strong></h3>
            </div>
        </div>    
    <div class="card-body">
        <div id="table-cme">
            <div class="row py-1">
                <div class="col-lg-12">
                    <div class="float-left">
                        <h6 class="font-italic">Tabel 2. Pengecekan mekanikal dan kelistrikan di {{$selected_region[0]->region_name}} Periode {{$form_bulan}} {{$form_tahun}}</h6>
                    </div>
                    <div class="float-right">
                        <a href="{{route('form_bulanan.download_table_2', $selected_region[0]->region_id)}}" target="_blank" type="button" class="btn btn-sm btn-secondary">Download Table</a>
                    </div>
                </div>
            </div>
            <div style="overflow-y:auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Site</th>
                            <th scope="col">Sistem Grounding & Penangkal Petir</th>
                            <th scope="col">PLN & ACPDB</th>
                            <th scope="col">Genset</th>
                            <th scope="col">ATS</th>
                            <th scope="col">Solar Cell</th>
                            <th scope="col">Rectifier</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Link Detail</th>               
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($site_table_2 as $st2 )
                        <tr>
                            <th scope="row">{{++$no}}</th>
                            
                            <td class="font-weight-bold">{{$st2->name_site}}</td>
                            <td>{{$st2->power_ground}}</td>
                            <td>{{$st2->pln}}</td>
                            <td>{{$st2->genset}}</td>
                            <td>{{$st2->ats}}</td>
                            <td>{{$st2->solar}}</td>
                            <td>{{$st2->rectifier}}</td>
                            <td>{{$st2->keterangan}}</td>
                            <td>
                                <div class="btn-group">
                                    @if($st2->id_mingguan != null)
                                        <a class="btn btn-sm btn-secondary" type="button" href="{{route('task-detail', $st2->id_mingguan)}}" target="_blank">Mingguan</a>
                                    @endif
                                    @if($st2->id_mingguan == null)
                                        <a class="btn btn-sm btn-secondary" type="button" href="#" target="_blank" disabled>Mingguan</a>
                                    @endif   
                                    @if($st2->id_bulanan != null)
                                        <a class="btn btn-sm btn-secondary" type="button" href="{{route('task-detail', $st2->id_bulanan)}}" target="_blank">Bulanan</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div><hr><br>
        <div id="table-sipil">
            <div class="row py-1">
                <div class="col-lg-12">
                    <div class="float-left">
                        <h6 class="font-italic">Tabel 3 Pengecekan Sipil  dan Lingkungan Site di {{$selected_region[0]->region_name}} Periode {{$form_bulan}} {{$form_tahun}}</h6>
                    </div>
                    <div class="float-right">
                    <a href="{{route('form_bulanan.download_table_3',$selected_region[0]->region_id)}}" target="_blank" type="button" class="btn btn-sm btn-secondary">Download Table</a>
                    </div>
                </div>
            </div>
            <div style="overflow-y:auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Site</th>
                            <th scope="col">Tower & Lingkungan Site</th>
                            <th scope="col">Shelter/Bangunan Perangkat ISP</th>
                            <th scope="col">Site Environtment</th>
                            <th scope="col">Akses</th>     
                            <th scope="col">Keterangan</th>  
                            <th scope="col">Link Detail</th>      
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($site_table_3 as $st3)
                        <tr>
                            <th scope="row">{{++$no_3}}</th>
                            <td class="font-weight-bold">{{$st3->name_site}}</td>
                            <td>{{$st3->tower}}</td>
                            <td>{{$st3->shelter}}</td>
                            <td>{{$st3->site}}</td>
                            <td>{{$st3->akses}}</td>
                            <td>{{$st3->keterangan_3}}</td>
                            <td>
                                <div class="btn-group">
                                    @if($st3->id_bulanan != null)
                                        <a class="btn btn-sm btn-secondary" type="button" href="{{route('task-detail', $st3->id_bulanan)}}" target="_blank">Bulanan</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div><hr><br>
        <div id="table-pln">
            <div class="row py-1">
                <div class="col-lg-12">
                    <div class="float-left">
                        <h6 class="font-italic">Tabel 4 Pemakaian Kapasitas Daya PLN di {{$selected_region[0]->region_name}} Periode {{$form_bulan}} {{$form_tahun}}</h6>
                    </div>
                    <div class="float-right">
                        <a href="{{route('form_bulanan.download_table_4', $selected_region[0]->region_id)}}" target="_blank" type="button" class="btn btn-sm btn-secondary">Download Table</a>
                    </div>
                </div>
            </div>
            <div style="overflow-y:auto">
                <table class="table">
                    <thead>
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
                            <th scope="col">Link Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($site_table_4 as $s4)
                        <tr>
                            <td><strong>{{++$no_4 ?? 'empty'}}</strong></td>
                            <td><strong>{{$s4->name_site  ?? 'empty'}}</strong></td>
                            <td>{{$s4->beban_kapasitas_kwh  ?? 'empty'}}</td>
                            <td>{{$s4->beban_aman  ?? 'empty'}}</td>
                            <td>{{$s4->r_s->answer  ?? 'empty'}}</td>
                            <td>{{$s4->r_t->answer  ?? 'empty'}}</td>
                            <td>{{$s4->s_t->answer  ?? 'empty'}}</td>
                            <td>{{$s4->r->answer  ?? 'empty'}}</td>
                            <td>{{$s4->s->answer  ?? 'empty'}}</td>
                            <td>{{$s4->t->answer  ?? 'empty'}}</td>
                            <td>{{ $s4->beban_total  ?? 'empty'}}</td>
                            <td>{{ $s4->persentase_beban  ?? 'empty'}}</td>
                            <td>
                                <div class="btn-group">
                                    @if($s4->id_mingguan != null)
                                        <a class="btn btn-sm btn-secondary" type="button" href="{{route('task-detail', $s4->id_mingguan)}}" target="_blank">Mingguan</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div><hr><br>
        <div id="table-solar">
            <div class="row py-1">
                <div class="col-lg-12">
                    <div class="float-left">
                        <h6 class="font-italic">Tabel 5 Konsumsi Solar di {{$selected_region[0]->region_name}} Periode {{$form_bulan}} {{$form_tahun}}</h6>
                    </div>
                    <div class="float-right">
                        <a href="{{route('form_bulanan.download_table_5',$selected_region[0]->region_id)}}" target="_blank" type="button" class="btn btn-sm btn-secondary">Download Table</a>
                    </div>
                </div>
            </div>
            <div style="overflow-y:auto">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th scope="col" rowspan=2>#</th>
                            <th scope="col" rowspan=2>Site</th>
                            <th scope="col" colspan=5>Pemakaian solar ( Liter )</th>
                            <th scope="col" rowspan=2>Link Detail</th>            
                        </tr>
                        <tr>
                            <th scope="col">W 1</th>
                            <th scope="col">W 2</th>
                            <th scope="col">W 3</th> 
                            <th scope="col">W 4</th>
                            <th scope="col">Total</th>   
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($site_table_5 as $st5)
                        <tr>
                            <th scope="row">{{++$no_5 ?? 'empty'}}</th>
                            <td class="font-weight-bold  text-left">{{ $st5->name_site ?? 'empty'}}</td>
                            <td>{{$st5->w_1 ?? 'empty'}}</td>
                            <td>{{$st5->w_2 ?? 'empty'}}</td>
                            <td>{{$st5->w_3 ?? 'empty'}}</td>
                            <td>{{$st5->w_4 ?? 'empty'}}</td>
                            <td>{{$st5->w_total ?? 'empty'}}</td> 
                            <td>
                                <div class="btn-group">
                                        @if($st5->id_task_week_0 != null)
                                        <a class="btn btn-sm btn-secondary" type="button" href="{{route('task-detail', $st5->id_task_week_0)}}" target="_blank">- W 1</a>
                                        @endif
                                        @if($st5->id_task_week_1 != null)
                                        <a class="btn btn-sm btn-secondary" type="button" href="{{route('task-detail', $st5->id_task_week_1)}}" target="_blank">W 1</a>
                                        @endif
                                        @if($st5->id_task_week_2 != null)
                                        <a class="btn btn-sm btn-secondary" type="button" href="{{route('task-detail', $st5->id_task_week_2)}}" target="_blank">W 2</a>
                                        @endif
                                        @if($st5->id_task_week_3 != null)
                                        <a class="btn btn-sm btn-secondary" type="button" href="{{route('task-detail', $st5->id_task_week_3)}}" target="_blank">W 3</a>
                                        @endif
                                        @if($st5->id_task_week_4 != null)
                                            <a class="btn btn-sm btn-secondary" type="button" href="{{route('task-detail', $st5->id_task_week_4)}}" target="_blank">W 4</a>
                                        @endif
                                        
                                    
                                </div>
                            </td> 
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
