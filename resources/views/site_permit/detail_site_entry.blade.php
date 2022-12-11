@extends('template.default')
@section('submenu')
<div class="row mb-2 pb-3">
    <div class="col-sm-6">
        <h3 class="m-0 text-dark"><strong>Site Entry</strong></h3>
        <small>Site Permit > Site Entry</small>
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
        @if(request()->view == "EDIT")
        <li class="nav-item col-md-2"><a style="border-radius:0" class="nav-link" href="?view=DETAIL">Detail</a></li>
            @if(is_admin(Auth::user()))
            <li class="nav-item col-md-2"><a style="border-radius:0" class="nav-link" href="?view=DETAIL">Log</a></li>
            @endif
        <li class="nav-item col-md-2"><a style="border-radius:0" class="nav-link" href="?view=DETAIL">Approval</a></li>
        @else
        <li class="nav-item col-md-2"><a style="border-radius:0" class="nav-link active" href="#detail" data-toggle="tab">Detail</a></li>
            @if(is_admin(Auth::user()))
            <li class="nav-item col-md-2"><a style="border-radius:0" class="nav-link" href="#log" data-toggle="tab">Log</a></li>
            @endif
        <li class="nav-item col-md-2"><a style="border-radius:0" class="nav-link" href="#approval" data-toggle="tab">Approval</a></li>
        @endif
        @if(is_admin(Auth::user()))
        <li class="nav-item col-md-2"><a style="border-radius:0" class="nav-link {{request()->view == 'EDIT' ? 'active':''}}" href="?view=EDIT">Edit</a></li>
        @endif
    </ul>
</div>
<div class="card" style="border-top-left-radius: 0; border-top-right-radius: 0;">
    <div class="card-body" style="background-color: #f1f1f1;">
        <div class="tab-content">
            <div class="{{request()->view == 'EDIT' ? '':'active'}} tab-pane" id="detail">
                @if(request()->view != "EDIT")
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
                        <strong>Entry Datetime</strong>
                        <p class="text-muted">{{isset($data->entry_datetime)?$data->entry_datetime:'-'}}</p>
                        <hr>
                        <strong>Jumlah Petugas</strong>
                        <p class="text-muted">{{isset($data->jumlah_petugas)?$data->jumlah_petugas:'-'}}</p>
                        <hr>
                        <strong>Tag GPS</strong>
                        <p class="text-muted">
                            <table class="mt-1">
                                <tr>
                                    <td><strong>Latitude</strong></td>
                                    <td class="text-muted">: {{isset($data->latitude)?$data->latitude:'-'}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Longitude</strong></td>
                                    <td class="text-muted">: {{isset($data->longitude)?$data->longitude:'-'}}</td>
                                </tr>
                            </table>
                        </p>
                        <hr>
                        <strong>Description</strong>
                        <p class="text-muted">{{isset($data->description)?$data->description:'-'}}</p>
                        <hr>
                        <strong>Personil</strong>
                        <p class="text-muted">
                            <?php 
                            $data->personil = isset($data->personil)?$data->personil:'[]' ;
                            $personils = json_decode($data->personil);
                            ?>
                            @if(is_array($personils))
                            @foreach($personils as $key => $personil)
                            <?php $personil = \App\User::where('id',$personil)->first(); ?>
                            <ul>
                                <li>{{isset($personil)?$personil->name:'PERSONIL NOT FOUND!'}}</li>
                            </ul>
                            @endforeach
                            @endif
                        </p>
                        <hr>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-6">
                        <div id='map'></div>
                    </div>
                </div>
                @endif
            </div>
            @if(is_admin(Auth::user()))
            <div class="tab-pane" id="log" style="padding: 1rem;">
                @if(request()->view != "EDIT") 
                <ul class="timeline timeline-inverse">
                    @forelse($data->getLog()->orderBy('id_log','DESC')->get() as $log)
                    <li>
                        <i class="fa  @if($log->action == 'CREATE') fa-plus bg-success @elseif($log->action == 'APPROVAL') fa-info bg-info  @else fa-edit bg-warning @endif" style="color: white !important;"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> {{date('l H:i, F jS, Y', strtotime($log->created_at))}}</span>
                            <h3 class="timeline-header">
                                {{$log->action}} By <a href="#">{{isset($log->creator)?$log->creator->name:''}}</a>
                            </h3>
                            <div class="timeline-body text-left">
                                <table class="table" id="log_table_{{$log->id_log}}">
                                    <thead style="display:none">
                                        <tr>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    
                                    <?php 
                                    $log_to = json_decode($log->changed_data_to);
                                    ?>
                                    <tbody>
                                        <tr>
                                            <td width="20%">ID</td>
                                            <td>:  {{isset($log_to->ID)?$log_to->ID:'-'}}</td>
                                        </tr>
                                        <tr>
                                            <td width="20%">STATUS</td>
                                            <td>:  {{$log->status_to}}</td>
                                        </tr>
                                        <tr>
                                            <td width="20%">LOGGED BY</td>
                                            <td>:  {{$log->creator->name}}</td>
                                        </tr>
                                        <tr>
                                            <td width="20%">REGION</td>
                                            <td>:  {{isset($log_to->Region)?$log_to->Region:'-'}}</td>
                                        </tr>
                                        <tr>
                                            <td width="20%">SITE</td>
                                            <td>:  {{isset($log_to->Site)?$log_to->Site:'-'}}</td>
                                        </tr>
                                        <tr>
                                            <td width="20%">ENTRY DATETIME</td>
                                            <td>:  {{isset($log_to->EntryDatetime)?$log_to->EntryDatetime:'-'}}</td>
                                        </tr>
                                        <tr>
                                            <td width="20%">JUMLAH PETUGAS</td>
                                            <td>:  {{isset($log_to->JumlahPetugas)?$log_to->JumlahPetugas:'-'}}</td>
                                        </tr>
                                        <tr>
                                            <td width="20%">LATITUDE</td>
                                            <td>:  {{isset($log_to->Latitude)?$log_to->Latitude:'-'}}</td>
                                        </tr>
                                        <tr>
                                            <td width="20%">LONGITUDE</td>
                                            <td>:  {{isset($log_to->Longitude)?$log_to->Longitude:'-'}}</td>
                                        </tr>
                                        <tr>
                                            <td width="20%">DESCRIPTION</td>
                                            <td>:  {{isset($log_to->Description)?$log_to->Description:'-'}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button class="btn btn-sm btn-default btn-copy-table-{{$log->id_log}}">Copy</button>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function(){
                                $('#log_table_{{$log->id_log}}').DataTable( {
                                    ordering: false,
                                    paginate: false,
                                    searching: false,
                                    info: false,
                                    buttons: [  'copyHtml5' ],
                                    dom:'',
                                } );
                            });
                            $(document).on('click', '.btn-copy-table-{{$log->id_log}}', function(e) {
                                var table = $("#log_table_{{$log->id_log}}");
                                table.selectText();
                                document.execCommand('copy');
                            });
                        </script>
                    </li>
                    @empty
                    <li>
                        <i class="fa fa-info bg-info"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header no-border">
                                Site Entry doesn`t have any log yet!
                            </h3>
                        </div>
                    </li>
                    @endforelse
                    <li><i class="fa fa-clock bg-gray"></i></li>
                </ul>
                @endif
            </div>
            @endif
            <div class="tab-pane" id="approval" style="padding: 1rem;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <label>Approver I</label>
                            </div>
                            <div class="card-body">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>APPROVER</th>
                                            <th>: {{isset($data->approver1)?$data->approver1->name:'-'}}</th>
                                        </tr>
                                        <tr>
                                            <th>STATUS</th>
                                            <th>: {{$data->approver_1_status}}</th>
                                        </tr>
                                        <tr>
                                            <th>NOTE</th>
                                            <th>: {{$data->approver_1_note}}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            @if(!$data->approver_1_status)
                            @if(Auth::user()->id == $data->approver_1)
                            <div class="card-footer">
                                <button class="btn btn-sm btn-success float-right text-light btn-site-approval" data-status="APPROVED">APPROVE</button>
                                <button class="btn btn-sm btn-danger float-right text-light btn-site-approval mr-2" data-status="REJECTED">REJECT</button>
                            </div>
                            @endif
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <label>Approver II</label>
                            </div>
                            <div class="card-body">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>APPROVER</th>
                                            <th>: {{isset($data->approver2)?$data->approver2->name:'-'}}</th>
                                        </tr>
                                        <tr>
                                            <th>STATUS</th>
                                            <th>: {{$data->approver_2_status}}</th>
                                        </tr>
                                        <tr>
                                            <th>NOTE</th>
                                            <th>: {{$data->approver_2_note}}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            @if($data->approver_1_status == "APPROVED" && !$data->approver_2_status)
                            @if(Auth::user()->id == $data->approver_2)
                            <div class="card-footer">
                                <button class="btn btn-sm btn-success float-right text-light btn-site-approval" data-status="APPROVED">APPROVE</button>
                                <button class="btn btn-sm btn-danger float-right text-light btn-site-approval mr-2" data-status="REJECTED">REJECT</button>
                            </div>
                            @endif
                            @endif
                        </div>
                    </div>
                    
                    <div class="modal fade" id="modalApproval">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="/site-permit/site-entry-approval/{{$data->id_site_entry}}">
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
                                               Please leave note: 
                                            </h5>
                                            <input hidden value="" name="approval_status">
                                            <textarea class="form-control" name="note" required autofocus></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            @if(is_admin(Auth::user()))
            <div class="{{request()->view == 'EDIT' ? 'active':''}} tab-pane" id="edit">
                @if(request()->view == "EDIT")
                <form method="POST" action="/site-permit/site-entry-update/{{$data->id_site_entry}}" enctype="multipart/form-data"> 
                @csrf
                    @include('site_permit.edit_site_entry')
                    <div class="card-footer bg-transparent">
                        <button type="submit" class="btn btn-primary float-right">Update</button>
                    </div>
                </form>
                @else
                
                @endif
            </div>
            @endif
        </div>
    </div>
    <div class="card-footer bg-transparent">
        <a class="btn btn-default" href="/site-permit">BACK</a>
    </div>
</div>
@endsection
@push('scripts')
@if(request()->view != "EDIT")
<script>
    jQuery.fn.selectText = function(){
        var doc = document;
        var element = this[0];
        console.log(this, element);
        if (doc.body.createTextRange) {
            var range = document.body.createTextRange();
            range.moveToElementText(element);
            range.select();
        } else if (window.getSelection) {
            var selection = window.getSelection();        
            var range = document.createRange();
            range.selectNodeContents(element);
            selection.removeAllRanges();
            selection.addRange(range);
        }
    };
    
    $('.select2').select2();
    $(document).ready(function(){
        loadMap();
        
        $(document).on('click', '.btn-site-approval', function(e){
            e.preventDefault();
            var ini = $(this),
                status = ini.data('status');
                
            $('.approval_status').html(status);
            $('input[name=approval_status]').val(status);
            $('#modalApproval').modal('show');
            
        })
    })
    
    <?php 
        echo "var coords = [$data->longitude, $data->latitude];";
    ?>
    
    function loadMap(){
        mapboxgl.accessToken = 'pk.eyJ1Ijoic2hpbmxpYW5nIiwiYSI6ImNrOXc2emM2dzAzNjEzcW12bXY5dXVhcW0ifQ.GBiyrz_Em9yZHNtqyyoNDQ';
        var map = new mapboxgl.Map({
          container: 'map',
          style: 'mapbox://styles/mapbox/streets-v10',
          center: coords,
          zoom: 7
        });
        var canvas = map.getCanvasContainer();
        
        map.on('load', function(e) {
            map.resize();
            setMarker(canvas, map, 'CLICK', coords);
        });
    
        
        map.addControl(new mapboxgl.NavigationControl());
        
        function setMarker(canvas,map, type, coords){
              var end = {
                type: 'FeatureCollection',
                features: [{
                  type: 'Feature',
                  properties: {},
                  geometry: {
                    type: 'Point',
                    coordinates: coords
                  }
                }
                ]
              };
              if (map.getLayer('end')) {
                map.getSource('end').setData(end);
              } else {
                map.addLayer({
                  id: 'end',
                  type: 'circle',
                  source: {
                    type: 'geojson',
                    data: {
                      type: 'FeatureCollection',
                      features: [{
                        type: 'Feature',
                        properties: {},
                        geometry: {
                          type: 'Point',
                          coordinates: coords
                        }
                      }]
                    }
                  },
                  paint: {
                    'circle-radius': 10,
                    'circle-color': '#288fff'
                  }
                });
              }
        }
    }
</script>
@endif
@endpush