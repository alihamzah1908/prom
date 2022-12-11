@extends('template.default')
@section('submenu')
<!-- <div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="m-0 text-dark">{{ __('dasboard1.dasboard_language') }}</h3>
    </div>
</div> -->
@endsection
@section('content')
<div class="card">
    <!-- <div class="col-md-6"> -->
    <div class="card-header">
        <div class="row">
            <div class="col-md-4">
                <div class="card-title">
                    <h5>Trouble Ticket Monitoring</h5>
                </div>
            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-2">
                <select class="form-control type-metode" name="type_metode">
                    <option value="">Request Status</option>
                    <option value="Open">Open</option>
                    <option value="On Hold">On Hold</option>
                    <option value="In Progress">In Progress</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control type-metode" name="type_metode">
                    <option value="">Region</option>
                    <option value="Project 8A">Project 8A</option>
                    <option value="Project 7">Project 7</option>
                    <option value="Project 4">Project 4</option>
                    <option value="Project 5">Project 5</option>
                    <option value="Project 8B">Project 8B</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control type-metode" name="type_metode">
                    <option value="">Priority</option>
                    <option value="P2">P2</option>
                    <option value="P3">P3</option>
                </select>
            </div>
        </div>
        <div class="card">
        </div>
        <div class="row">
                    <div class="col-md-4">
                        <div id="submarine"></div>
                    </div>
                    <div class="col-md-4">
                        <div id="inland"></div>
                    </div>
                    <div class="col-md-4">
                        <div id="mw"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div id="power"></div>
                    </div>
                    <div class="col-md-4">
                        <div id="hardware"></div>
                    </div>
                </div>
                <div class="row ml-2 mr-2 mt-4">
                    <div class="col-md-12">
                        <table class="table table-stripped">
                            <thead class="thead-light">
                                <tr>
                                    <th>Region</th>
                                    <th>Category</th>
                                    <th>Priority</th>
                                    <th>Request Status</th>
                                    <th>Sub Category</th>
                                    <th>Subject</th>
                                    <th>Resolved Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Project 4</td>
                                    <td>Hardware</td>
                                    <td>P2</td>
                                    <td>OPEN</td>
                                    <td>Microwave</td>
                                    <td>P2_Module CSHL Faulty</td>
                                    <td>Not Assigned</td>
                                </tr>
                                <tr>
                                    <td>Project 5</td>
                                    <td>Hardware</td>
                                    <td>P2</td>
                                    <td>OPEN</td>
                                    <td>Microwave</td>
                                    <td>P2_Module CSHL Faulty</td>
                                    <td>Not Assigned</td>
                                </tr>
                                <tr>
                                    <td>Project 6</td>
                                    <td>Hardware</td>
                                    <td>P2</td>
                                    <td>OPEN</td>
                                    <td>Microwave</td>
                                    <td>P2_Module CSHL Faulty</td>
                                    <td>Not Assigned</td>
                                </tr>
                                <tr>
                                    <td>Project 7</td>
                                    <td>Hardware</td>
                                    <td>P2</td>
                                    <td>OPEN</td>
                                    <td>Microwave</td>
                                    <td>P2_Module CSHL Faulty</td>
                                    <td>Not Assigned</td>
                                </tr>
                                <tr>
                                    <td>Project 8</td>
                                    <td>Hardware</td>
                                    <td>P2</td>
                                    <td>OPEN</td>
                                    <td>Microwave</td>
                                    <td>P2_Module CSHL Faulty</td>
                                    <td>Not Assigned</td>
                                </tr>
                                <tr>
                                    <td>Project 9</td>
                                    <td>Hardware</td>
                                    <td>P2</td>
                                    <td>OPEN</td>
                                    <td>Microwave</td>
                                    <td>P2_Module CSHL Faulty</td>
                                    <td>Not Assigned</td>
                                </tr>
                                <tr>
                                    <td>Project 10</td>
                                    <td>Hardware</td>
                                    <td>P2</td>
                                    <td>OPEN</td>
                                    <td>Microwave</td>
                                    <td>P2_Module CSHL Faulty</td>
                                    <td>Not Assigned</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
    </div>
    <div class="card-body">
        
        
    </div>
</div>
@endsection
@push('styles')
<style>
    #monitoring_online_offline {
        height: 450px;
    }

    .highcharts-data-table table {
        min-width: 310px;
        max-width: 800px;
        margin: 1em auto;
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #ebebeb;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }

    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }

    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }

    .highcharts-data-table td,
    .highcharts-data-table th,
    .highcharts-data-table caption {
        padding: 0.5em;
    }

    .highcharts-data-table thead tr,
    .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }

    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    // SUBMARINE
    Highcharts.chart('submarine', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Submarine'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [{
                name: 'Project 7',
                y: 74.77,
                sliced: true,
                selected: true
            }, {
                name: 'Project 8A',
                y: 12.82
            }, {
                name: 'Project 8b',
                y: 4.63
            }]
        }]
    });


    // INLAND
    Highcharts.chart('inland', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Inland'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [{
                name: 'Project 6',
                y: 74.77,
                sliced: true,
                selected: true
            }, {
                name: 'Project 6A',
                y: 43.82
            }]
        }]
    });

    // MW
    Highcharts.chart('mw', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'MW'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [{
                name: 'Project 4',
                y: 74.77,
                sliced: true,
                selected: true
            }]
        }]
    });

    // POWER
    Highcharts.chart('power', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Power'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [{
                name: 'Project 4',
                y: 74.77,
                sliced: true,
                selected: true
            },{
                name: 'Project 3B',
                y: 23.77,
                sliced: true,
                selected: true
            }]
        }]
    });

    // HARDWARE
    Highcharts.chart('hardware', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Hardware'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'Hardware',
            colorByPoint: true,
            data: [{
                name: 'Project 4',
                y: 74.77,
                sliced: true,
                selected: true
            },{
                name: 'Project 2A',
                y: 32.77,
                sliced: true,
                selected: true
            },{
                name: 'Project 2A',
                y: 21.77,
                sliced: true,
                selected: true
            }]
        }]
    });
</script>
@endpush
