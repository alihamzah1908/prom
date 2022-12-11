@extends('template.default')
@section('submenu')
<div class="row mb-2 pb-3">
    <div class="col-sm-6">
        <h3 class="m-0 text-dark"><strong>Site Entry</strong></h3>
        <small>Site Permit > Permit Letter</small>
    </div>
</div>
@endsection
@section('content')

@if(Session::has('message'))
<div class="alert {{Session::get('alert-class')}} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{ Session::get('message') }}
</div>
@endif

<link rel="stylesheet" href="/css/adminlte.min.css">
<style>
  #map {
    position: absolute;
    top: 0;
    bottom: 0;
    width: 100%;
  }
    table.dataTable.no-footer {
        border-bottom: 0 !important;
    }
    button.dt-button{
        padding:0.25rem !important;
    }
    .pull-right {
        float: right!important;
    }
</style>
<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.js'></script>
<!--<script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.2.0/mapbox-gl-geocoder.min.js'></script>-->
<link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.css' rel='stylesheet' />
<!--<link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.2.0/mapbox-gl-geocoder.css' type='text/css' />-->


<script src="https://api.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.js"></script>
<link href="https://api.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.css" rel="stylesheet" />
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.css" type="text/css" />
<!-- Promise polyfill script required to use Mapbox GL Geocoder in IE 11 -->
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>

<div class="card col-md-12" style="border-top: 2px solid #ddd; margin-left: 0px; padding:0.1rem; margin-bottom: 2px !important; border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
    <ul class="nav nav-pills row text-center col-md-10" style="margin-left: 0;margin-right: 0;">
        <li class="nav-item col-md-2"><a style="border-radius:0" class="nav-link active" href="#detail" data-toggle="tab">Detail</a></li>
    </ul>
</div>
<div class="card" style="border-top-left-radius: 0; border-top-right-radius: 0;">
    <div class="card-body" style="background-color: #f1f1f1;">
        <div class="tab-content">
            <div class="active tab-pane" id="detail">
                <div class="row">
                    <div class="col-md-5">
                        <div class="card-header mb-4" style="border-bottom: 4px solid #000;">
                            <h3 class="card-title">
                                <b>
                                    STATUS: <span style="">{{isset($data->status)?$data->status:''}}</span>
                                </b>
                            </h3>
                        </div>
                        <br>
                        
                        <strong>Region</strong>
                        <p class="text-muted">{{isset($data->region)?$data->region->region_name:'-'}}</p>
                        <hr>
                        <strong>Site</strong>
                        <p class="text-muted">{{isset($data->site)?$data->site->name_site:'-'}}</p>
                        <hr>
                        <strong>Pemohon</strong>
                        <p class="text-muted">{{isset($data->pemohon)?$data->pemohon:'-'}}</p>
                        <hr>
                        <strong>Instansi</strong>
                        <p class="text-muted">{{isset($data->instansi)?$data->instansi:'-'}}</p>
                        <hr>
                        <strong>Departement</strong>
                        <p class="text-muted">{{isset($data->departement)?$data->departement:'-'}}</p>
                        <hr>
                        <strong>Atasan</strong>
                        <p class="text-muted">{{isset($data->atasan)?$data->atasan:'-'}}</p>
                        <hr>
                        <strong>Nomor Telepon</strong>
                        <p class="text-muted">{{isset($data->nomor_telepon)?$data->nomor_telepon:'-'}}</p>
                        <hr>
                        <strong>Tanggal Pengajuan</strong>
                        <p class="text-muted">{{isset($data->tanggal_pengajuan)?$data->tanggal_pengajuan:'-'}}</p>
                        <hr>
                        <strong>Tanggal Berlaku</strong>
                        <p class="text-muted">{{isset($data->tanggal_berlaku)?$data->tanggal_berlaku:'-'}} s.d {{isset($data->tanggal_berlaku_sd)?$data->tanggal_berlaku_sd:'-'}}</p>
                        <hr>
                        <strong>Pengunjung</strong>
                        <p class="text-muted">
                            <?php 
                            $data->pengunjung = isset($data->pengunjung)?$data->pengunjung:[] ;
                            ?>
                            @foreach($data->pengunjung as $key => $pengunjung)
                            <ul>
                                <li>{{isset($pengunjung)?$pengunjung->nama_pengunjung:'-'}}</li>
                            </ul>
                            @endforeach
                        </p>
                        <hr>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-6"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer bg-transparent">
        <a class="btn btn-default" href="/waiting_approval/site-permit">BACK</a>
        
        <button class="btn btn-success float-right text-light btn-approval" data-status="APPROVED">APPROVE</button>
        <button class="btn btn-danger float-right text-light btn-approval mr-2" data-status="REJECTED">REJECT</button>
    </div>
</div>

<div class="modal fade" id="modalApproval">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/site-permit/permit-letter-approval/{{$data->id_permit_letter}}">
            @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Site Entry Approval</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group text-center">
                        <img src="/images/approve.png">
                        <h5 class="mt-3 mb-4">
                           Site Entry will be <span class="approval_status"></span>!
                           <br>
                           <!--Please leave note: -->
                        </h5>
                        <input hidden value="" name="approval_status">
                        <!--<textarea class="form-control" name="note" required autofocus></textarea>-->
                    </div>
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        $(document).on('click', '.btn-approval', function(e){
            e.preventDefault();
            var ini = $(this),
                status = ini.data('status');
            $('.approval_status').html(status);
            $('input[name=approval_status]').val(status);
            $('#modalApproval').modal('show');
        });
    });
</script>
@endpush