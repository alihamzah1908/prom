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
</div>
<div class="card">
    <!-- <div class="col-md-6"> -->
    <div class="card-header">
        <div class="row">
            <div class="col-md-10">
                <div class="card-title">
                    <h5>SLA Paring Tengah Dashboard</h5>
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
                    <div class="card-body pt-2">
                        <div class="media border-top pt-3">
                            <img src="/images/available.png" class="avatar rounded mr-3" alt="shreyu">
                            <div class="media-body">
                                <h6 class="mt-1 mb-0 font-size-15">Avg Availability/Month %</h6>
                                <h6 class="mt-1 mb-0 font-size-15">96,62%</h6>
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
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body pt-2">
                        <div class="media border-top pt-3">
                            <img src="/images/reliability.png" class="avatar rounded mr-3" alt="shreyu">
                            <div class="media-body">
                                <h6 class="mt-1 mb-0 font-size-15">Avg Reliability/Month</h6>
                                <h6 class="mt-1 mb-0 font-size-15">6,35</h6>
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
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body pt-2">
                        <div class="media border-top pt-3">
                            <img src="/images/money.png" class="avatar rounded mr-3" alt="shreyu">
                            <div class="media-body">
                                <h6 class="mt-1 mb-0 font-size-15">Pembayaran Ketersediaan Layanan</h6>
                                <h6 class="mt-1 mb-0 font-size-15">24.197.362.300,6</h6>
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
        </div>

        <div class="row">
            <div class="col-xl-6">
                <figure class="highcharts-figure">
                    <div id="progress_bar"></div>
                </figure>
            </div>
            <div class="col-xl-6">
                <figure class="highcharts-figure">
                    <div id="progress_bar2"></div>
                </figure>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-xl-6">
                <figure class="highcharts-figure">
                    <div id="pbj-opex"></div>
                </figure>
            </div>
            <div class="col-xl-6">
                <figure class="highcharts-figure">
                    <div id="pbj-capex"></div>
                </figure>
            </div>
        </div>
        
        <div class="row">
            <div class="col">
                <figure class="highcharts-figure">
                    <div id="donut_chart_1"></div>
                </figure>
            </div>
            <div class="col">
                <figure class="highcharts-figure">
                    <div id="donut_chart_2"></div>
                </figure>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <figure class="highcharts-figure">
                    <div id="bar_chart"></div>
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

<script>
    function getRandomInt(max) {
        return Math.floor(Math.random() * max);
    }

    // PROGRAM & REALIZATION PBJ OPEX
    Highcharts.chart('pbj-opex', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Detail Monthly Availability'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'Mei',
                'Jun',
                'Jul',
                'Agu',
                'Sept',
                'Okt',
                'Nov',
                'Des'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Percentage %'
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
            name: 'Target',
            color: 'red',
            data: [{
                y: 28,
                color: 'red'
            }, {
                y: 57,
                color: 'red'
            }, {
                y: 64,
                color: 'red'
            }, {
                y: 32,
                color: 'red'
            }, {
                y: 44,
                color: 'red'
            }, {
                y: 35,
                color: 'red'
            }, {
                y: 48,
                color: 'red'
            }, {
                y: 80,
                color: 'red'
            }, {
                y: 94,
                color: 'red'
            }, {
                y: 95,
                color: 'red'
            }, {
                y: 98,
                color: 'red'
            }, {
                y: 85,
                color: 'red'
            }],

        }, {
            name: 'Availability',
            color: 'orange',
            data: [{
                    y: 12,
                    color: 'orange'
                },
                {
                    y: 54,
                    color: 'orange'
                }, {
                    y: 64,
                    color: 'orange'
                }, {
                    y: 30,
                    color: 'orange'
                }, {
                    y: 42,
                    color: 'orange'
                }, {
                    y: 30,
                    color: 'orange'
                }, {
                    y: 48,
                    color: 'orange'
                }, {
                    y: 80,
                    color: 'orange'
                }, {
                    y: 85,
                    color: 'orange'
                }, {
                    y: 95,
                    color: 'orange'
                }, {
                    y: 98,
                    color: 'orange'
                }, {
                    y: 82,
                    color: 'orange'
                }
            ]
        }]
    });

    // PROGRAM & REALIZATION PBJ CAPEX
    Highcharts.chart('pbj-capex', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Detail Monthly Reliability'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'Mei',
                'Jun',
                'Jul',
                'Agu',
                'Sept',
                'Okt',
                'Nov',
                'Des'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: ' Jumlah Pengadaan'
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
                borderRadius: 3
            },
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Target',
            color: 'red',
            data: [{
                y: 38,
                color: 'red'
            }, {
                y: 75,
                color: 'red'
            }, {
                y: 44,
                color: 'red'
            }, {
                y: 25,
                color: 'red'
            }, {
                y: 89,
                color: 'red'
            }, {
                y: 48,
                color: 'red'
            }, {
                y: 66,
                color: 'red'
            }, {
                y: 90,
                color: 'red'
            }, {
                y: 65,
                color: 'red'
            }, {
                y: 98,
                color: 'red'
            }, {
                y: 66,
                color: 'red'
            }, {
                y: 93,
                color: 'red'
            }],

        }, {
            name: 'Availability',
            color: '#0000CD',
            data: [{
                    y: 12,
                    color: '#0000CD'
                },
                {
                    y: 60,
                    color: '#0000CD'
                }, {
                    y: 44,
                    color: '#0000CD'
                }, {
                    y: 20,
                    color: '#0000CD'
                }, {
                    y: 70,
                    color: '#0000CD'
                }, {
                    y: 50,
                    color: '#0000CD'
                }, {
                    y: 48,
                    color: '#0000CD'
                }, {
                    y: 60,
                    color: '#0000CD'
                }, {
                    y: 60,
                    color: '#0000CD'
                }, {
                    y: 90,
                    color: '#0000CD'
                }, {
                    y: 50,
                    color: '#0000CD'
                }, {
                    y: 82,
                    color: '#0000CD'
                }
            ]
        }]
    });


    Highcharts.chart('progress_bar', {
        chart: {
            type: 'bar',
            height: 120
        },
        title: {
            text: 'Summary Availability',
            align: 'center',
            margin: 0
        },
        credits: false,
        legend: false,
        tooltip: false,
        plotOptions: {
            bar: {
                /* stacking: 'normal', */
                borderWidth: 0,
                borderRadius: 3
            }
        },
        xAxis: {
            visible: false
        },
        yAxis: {
            visible: true,
            min: 0,
            max: 100,
            title: {
                text: null
            },
            gridLineWidth: 0,
            labels: {
                y: -2
            }
        },
        series: [{
                name: "Fill",
                data: [100],
                color: "gray",
                grouping: false
                // enableMouseTracking: false, disable tooltip on just this data element
            },
            {
                name: "Percentage",
                data: [getRandomInt(100)],
                color: "orange",
                dataLabels: {
                    enabled: true,
                    inside: true,
                    align: 'right',
                    format: '{point.y}%',
                    style: {
                        color: 'white',
                        textOutline: false,
                    }
                }
            }
        ]
    });

    Highcharts.chart('progress_bar2', {
        chart: {
            type: 'bar',
            height: 120
        },
        title: {
            text: 'Summary Reliability',
            align: 'center',
            margin: 0
        },
        credits: false,
        legend: false,
        tooltip: false,
        plotOptions: {
            bar: {
                /* stacking: 'normal', */
                borderWidth: 0,
                borderRadius: 3
            }
        },
        xAxis: {
            visible: false
        },
        yAxis: {
            visible: true,
            min: 0,
            max: 100,
            title: {
                text: null
            },
            gridLineWidth: 0,
            labels: {
                y: -2
            }
        },
        series: [{
                name: "Fill",
                data: [100],
                color: "gray",
                grouping: false
                // enableMouseTracking: false, disable tooltip on just this data element
            },
            {
                name: "Percentage",
                data: [getRandomInt(100)],
                color: "orange",
                dataLabels: {
                    enabled: true,
                    inside: true,
                    align: 'right',
                    format: '{point.y}%',
                    style: {
                        color: 'white',
                        textOutline: false,
                    }
                }
            }
        ]
    });

    Highcharts.chart('donut_chart_1', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Pengadaan Lokal/Impor'
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
                ['Impor Inklaring', getRandomInt(100)],
                ['Lokal', getRandomInt(100)],
                ['Impor Non-Inklaring', getRandomInt(100)],
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
            text: 'Top 5 Vendor'
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
                ['PT. RESKA MULTI USAHA', getRandomInt(100)],
                ['PT. SIGMA CIPTA CARAKA', getRandomInt(100)],
                ['PT. ICON+', getRandomInt(100)],
                ['PT. TELKOM INDONESIA', getRandomInt(100)],
                ['PT. SURVEYOR INDONESIA', getRandomInt(100)],
            ]
        }]
    });

    const mitraLinks = {
        'Mitra A': '/dashboard-pelaksanaan-monev-mitra/mitra-a',
        'Mitra B': '/dashboard-pelaksanaan-monev-mitra/mitra-b',
        'Mitra Z': '/dashboard-pelaksanaan-monev-mitra/mitra-z',
    };

    Highcharts.chart('bar_chart', {
        chart: {
            type: 'bar'
        },
        colors: ['#c9962f'],
        title: {
            text: 'Top 3 Out of SLA'
        },
        xAxis: {
            categories: ['Pengadaan Asuransi (16165)', 'Pengadaan Infrastruktur DC dan DRC (16105)', 'Pengadaan Pemeliharaan Kereta (16092)'],
            title: {
                text: null
            },
            labels: {
                formatter: function() {
                    return '<a href="' + mitraLinks[this.value] + '">' +
                        this.value + '</a>';
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Hari  ',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ''
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Jumlah Hari',
            data: [getRandomInt(100), getRandomInt(100), getRandomInt(100)]
        }, ]
    });
</script>

@endpush