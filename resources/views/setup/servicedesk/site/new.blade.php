@extends('setup.servicedesk.service_desk')
@section('title', 'Site')
@section('title_menu', 'Servicedesk Configurations')

@section('service_desk_content')
@include('sweetalert::alert')
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

    <div class="content_header">
        <div class="content_menu">
            <h4 class="title_2">Site</h4>
            <form action="{{ route('sites.add') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Site Form</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                    <label for="uid_site" class="text_name">SID</label>
                                    <input name="uid_site" type="text" value="{{ old('uid_site') }}"
                                        class="placeholder_color form-control @error('uid_site') is-invalid invalid @enderror"
                                        id="uid_site" aria-describedby="uid_site" placeholder="UID">
                                    @error('name_site')
                                    <span class="invalid" style="color: red"><i>{{$message}}</i></span>
                                    @enderror
                                </div>
                            <div class="form-group">
                                <label for="name_site" class="text_name">Site Nama</label>
                                <input name="name_site" type="text" value="{{ old('name_site') }}"
                                    class="placeholder_color form-control @error('name_site') is-invalid invalid @enderror"
                                    id="name_site" aria-describedby="namaHelp" placeholder="Name">
                                @error('name_site')
                                <span class="invalid" style="color: red"><i>{{$message}}</i></span>
                                @enderror
                            </div>
        
                            <div class="form-group">
                                <label for="region_name" class="text_name form-control-label">Region Name</label>
                                <select class="form-control searchRegion select2" id="region_name"  name="region_name"></select>
                                <p class="text-danger">{{ $errors->first('participant_id') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="id_site_category" class="text_name form-control-label">Site Category Name</label>
                                <select class="form-control select2" id="id_site_category" name="id_site_category">
                                    @foreach(\App\Model\Site_Cat::get() as $site_cat)
                                        <option value="{{$site_cat->site_cat_id}}">
                                            {{$site_cat->site_cat_name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="head_manager" class="text_name">Head Manager</label>
                                <select class="form-control select2" id="head_manager" name="head_manager">
                                    @foreach(\App\User::get() as $head_manager)
                                        <option value="{{$head_manager->id}}">
                                            {{$head_manager->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <b>Coordinates</b> <label class="text-danger" style="font-size:0.79rem">* select from map</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Latitude</label>
                                        <input class="set-latitude form-control" required autofocus placeholder="Latitude" name="latitude">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Longitude</label>
                                        <input class="set-longitude form-control" required autofocus placeholder="Longitude" name="longitude">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea name="address" class="form-control @error('address') is-invalid invalid @enderror" id="address" rows="3" placeholder="Place your Addres">{{ old('address') }}</textarea>
                                @error('address')
                                <span class="invalid">{{ $errors->first('address') }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid invalid @enderror" id="address" rows="3" placeholder="Place your description">{{ old('description') }}</textarea>
                                @error('description')
                                <span class="invalid">{{ $errors->first('description') }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="kapasitas_kwh">Kapasitas Kwh (Kwh)</label>
                                <input type="number" name="kapasitas_kwh"  value="{{ old('kapasitas_kwh') }}" class="form-control @error('kapasitas_kwh') is-invalid invalid @enderror" placeholder="tambahkan misal : 13200">{{ old('kapasitas_kwh') }}</input>
                                @error('kapasitas_kwh')
                                <span class="invalid">{{ $errors->first('kapasitas_kwh') }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="kapasitas_genset">Kapasitas Genset (Kw)</label>
                                <input type="number" name="kapasitas_genset"  value="{{ old('kapasitas_genset') }}" class="form-control @error('kapasitas_genset') is-invalid invalid @enderror" placeholder=" tambahkan misal : 13">{{ old('kapasitas_genset') }}</input>
                                @error('kapasitas_genset')
                                <span class="invalid">{{ $errors->first('kapasitas_genset') }}</span>
                                @enderror
                            </div>
                            
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-6">
                            <div id='map'></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    $('.select2').select2()
    $(".searchRegion").select2({
        placeholder:"Place your region name",
        ajax: {
            url: "/getRegion",
            dataType: "json",
            delay: 150,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                            item_text =  item.region_name;
                            return {
                                text: item_text,
                                id: item.region_id
                            };
                    })
                };
            },
            cache: false
        }
    }).on('change', function (e) {

    });
    
    $("#searchCatSite").select2({
        placeholder:"Place your category name",
        ajax: {
            url: "/getSiteCat",
            dataType: "json",
            delay: 150,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                            item_text =  item.site_cat_name;
                            return {
                                text: item_text,
                                id: item.site_cat_id
                            };
                    })
                };
            },
            cache: false
        }
    }).on('change', function (e) {

    });
</script>
<script>
    $(document).ready(function(){
        loadMap();
    });
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
        var canvas = map.getCanvasContainer();
        
        var start = [106.865036, -6.17511];
        
        var geocoder = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            countries: 'id',
            marker: false,
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

        function setSelectedMarker(canvas,map, type, coords){
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
        
        $(document).on('change', '.set-latitude', function(e){
            var ini = $(this);
                latitude = ini.val();
                longitude = $('.set-longitude').val();
            
            setMapByInput(latitude, longitude);
        });
        $(document).on('change', '.set-longitude', function(e){
            var ini = $(this);
                longitude = ini.val();
                latitude = $('.set-latitude').val();
            
            setMapByInput(latitude, longitude);
        });
        
        function setMapByInput(latitude, longitude){
            if(longitude && latitude){
                coords = [longitude, latitude];
                setSelectedMarker(canvas, map, 'CLICK' , coords);
            }
        }
    }
</script>
@endpush




