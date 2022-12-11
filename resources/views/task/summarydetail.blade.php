@extends('template.default')
@section('submenu')
<div class="row mb-2 pb-3">
    <div class="col-sm-6">
        <h3 class="m-0 text-dark"><strong>Mop</strong></h3>
        <small>Task > Mop</small>
    </div>
</div>
<div class="row" style="border-top: 2px solid #ddd; margin-left: 0px;">
    <div class="col-md-2">
        <a href="/task/{{$task->id_task}}/summary-detail" class="nav-title {{  request()->is('task/$task->id_task/summary-detail') ? 'active' : '' }}">Summary</a>
    </div>
    <div class="col-md-10">
        <a href="/task/{{$task->id_task}}/log-detail" class="nav-title {{  request()->is('task/$task->id_task/log-detail') ? 'active' : '' }}">Log</a>
    </div>
</div>
@endsection
@section('content')

<div class="card">
    <!-- /.card-header -->
    <div class="card-header">
        <h3 class="card-title"> <strong>Summary</strong></h3>
    </div>
    {{-- card body --}}
    <div class="card-body">
        <p class="judul">PT. Len Telekominikasi Indonesia</p>
        <div class="body_menu">
            <div class="list_menu">
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col">
                                <small style="color: #BDBDBD;">Type</small>
                                <h5 class="list_data">New Activity</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <small style="color: #BDBDBD;">Title</small>
                                <h5 class="list_data">Migration u2000 to NOC</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <small style="color: #BDBDBD;">Description</small>
                                <h5 class="list_data">Migration from u2000  LTI to NCE Server
                                    Server Jakarta /10. 33 dan u2000 Server</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <small style="color: #BDBDBD;">Start Date</small>
                                <h5 class="list_data">2020-10-10</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <small style="color: #BDBDBD;">End Date</small>
                                <h5 class="list_data">2020-10-10</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <small style="color: #BDBDBD;">BUP</small>
                                <h5 class="list_data">LTI</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <small style="color: #BDBDBD;">City</small>
                                <h5 class="list_data">Jakarta</h5>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col">
                                <small style="color: #BDBDBD;">Fillname</small>
                                <h5 class="list_data">MOP_MNS_Migration_from_LTI_U2000</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <small style="color: #BDBDBD;">Action</small>
                            </div>
                        </div>
                        <div class="row pt-2">
                            <div class="col">
                                <a href="#" class="btn btn-primary">Download</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.card -->

@endsection
