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
                    <option value="">Status</option>
                    <option value="">Default 1</option>
                    <option value="">Default 2</option>
                    <option value="">Default 3</option>
                </select>
            </div>
        </div>
        <div class="row ml-4 mt-3">
            <div class="col-md-12">
                <select class="form-control">
                    <option value="">Region</option>
                    <option value="">Default 1</option>
                    <option value="">Default 2</option>
                    <option value="">Default 3</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <figure class="highcharts-figure">
            <div id="container"></div>
        </figure>
    </div>
</div>
<div class="row mt-3 ml-4 mb-3 mr-3">
    <div class="col-md-3">
        <label class="font-weight-bold">SITE KEEPING DAN PEMELIHARAAN AC</label>
        <div class="card" style="margin-top: 23px;">
            <div class="card-body">
                <h4>Total: 90</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <label class="font-weight-bold">PATROLI</label>
        <div class="card" style="margin-top: 23px;">
            <div class="card-body">
                <h4>Total: 56</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <label class="font-weight-bold">OTDR</label>
        <div class="card" style="margin-top: 23px;">
            <div class="card-body">
                <h4>Total: 70</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <label class="font-weight-bold">PM SITE</label>
        <div class="card" style="margin-top: 23px;">
            <div class="card-body">
                <h4>Total: 45</h4>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{asset('adminlte/plugins/morris/morris.min.js')}}"></script>
<script src="/js/chartSetup.js?d={{random_code(12)}}"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    // Data retrieved from https://gs.statcounter.com/browser-market-share#monthly-202201-202201-bar

    // Create the chart
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            align: 'left',
            text: 'TOTAL TASK PERIODE INI'
        },
        subtitle: {
            align: 'left',
            // text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'TOTAL TASK'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}%'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        },

        series: [
            {
                name: "",
                colorByPoint: true,
                data: [
                    {
                        name: "Total",
                        y: 63.06,
                        drilldown: "Total"
                    },
                    {
                        name: "Open",
                        y: 19.84,
                        drilldown: "Open"
                    },
                    {
                        name: "Accept",
                        y: 4.18,
                        drilldown: "Accept"
                    },
                    {
                        name: "Depart",
                        y: 4.12,
                        drilldown: "Depart"
                    },
                    {
                        name: "In Progress",
                        y: 2.33,
                        drilldown: "In Progress"
                    },
                    {
                        name: "Reject",
                        y: 0.45,
                        drilldown: "Reject"
                    },
                    {
                        name: "On Hold",
                        y: 1.582,
                        drilldown: "On Hold"
                    },
                    {
                        name: "Waiting Approve",
                        y: 1.582,
                        drilldown: "Waiting Approve"
                    },
                    {
                        name: "Approve",
                        y: 1.582,
                        drilldown: "Approve"
                    },
                    {
                        name: "Complete",
                        y: 1.582,
                        drilldown: "Completed"
                    },{
                        name: "Canceled",
                        y: 1.582,
                        drilldown: "Canceled"
                    }
                ]
            }
        ],
    });

</script>
@endpush
