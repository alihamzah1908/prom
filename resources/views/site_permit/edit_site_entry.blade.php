
<div class="row">
    <div class="col-md-5">
        <div class="form-group">
            <label>Status</label>
            <select class="form-control" style="width: 100%;" required autofocus name="status">
                <option selected disabled>--Select--</option>
                <option value="CHECKIN" {{$data->status == "CHECKIN" ? 'selected':''}}>CHECKIN</option>
                <option value="CHECKOUT" {{$data->status == "CHECKOUT" ? 'selected':''}}>CHECKOUT</option>
            </select>
        </div>
        <div class="form-group">
            <label>Site</label>
            <select class="form-control select2" style="width: 100%;" required autofocus name="id_site">
                <option selected="selected" disabled value="">-- Select Site --</option>
                @foreach(\App\Model\Site::get() as $site)
                    <option value="{{$site->site_id}}" @if($data->id_site == $site->site_id) selected @endif>{{$site->name_site}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="waktu">Waktu</label>
            <input type="datetime-local" class="form-control" name="entry_datetime" id="waktu" required autofocus value="{{\Carbon\Carbon::parse($data->entry_datetime)->format('Y-m-d\TH:i')}}">
        </div>
        <div class="form-group">
            <label for="petugas">Jumlah Petugas</label>
            <input type="number" class="form-control" name="jumlah_petugas" id="petugas" placeholder="Jumlah petugas" required autofocus value="{{$data->jumlah_petugas}}">
        </div>
        <div class="form-group">
            <b>Tag Gps</b> <label class="text-danger" style="font-size:0.79rem">* select from map</label>
            <div class="row">
                <div class="col-md-6">
                    <label>Latitude</label>
                    <input class="set-latitude form-control" required autofocus placeholder="Latitude" name="latitude" value="{{$data->latitude}}">
                </div>
                <div class="col-md-6">
                    <label>Longitude</label>
                    <input class="set-longitude form-control" required autofocus placeholder="Longitude" name="longitude" value="{{$data->longitude}}">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="petugas">Personil</label>
            <select class="form-control select2-multiple" style="width: 100%;" required autofocus name="personil[]" multiple>
                <?php 
                $personils = json_decode($data->personil);
                if(!$personils) $personils = [];
                if(!is_array($personils)) $personils = [];
                ?>
                @foreach(\App\User::get() as $u)
                    <option value="{{$u->id}}" {{in_array($u->id, $personils) ? 'selected':''}}>{{$u->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="petugas">Description</label>
            <textarea class="form-control" placeholder="Description" name="description" rows="2" required autofocus>{{$data->description}}</textarea>
        </div>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-6">
        <div id='map'></div>
    </div>
</div>
    
    

<script>
    $('.select2').select2();
    $('.select2-multiple').select2({
        placeholder:'Select Personil'
    });
    $(document).ready(function(){
        loadMapEdit()
    })
    
    <?php 
        echo "var coords = [$data->longitude, $data->latitude];";
    ?>
    
    function loadMapEdit(){
        mapboxgl.accessToken = 'pk.eyJ1Ijoic2hpbmxpYW5nIiwiYSI6ImNrOXc2emM2dzAzNjEzcW12bXY5dXVhcW0ifQ.GBiyrz_Em9yZHNtqyyoNDQ';
        var map = new mapboxgl.Map({
          container: 'map',
          style: 'mapbox://styles/mapbox/streets-v10',
          center: coords,
          zoom: 5
        });
        var canvas = map.getCanvasContainer();
        
        var geocoder = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            countries: 'id',
            marker: false,
            mapboxgl: mapboxgl
        });
        
        map.on('load', function() {
            map.resize();
            setSelectedMarker(canvas, map, 'CLICK' ,coords);
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

