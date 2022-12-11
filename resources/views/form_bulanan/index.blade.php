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
    <div class="card-header">
        <div class="row">
            <div class="col-md-12">
                <h3 class="card-title"> <strong>Testing Form Bulanan</strong></h3>
            </div>
        </div>    
    <div class="card-body">
        <div id="table-cme">
            <div class="row py-1">
                <div class="col-lg-12">
                    <div class="float-left">
                        <h6 class="font-italic">Tabel 2. Pengecekan mekanikal dan kelistrikan</h6>
                    </div>
                    <div class="float-right">
                        <a href="#" target="_blank" type="button" class="btn btn-sm btn-secondary">Download Table</a>
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
                        @foreach($table_2 as $t2 )
                        <tr>
                            <th scope="row">{{++$no}}</th>
                            
                            <td class="font-weight-bold">{{$t2->name_site}}</td>
                            <td>{{$t2->power_ground}}</td>
                            <td>{{$t2->pln}}</td>
                            <td>{{$t2->genset}}</td>
                            <td>{{$t2->ats}}</td>
                            <td>{{$t2->solar}}</td>
                            <td>{{$t2->rectifier}}</td>
                            <td>{{$t2->keterangan}}</td>
                            <td>
                                <div class="btn-group">
                                    @if($t2->task_mingguan['id_task'])
                                    <a class="btn btn-sm btn-secondary" type="button" href="{{ route('task-detail', $t2->task_mingguan['id_task']) }}" target="_blank">Mingguan</a>
                                    @endif
                                    @if($t2->task_bulanan['id_task'])
                                    <a class="btn btn-sm btn-secondary" type="button" href="{{ route('task-detail', $t2->task_bulanan['id_task']) }}" target="_blank">Bulanan</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div><hr><br>
    </div>
</div>
@endsection
