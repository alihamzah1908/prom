@extends('layouts.master')

@section('content')
<div class="card">
    <!-- <div class="col-md-6"> -->
    <div class="card-header">
        <div class="row">
            <div class="col-md-10">
                <div class="card-title">
                    <h5>Contract Monitoring Dashboard</h5>
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
            <div class="col-xl-2">
                <div class="card">
                    <div class="card-body pt-2">
                        <div class="media border-top pt-3">
                            <img src="../assets/images/jamlak.png" class="avatar rounded mr-3" alt="shreyu">
                            <div class="media-body">
                                <label>Menunggu Jamlak</label>
                                <h6 class="mt-1 mb-0 font-size-15">10</h6>
                            </div>
                            <div class="dropdown align-self-center float-right">
                                <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown" aria-expanded="false">
                                    <i class="uil uil-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item"><i class="uil uil-edit-alt mr-2"></i>Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2">
                <div class="card">
                    <div class="card-body pt-2">
                        <div class="media border-top pt-3">
                            <img src="../assets/images/legal.png" class="avatar rounded mr-3" alt="shreyu">
                            <div class="media-body">
                                <label>Review Legal</label>
                                <h6 class="mt-1 mb-0 font-size-15">12</h6>
                            </div>
                            <div class="dropdown align-self-center float-right">
                                <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown" aria-expanded="false">
                                    <i class="uil uil-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item"><i class="uil uil-edit-alt mr-2"></i>Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2">
                <div class="card">
                    <div class="card-body pt-2">
                        <div class="media border-top pt-3">
                            <img src="../assets/images/appLegal.png" class="avatar rounded mr-3" alt="shreyu">
                            <div class="media-body">
                                <!-- <h6 class="mt-1 mb-0 font-size-15">Approval</h6> -->
                                <label>Approval Legal</label>
                                <h6 class="mt-1 mb-0 font-size-15">9</h6>
                            </div>
                            <div class="dropdown align-self-center float-right">
                                <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown" aria-expanded="false">
                                    <i class="uil uil-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item"><i class="uil uil-edit-alt mr-2"></i>Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2">
                <div class="card">
                    <div class="card-body pt-2">
                        <div class="media border-top pt-3">
                            <img src="../assets/images/appuser.png" class="avatar rounded mr-3" alt="shreyu">
                            <div class="media-body">
                                <label>Approval User</label>
                                <h6 class="mt-1 mb-0 font-size-15">5</h6>
                            </div>
                            <div class="dropdown align-self-center float-right">
                                <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown" aria-expanded="false">
                                    <i class="uil uil-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item"><i class="uil uil-edit-alt mr-2"></i>Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2">
                <div class="card">
                    <div class="card-body pt-2">
                        <div class="media border-top pt-3">
                            <img src="../assets/images/sign.png" class="avatar rounded mr-3" alt="shreyu">
                            <div class="media-body">
                                <label>TTD Vendor</label>
                                <h6 class="mt-1 mb-0 font-size-15">35</h6>
                            </div>
                            <div class="dropdown align-self-center float-right">
                                <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown" aria-expanded="false">
                                    <i class="uil uil-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item"><i class="uil uil-edit-alt mr-2"></i>Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2">
                <div class="card">
                    <div class="card-body pt-2">
                        <div class="media border-top pt-3">
                            <img src="../assets/images/contract.png" class="avatar rounded mr-3" alt="shreyu">
                            <div class="media-body">
                                <label>Contract Completed</label>
                                <h6 class="mt-1 mb-0 font-size-15 contract-complete"></h6>
                            </div>
                            <div class="dropdown align-self-center float-right">
                                <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown" aria-expanded="false">
                                    <i class="uil uil-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <!-- item-->
                                    <a href="{{ route('list.contract-complete') }}" class="dropdown-item"><i class="uil uil-edit-alt mr-2"></i>Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <figure class="highcharts-figure">
                    <div id="pbj-opex"></div>
                </figure>
            </div>
            <div class="col">
                <figure class="highcharts-figure">
                    <div id="donut_chart_1"></div>
                </figure>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <figure class="highcharts-figure">
                    <div id="donut_chart_2"></div>
                </figure>
            </div>
            <div class="col">
                <figure class="highcharts-figure">
                    <div id="container"></div>
                </figure>
            </div>
        </div>
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
    function getRandomInt(max) {
        return Math.floor(Math.random() * max);
    }
    //contract count
    $(document).ready(function(){
        $.ajax({
        url : '{{ route("total.complete")}}',
        dataType: 'json',
            method: 'get',
        }).done(function(response){
            $('.contract-complete').html(response.total_contract_complete[0]["count"])
        })
    })


    var seriesData = [];
    seriesData.push({
        name: "Pemilihan Langsung",
        data: [{
            y: 19,
            color: 'red'
        }, {
            y: 16,
            color: 'red'
        }],
        url: "{{ route('task.approval') }}",
        color: 'red'
    });
    seriesData.push({
        name: "Penunjukan Langsung",
        data: [{
            y: 17,
            color: 'blue'
        }, {
            y: 19,
            color: 'blue'
        }],
        url: "{{ route('task.approval') }}",
        color: 'blue'
    });
    seriesData.push({
        name: "Lelang Terbuka",
        data: [{
            y: 16,
            color: 'orange'
        }, {
            y: 18,
            color: 'orange'
        }],
        url: "{{ route('task.approval') }}",
        color: 'orange'
    });
    // PROGRAM & REALIZATION PBJ OPEX
    Highcharts.chart('pbj-opex', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Contract by Ammount'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [
                'CUS',
                'CFH',
                'CTI',
                'CTP',
                'CTS',
                'COC',
                'COH',
                'COS',
                'COT',
                'COLA',
                'KERETA BANDARA',
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Ammount (Milyar) Rp'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} value</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            series: {
                borderRadius: 3,
            },
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Sarana',
            color: 'red',
            data: [{
                y: 49.9,
                color: 'red'
            }, {
                y: 71.5,
                color: 'red'
            }, {
                y: 106.4,
                color: 'red'
            }, {
                y: 129.2,
                color: 'red'
            }, {
                y: 144.0,
                color: 'red'
            }, {
                y: 135.6,
                color: 'red'
            }, {
                y: 148.5,
                color: 'red'
            }, {
                y: 216.4,
                color: 'red'
            }, {
                y: 194.1,
                color: 'red'
            }, {
                y: 95.6,
                color: 'red'
            }],

        }, {
            name: 'Non Sarana',
            color: 'orange',
            data: [{
                    y: 83.6,
                    color: 'orange'
                },
                {
                    y: 78.8,
                    color: 'orange'
                }, {
                    y: 93.4,
                    color: 'orange'
                }, {
                    y: 98.5,
                    color: 'orange'
                }, {
                    y: 106.0,
                    color: 'orange'
                }, {
                    y: 84.5,
                    color: 'orange'
                }, {
                    y: 105.0,
                    color: 'orange'
                }, {
                    y: 91.2,
                    color: 'orange'
                }, {
                    y: 83.5,
                    color: 'orange'
                }, {
                    y: 106.6,
                    color: 'orange'
                }
            ]
        }]
    });

    Highcharts.chart('donut_chart_1', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Contract By Category Ammount'
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
                innerSize: '60%',
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            name: 'Jumlah',
            data: [
                ['Ammount <1M', getRandomInt(100)],
                ['1M - 5M', getRandomInt(100)],
                ['Ammount >5M', getRandomInt(100)],
            ]
        }]
    });

    Highcharts.chart('donut_chart_2', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Contract By Ammount'
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
                innerSize: '60%',
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            name: 'Unit',
            data: [
                ['Sarana', getRandomInt(100)],
                ['Non-Sarana', getRandomInt(100)],
            ]
        }]
    });

    Highcharts.chart('container', {
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Contract by Count'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: ['SARANA', 'NON-SARANA'],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: '',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' total'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            },
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
            shadow: true
        },
        plotOptions: {
            series: {
                borderRadius: 15,
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            var point = this;

                            if (point.url) {
                                window.open(point.url);
                            } else if (point.series.userOptions.url) {
                                window.open(point.series.userOptions.url);
                            }
                        }
                    }
                }

            }

        },
        series: seriesData
    });
</script>
@endpush