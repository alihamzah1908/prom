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
<style>
  #map {
    position: absolute;
    top: 0;
    bottom: 0;
    width: 100%;
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

@if(Session::has('message'))
    <div class="alert {{Session::get('alert-class')}} alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        {{ Session::get('message') }}
    </div>
@endif
<form method="POST" action="/site-permit/new-site-entry" enctype="multipart/form-data"> 
@csrf
<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">Site Entry - Exit</h3>
    </div>
    <div class="card-body" style="border-bottom: 1px solid rgba(0, 0, 0, .125);">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" style="width: 100%;" required autofocus name="status">
                        <option selected disabled>--Select--</option>
                        <option value="CHECKIN">CHECKIN</option>
                        <option value="CHECKOUT">CHECKOUT</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Site</label>
                    <select class="form-control select2" style="width: 100%;" required autofocus name="id_site">
                        <option selected="selected" disabled value="">-- Select Site --</option>
                        @foreach(\App\Model\Site::get() as $site)
                            <option value="{{$site->site_id}}" @if(old('id_site') == $site->site_id) selected @endif>{{$site->name_site}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="waktu">Waktu</label>
                    <input type="datetime-local" class="form-control" name="entry_datetime" id="waktu" required autofocus>
                </div>
                <div class="form-group">
                    <b>Tag Gps</b> <label class="text-danger" style="font-size:0.79rem">* select from map</label>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Latitude</label>
                            <input class="set-latitude form-control" required autofocus placeholder="Latitude" name="latitude" readonly>
                        </div>
                        <div class="col-md-6">
                            <label>Longitude</label>
                            <input class="set-longitude form-control" required autofocus placeholder="Longitude" name="longitude" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="petugas">Personil</label>
                    <select class="form-control select2-multiple select_personil" style="width: 100%;" required autofocus name="personil[]" multiple>
                        @foreach(\App\User::get() as $u)
                            <option value="{{$u->id}}">{{$u->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="petugas">Jumlah Petugas</label>
                    <input type="number" class="form-control jumlah_petugas" name="jumlah_petugas" id="petugas" placeholder="Jumlah petugas" required autofocus readonly>
                </div>
                <div class="form-group">
                    <label for="petugas">Description</label>
                    <textarea class="form-control" placeholder="Description" name="description" rows="2" required autofocus></textarea>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-6">
                <div id='map'></div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
</form>
<!-- /.card -->

@endsection
@push('scripts')
<script>
    $('.select2').select2();
    $('.select2-multiple').select2({
        placeholder:'Select Personil'
    });
    $(document).ready(function(){
        loadMap();
        
        $(document).on('change', '.select_personil', function(){
            var ini = $(this);
                val = ini.val();
        
            $('.jumlah_petugas').val(val.length)
        })
    })
    
    <?php 
        $start_lat = '';
        $start_lng = '';
        $end_lat = '';
        $end_lng = '';
        
        echo "var start_lat = '$start_lat';";
        echo "var start_lng = '$start_lng';";
        echo "var end_lat = '$end_lat';";
        echo "var end_lng = '$end_lng';";
    ?>
    
    function loadMap(){
        // $('#selectLoaction').modal('show');
        
        mapboxgl.accessToken = 'pk.eyJ1Ijoic2hpbmxpYW5nIiwiYSI6ImNrOXc2emM2dzAzNjEzcW12bXY5dXVhcW0ifQ.GBiyrz_Em9yZHNtqyyoNDQ';
        var map = new mapboxgl.Map({
          container: 'map',
          style: 'mapbox://styles/mapbox/streets-v10',
          center: [106.865036, -6.17511],
          zoom: 5
        });
        //malay
        // var bounds = [[100.085756871, 0.773131415201], [119.181903925, 6.92805288332]];
        //sabah
        // var bounds = [[start_lng, start_lat], [end_lng, end_lat]]
        // map.setMaxBounds(bounds);
        var canvas = map.getCanvasContainer();
        
        var start = [106.865036, -6.17511];
        
        var geocoder = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            countries: 'id',
            marker: false,
            // bbox: [100.085, 0.773, 119.181, 6.928],
            // bbox: [start_lng, start_lat, end_lng, end_lat],
            mapboxgl: mapboxgl
        });
        
        map.on('load', function() {
            map.resize();
            map.on('click', function(e) {
                setMarker(canvas, map, 'CLICK' ,e);
            });
            geocoder.on('result', function(e) {
                var coor = e.result.geometry.coordinates;
                var lnglat = {
                    lng: coor[0],
                    lat: coor[1],
                }
                setMarker(canvas, map, 'SEARCH', lnglat);
            });
        });
    
        map.addControl(geocoder);
        
        map.addControl(new mapboxgl.NavigationControl());
        
        function setMarker(canvas,map, type ,coordsObj){
              if(type === "CLICK"){
                  var coordsObj = coordsObj.lngLat;
              }else{
                  var coordsObj = coordsObj;
              }
              canvas.style.cursor = '';
              var coords = Object.keys(coordsObj).map(function(key) {
                return coordsObj[key];
              });
              input_lng = $('.set-longitude');
              input_lat = $('.set-latitude');
              input_lng.val(coords[0]);
              input_lat.val(coords[1]);
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
@endpush
