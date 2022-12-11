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
            <div class="col-md-10">
                <div class="card-title">
                    <h5>Trouble Ticket Progress Tracking</h5>
                </div>
            </div>

            <div class="col-md-2 d-flex justify-content-end">
                <!-- <label for="exampleInputEmail1" class="font-weight-bold">Tahun</label> -->
                <select class="form-control type-metode" name="type_metode">
                    <option value="">Tahun</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <!-- <option value="3">Pelelangan Terbuka</option> -->
                </select>
            </div>
        </div>

        <!-- </div> -->
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body pt-5">
                        <div class="media border-top pt-3">
                            <img src="/images/progress.png" class="avatar rounded mr-3" alt="shreyu">
                            <div class="media-body">
                                <h6 class="mt-1 mb-0 font-size-15">PROGRES HARI INI</h6>
                                <h7 class="mt-1 mb-0 font-size-15">Diambil dari ticketing system</h7>
                            </div>
                            <div class="dropdown align-self-center float-right">
                                <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown" aria-expanded="false">
                                    <i class="uil uil-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <!-- item-->
                                    <a href="#" class="dropdown-item"><i class="uil uil-edit-alt mr-2"></i>Scouting</a>
                                    <a href="#" class="dropdown-item"><i class="uil uil-edit-alt mr-2"></i>Testing</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <figure class="highcharts-figure">
                    <div id="remaining-time"></div>
                </figure>
            </div>
            <div class="col-xl-4">
                <figure class="highcharts-figure">
                    <div id="progres-pekerjaan"></div>
                </figure>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
            <figure class="highcharts-figure">
                <div class="row">
                    <div class="col-md-4 ml-4 mt-4 mb-4">
                        <select class="form-control">
                            <option value="">Request Status</option>
                            <option value="">Default 1</option>
                            <option value="">Default 2</option>
                            <option value="">Default 3</option>
                        </select>
                    </div>
                    <div class="col-md-4 mt-4 mb-4">
                        <select class="form-control">
                            <option value="">Region</option>
                            <option value="">Default 1</option>
                            <option value="">Default 2</option>
                            <option value="">Default 3</option>
                        </select>
                    </div>
                    <div class="col-md-3 mt-4 mb-4">
                        <select class="form-control">
                            <option value="">Priority</option>
                            <option value="">Default 1</option>
                            <option value="">Default 2</option>
                            <option value="">Default 3</option>
                        </select>
                    </div>
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
            </figure>
            </div>
        </div>

    </div>
</div>

@endsection
@push('styles')
<style>
    #progress_bar {
        width: 420px;
        margin: 20px auto;
    }

    #monitoring_online_offline {
        height: 450px;
    }

    #timeline {
    height: 300px;
    }

    .highcharts-figure,
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>

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