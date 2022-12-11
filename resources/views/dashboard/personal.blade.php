@extends('template.default')
@section('submenu')
<!-- <div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="m-0 text-dark">{{ __('dasboard1.dasboard_language') }}</h3>
    </div>
</div> -->
@endsection
@section('content')
<div class="row mt-3">
    <div class="col-md-4">
        <div class="row ml-4">
            <div class="col-md-12">
                <h5>TASK MONITRING</h5>
            </div>
        </div>
        <div class="row ml-4">
            <div class="col-md-12">
                <select class="form-control">
                    <option value="">1 Nov 2022 - 22 Nov 2022</option>
                    <option value="">1 Nov 2022 - 23 Nov 2022</option>
                    <option value="">1 Nov 2022 - 24 Nov 2022</option>
                    <option value="">1 Nov 2022 - 15 Nov 2022</option>
                </select>
            </div>
        </div>
        <div class="row ml-4 mt-3">
            <div class="col-md-12">
                <select class="form-control">
                    <option value="">Page Title</option>
                    <option value="">Default 1</option>
                    <option value="">Default 2</option>
                    <option value="">Default 3</option>
                </select>
            </div>
        </div>
        <div class="row ml-4 mt-3">
            <div class="col-md-12">
                <select class="form-control">
                    <option value="">Project</option>
                    <option value="">Project 4</option>
                    <option value="">Default 5</option>
                    <option value="">Default 6</option>
                    <option value="">Default 7</option>
                </select>
            </div>
        </div>
        <div class="row ml-4 mt-3">
            <div class="col-md-12">
                <select class="form-control">
                    <option value="">Technician</option>
                    <option value="">Sendi Yosafat</option>
                    <option value="">Yohanes Lone Jawan</option>
                    <option value="">Yosep Arakian L</option>
                    <option value="">Yulius Kifta</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="row ml-4">
            <div class="col-md-12">
                <h5>JUMLAH PERSONNEL</h5>
            </div>
        </div>
        <div class="row ml-4">
            <div class="col-md-2">
                <label class="font-weight-bold"></label>
                <div class="card" style="margin-top: 23px;">
                    <div class="card-body">
                        <h4>P4 90</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <label class="font-weight-bold"></label>
                <div class="card" style="margin-top: 23px;">
                    <div class="card-body">
                        <h4>P5 56</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <label class="font-weight-bold"></label>
                <div class="card" style="margin-top: 23px;">
                    <div class="card-body">
                        <h4>P6 70</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <label class="font-weight-bold"></label>
                <div class="card" style="margin-top: 23px;">
                    <div class="card-body">
                        <h4>P7 45</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <label class="font-weight-bold"></label>
                <div class="card" style="margin-top: 23px;">
                    <div class="card-body">
                        <h4>P8 45</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div id="googleMap" style="width:100%;height:400px;"></div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <figure class="highcharts-figure">
            <div id="container"></div>
        </figure>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{asset('adminlte/plugins/morris/morris.min.js')}}"></script>
<script src="/js/chartSetup.js?d={{random_code(12)}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHk8TcFd2qqIC3m-P4cMj0lSiDuiVdvdI&callback=initMap"></script>
<script>
    // fungsi initialize untuk mempersiapkan peta
    function initialize() {
        var propertiPeta = {
            center: new google.maps.LatLng(-0.789275, 113.921327),
            zoom: 5,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);
    }

    // event jendela di-load  
    google.maps.event.addDomListener(window, 'load', initialize);
</script>
<script>
    Highcharts.chart('container', {
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Achievement'
        },
        xAxis: {
            categories: ['Elias', 'Emanuel', 'Sendi Yosafat', 'Servasius Tuka Uran', 'Servasius Tuka Uran']
        },
        yAxis: {
            min: 0,
            title: {
                text: '% (percent)'
            }
        },
        legend: {
            reversed: true
        },
        plotOptions: {
            series: {
                stacking: 'normal'
            }
        },
        series: [{
            name: 'Achievment (%)',
            data: [4, 4, 6, 15, 12]
        }]
    });
</script>
@endpush