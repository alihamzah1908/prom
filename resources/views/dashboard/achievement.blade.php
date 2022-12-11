@extends('template.default')
@section('submenu')
<!-- <div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="m-0 text-dark">{{ __('dasboard1.dasboard_language') }}</h3>
    </div>
</div> -->
@endsection
@section('content')
<div class="row ml-3 mb-4 mt-4 mr-3">
    <div class="col-md-6">
        <select class="form-control">
            <option value="">Task Type</option>
            <option value="">Default 1</option>
            <option value="">Default 2</option>
            <option value="">Default 3</option>
        </select>
    </div>
    <div class="col-md-6">
        <select class="form-control">
            <option value="">1 Nov 2022 - 22 Nov 2022</option>
            <option value="">1 Nov 2022 - 23 Nov 2022</option>
            <option value="">1 Nov 2022 - 24 Nov 2022</option>
            <option value="">1 Nov 2022 - 15 Nov 2022</option>
        </select>
    </div>
</div>
<div class="row ml-3 mr-3 mb-2">
    <div class="col-md-2">
        <div class="card">
            <div class="card-body">
                <div class="media border-top pt-3">
                    <img src="{{ asset('images/project-4.png') }}" width="40" class="mr-2 mt-1">
                    <div class="media-body">
                        <h6 class="mt-1 mb-0 font-size-15">PROJECT 4</h6>
                        <h6 class="mt-1 mb-0 font-size-15">14</h6>
                    </div>
                    <div class="dropdown align-self-center float-right">
                        <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown"
                            aria-expanded="false">
                            <i class="uil uil-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item"><i
                                    class="uil uil-edit-alt mr-2"></i>Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-body">
                <div class="media border-top pt-3">
                    <img src="{{ asset('images/project-5.png') }}" width="40" class="mr-2 mt-1">
                    <div class="media-body">
                        <h6 class="mt-1 mb-0 font-size-15">PROJECT 5</h6>
                        <h6 class="mt-1 mb-0 font-size-15">35</h6>
                    </div>
                    <div class="dropdown align-self-center float-right">
                        <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown"
                            aria-expanded="false">
                            <i class="uil uil-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item"><i
                                    class="uil uil-edit-alt mr-2"></i>Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-body">
                <div class="media border-top pt-3">
                    <img src="{{ asset('images/project-6.png') }}" width="40" class="mr-2 mt-1">
                    <div class="media-body">
                        <h6 class="mt-1 mb-0 font-size-15">PROJECT 6</h6>
                        <h6 class="mt-1 mb-0 font-size-15">14</h6>
                    </div>
                    <div class="dropdown align-self-center float-right">
                        <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown"
                            aria-expanded="false">
                            <i class="uil uil-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item"><i
                                    class="uil uil-edit-alt mr-2"></i>Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-body">
                <div class="media border-top pt-3">
                    <img src="{{ asset('images/project-7.png') }}" width="40" class="mr-2 mt-1">
                    <div class="media-body">
                        <h6 class="mt-1 mb-0 font-size-15">PROJECT 7</h6>
                        <h6 class="mt-1 mb-0 font-size-15">63</h6>
                    </div>
                    <div class="dropdown align-self-center float-right">
                        <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown"
                            aria-expanded="false">
                            <i class="uil uil-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item"><i
                                    class="uil uil-edit-alt mr-2"></i>Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-body">
                <div class="media border-top pt-3">
                    <img src="{{ asset('images/project-8.png') }}" width="40" class="mr-2 mt-1">
                    <div class="media-body">
                        <h6 class="mt-1 mb-0 font-size-15">PROJECT 8</h6>
                        <h6 class="mt-1 mb-0 font-size-15">79</h6>
                    </div>
                    <div class="dropdown align-self-center float-right">
                        <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown"
                            aria-expanded="false">
                            <i class="uil uil-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item"><i
                                    class="uil uil-edit-alt mr-2"></i>Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="media border-top pt-3">
                <img src="{{ asset('images/project-9.png') }}" width="40" class="mr-2 mt-1">
                <div class="media-body">
                    <h6 class="mt-1 mb-0 font-size-15">PROJECT 9</h6>
                    <h6 class="mt-1 mb-0 font-size-15">80</h6>
                </div>
                <div class="dropdown align-self-center float-right">
                    <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown"
                        aria-expanded="false">
                        <i class="uil uil-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item"><i
                                class="uil uil-edit-alt mr-2"></i>Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row ml-3 mr-3 mt-4">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5>Total Task : 40</h5>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <figure class="highcharts-figure">
            <div id="donut_chart_1"></div>
        </figure>
    </div>
</div>
@endsection

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
    // Data retrieved from https://netmarketshare.com/
    // Build the chart
    Highcharts.chart('donut_chart_1', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Project Task'
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
                ['Project 4', getRandomInt(100)],
                ['Project 5', getRandomInt(100)],
                ['Project 6', getRandomInt(100)],
                ['Project 7', getRandomInt(100)],
                ['Project 8', getRandomInt(100)],
                ['Project 9', getRandomInt(100)],
            ]
        }]
    });
</script>
@endpush