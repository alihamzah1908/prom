@extends('template.default')
@section('submenu')
<!-- <div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="m-0 text-dark">{{ __('dasboard1.dasboard_language') }}</h3>
    </div>
</div> -->
@endsection

@section('content')
<div class="card mt-3">
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
                <figure class="highcharts-figure">
                    <div id="container"></div>
                </figure>
                <!-- <div class="card">
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
                                    item
                                    <a href="#" class="dropdown-item"><i class="uil uil-edit-alt mr-2"></i>Scouting</a>
                                    <a href="#" class="dropdown-item"><i class="uil uil-edit-alt mr-2"></i>Testing</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            <div class="col-xl-4">
                <figure class="highcharts-figure">
                    <div id="donut_chart_1"></div>
                </figure>
            </div>
            <div class="col-xl-4">
                <figure class="highcharts-figure">
                    <div id="donut_chart_2"></div>
                </figure>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <figure class="highcharts-figure">
                    <div id="timeline"></div>
                </figure>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <figure class="highcharts-figure">
                    <div id="x-range"></div>
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

    #donut_chart_2 {
        width: 600px;
    }

    #donut_chart_1 {
        width: 600px;
    }

    #timeline {
        height: 300px;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/modules/timeline.js"></script>
<script src="https://code.highcharts.com/modules/xrange.js"></script>
<script>
    function renderIcons() {

        // Move icon
        if (!this.series[0].icon) {
            this.series[0].icon = this.renderer.path(['M', -8, 0, 'L', 8, 0, 'M', 0, -8, 'L', 8, 0, 0, 8])
                .attr({
                    stroke: '#303030',
                    'stroke-linecap': 'round',
                    'stroke-linejoin': 'round',
                    'stroke-width': 2,
                    zIndex: 10
                })
                .add(this.series[2].group);
        }
        this.series[0].icon.translate(
            this.chartWidth / 2 - 10,
            this.plotHeight / 2 - this.series[0].points[0].shapeArgs.innerR -
            (this.series[0].points[0].shapeArgs.r - this.series[0].points[0].shapeArgs.innerR) / 2
        );

        // Exercise icon
        if (!this.series[1].icon) {
            this.series[1].icon = this.renderer.path(
                    ['M', -8, 0, 'L', 8, 0, 'M', 0, -8, 'L', 8, 0, 0, 8,
                        'M', 8, -8, 'L', 16, 0, 8, 8
                    ]
                )
                .attr({
                    stroke: '#ffffff',
                    'stroke-linecap': 'round',
                    'stroke-linejoin': 'round',
                    'stroke-width': 2,
                    zIndex: 10
                })
                .add(this.series[2].group);
        }
        this.series[1].icon.translate(
            this.chartWidth / 2 - 10,
            this.plotHeight / 2 - this.series[1].points[0].shapeArgs.innerR -
            (this.series[1].points[0].shapeArgs.r - this.series[1].points[0].shapeArgs.innerR) / 2
        );

        // Stand icon
        if (!this.series[2].icon) {
            this.series[2].icon = this.renderer.path(['M', 0, 8, 'L', 0, -8, 'M', -8, 0, 'L', 0, -8, 8, 0])
                .attr({
                    stroke: '#303030',
                    'stroke-linecap': 'round',
                    'stroke-linejoin': 'round',
                    'stroke-width': 2,
                    zIndex: 10
                })
                .add(this.series[2].group);
        }

        this.series[2].icon.translate(
            this.chartWidth / 2 - 10,
            this.plotHeight / 2 - this.series[2].points[0].shapeArgs.innerR -
            (this.series[2].points[0].shapeArgs.r - this.series[2].points[0].shapeArgs.innerR) / 2
        );
    }

    Highcharts.chart('container', {

        chart: {
            type: 'solidgauge',
            height: '110%',
            events: {
                render: renderIcons
            }
        },

        title: {
            text: 'Progress Hari Ini',
            style: {
                fontSize: '24px'
            }
        },

        tooltip: {
            borderWidth: 0,
            backgroundColor: 'none',
            shadow: false,
            style: {
                fontSize: '16px'
            },
            valueSuffix: '%',
            pointFormat: '{series.name}<br><span style="font-size:2em; color: {point.color}; font-weight: bold">{point.y}</span>',
            positioner: function(labelWidth) {
                return {
                    x: (this.chart.chartWidth - labelWidth) / 2,
                    y: (this.chart.plotHeight / 2) + 15
                };
            }
        },

        pane: {
            startAngle: 0,
            endAngle: 360,
            background: [{ // Track for Move
                outerRadius: '112%',
                innerRadius: '88%',
                backgroundColor: Highcharts.color(Highcharts.getOptions().colors[0])
                    .setOpacity(0.3)
                    .get(),
                borderWidth: 0
            }, { // Track for Exercise
                outerRadius: '87%',
                innerRadius: '63%',
                backgroundColor: Highcharts.color(Highcharts.getOptions().colors[1])
                    .setOpacity(0.3)
                    .get(),
                borderWidth: 0
            }]
        },

        yAxis: {
            min: 0,
            max: 100,
            lineWidth: 0,
            tickPositions: []
        },

        plotOptions: {
            solidgauge: {
                dataLabels: {
                    enabled: false
                },
                linecap: 'round',
                stickyTracking: false,
                rounded: true
            }
        },

        series: [{
            name: 'Scounting',
            data: [{
                color: Highcharts.getOptions().colors[0],
                radius: '112%',
                innerRadius: '88%',
                y: 80
            }]
        }, {
            name: 'Testing',
            data: [{
                color: Highcharts.getOptions().colors[1],
                radius: '87%',
                innerRadius: '63%',
                y: 65
            }]
        }]
    });
</script>
<script>
    function getRandomInt(max) {
        return Math.floor(Math.random() * max);
    }
    Highcharts.chart('donut_chart_2', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Progress Pekerjaan'
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
            name: 'Total',
            data: [
                ['Remaining', getRandomInt(100)],
                ['Done', getRandomInt(100)],
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
            text: 'Remaining Time'
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
            name: 'Total',
            data: [
                ['Remaining', getRandomInt(100)],
                ['Done', getRandomInt(100)],
            ]
        }]
    });
</script>
<script>
    Highcharts.chart('timeline', {
        chart: {
            type: 'timeline'
        },
        accessibility: {
            screenReaderSection: {
                beforeChartFormat: '<h5>{chartTitle}</h5>' +
                    '<div>{typeDescription}</div>' +
                    '<div>{chartSubtitle}</div>' +
                    '<div>{chartLongdesc}</div>' +
                    '<div>{viewTableButton}</div>'
            },
            point: {
                valueDescriptionFormat: '{index}. {point.label}. {point.description}.'
            }
        },
        xAxis: {
            visible: false
        },
        yAxis: {
            visible: false
        },
        title: {
            text: 'Timeline Progress Pekerjaan'
        },
        colors: [
            '#4185F3',
            '#427CDD',
            '#406AB2',
            '#3E5A8E',
            '#3B4A68',
            '#363C46',
            '#363C46',
            '#363C46',
            '#363C46',
            '#363C46',
            '#363C46',
            '#363C46',
            '#363C46',
            '#363C46',
            '#363C46',
        ],
        series: [{
            data: [{
                    name: 'Material Delivery & On Site Bitung Warehouse (LW Ca...',
                    description: '14 February 2000, first orbiting of an asteroid (433 Eros).'
                }, {
                    name: 'ONDONG SIAU _ TAHUNA Link Up',
                    description: '14 January 2005, first soft landing on Titan also first soft landing in the outer Solar System.'
                }, {
                    name: 'Apply SKPBA',
                    description: '18 March 2011, first spacecraft to orbit Mercury.'
                }, {
                    name: 'Transit from Tahuna to Bitung',
                    description: '10 August 2015, first food grown in space and eaten (lettuce).'
                }, {
                    name: 'Clearence in/Queueing to Bitung',
                    description: '10 April 2019, first direct photograph of a black hole and its vicinity.'
                }, {
                    name: 'Cable Loading, UQJ Rope, Etc',
                    description: '30 May 2020, first orbital human spaceflight launched by a private company (SpaceX).'
                }, {
                    name: 'Top Up Fuel & Fresh Water',
                    description: '30 May 2020, first orbital human spaceflight launched by a private company (SpaceX).'
                }, {
                    name: 'Clear Out From Bitung',
                    description: '30 May 2020, first orbital human spaceflight launched by a private company (SpaceX).'
                }, {
                    name: 'Sail to Sanana',
                    description: '30 May 2020, first orbital human spaceflight launched by a private company (SpaceX).'
                }, {
                    name: 'Clearence in_Out Sanana Port',
                    description: '30 May 2020, first orbital human spaceflight launched by a private company (SpaceX).'
                }, {
                    name: 'Shifting to Projeck t Site',
                    description: '30 May 2020, first orbital human spaceflight launched by a private company (SpaceX).'
                }, {
                    name: 'Scouting',
                    description: '30 May 2020, first orbital human spaceflight launched by a private company (SpaceX).'
                }, {
                    name: 'Cabel Searching, Recovery Km.180 Sanana Side',
                    description: '30 May 2020, first orbital human spaceflight launched by a private company (SpaceX).'
                }, {
                    name: 'Roll Back Broken Cable',
                    description: '30 May 2020, first orbital human spaceflight launched by a private company (SpaceX).'
                }, {
                    name: 'Cabel Evacuate & Testing KM.180 Sanana Site & Buoy',
                    description: '30 May 2020, first orbital human spaceflight launched by a private company (SpaceX).'
                }, {
                    name: 'Shifting to KM 180 Taliabu Side',
                    description: '14 February 2000, first orbiting of an asteroid (433 Eros).'
                }
            ]
        }]
    });
</script>
<script>
    Highcharts.chart('x-range', {
        chart: {
            type: 'xrange'
        },
        title: {
            text: 'PERBAIKAN KABEL LAUT DALAM SEGMEN TALIABU-SANANA Km.180 From SANANA'
        },
        accessibility: {
            point: {
                descriptionFormatter: function(point) {
                    var ix = point.index + 1,
                        category = point.yCategory,
                        from = new Date(point.x),
                        to = new Date(point.x2);
                    return ix + '. ' + category + ', ' + from.toDateString() +
                        ' to ' + to.toDateString() + '.';
                }
            }
        },
        xAxis: {
            type: 'datetime'
        },
        yAxis: {
            title: {
                text: ''
            },
            categories: [
                'Material Delivery & On Site Bitung Warehouse (LW Ca,,,',
                'ONDONG SIAU _ TAHUNA Link Up', 
                'Apply SKPBA',
                'Shifting to Sanana'
            ],
            reversed: true
        },
        series: [{
            // pointPadding: 0,
            // groupPadding: 0,
            borderColor: 'gray',
            pointWidth: 20,
            data: [{
                x: Date.UTC(2014, 10, 21),
                x2: Date.UTC(2014, 11, 2),
                y: 0,
                color: '#0072f0',
            }, {
                x: Date.UTC(2014, 11, 2),
                x2: Date.UTC(2014, 11, 5),
                y: 1,
                color: '#0072f0',
            }, {
                x: Date.UTC(2014, 11, 8),
                x2: Date.UTC(2014, 11, 9),
                y: 2,
                color: '#0072f0',
            },
            {
                x: Date.UTC(2014, 11, 10),
                x2: Date.UTC(2014, 11, 12),
                y: 3,
                color: '#0072f0',
            }],
            dataLabels: {
                enabled: true
            }
        }]

    });
</script>
@endpush