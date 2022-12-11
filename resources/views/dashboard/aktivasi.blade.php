<div class="row justify-content-around ">
    <div class="col-md-2" id="row_priority">
        <div class="card" style="height:96.5%;">
            <div class="card-header"><h3 class="card-title">{{ __('aktivasi-dasboard1.customers_language') }}</h3></div>
            <div class="card-body" id="card_by_customer"></div>
            <div class="donut-legend text-center"></div>
        </div>
    </div>
    <div class="col-md-2" >
        <div class="card" style="height:96.5%;">
            <div class="card-header"><h3 class="card-title">{{ __('aktivasi-dasboard1.status_language') }}</h3></div>
            <div class="card-body" id="card_by_status"></div>
            <div class="donut-legend text-center"></div>
        </div>
    </div>
    <div class="col-md-2" id="row_root_coused">
        <div class="card" style="height:96.5%;">
            <div class="card-header"><h3 class="card-title">{{ __('aktivasi-dasboard1.used-capacity_language') }}</h3></div>
            <div class="card-body" id="card_by_capasity"></div>
            <div class="donut-legend text-center"></div>
        </div>
    </div>
    <div class="col-md-2" id="row_root_coused">
        <div class="card" >
            <div class="card-header"><h3 class="card-title">{{ __('aktivasi-dasboard1.capacity-1-gb_language') }}</h3></div>
            <div class="card-body" id="card_by_1gb"></div>
            <div class="donut-legend text-center"></div>
        </div>
    </div>
    <div class="col-md-2" id="row_root_coused">
        <div class="card">
            <div class="card-header"><h3 class="card-title">{{ __('aktivasi-dasboard1.capacity-10-gb_language') }}</h3></div>
            <div class="card-body" id="card_by_10gb"></div>
            <div class="donut-legend text-center"></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h3 class="card-title">{{ __('aktivasi-dasboard1.this-week_language') }}</h3></div>
            <div class="card-body" id="card_this_week"></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h3 class="card-title">{{ __('aktivasi-dasboard1.this-month_language') }}</h3></div>
            <div class="card-body" id="card_this_month"></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><h3 class="card-title">{{ __('aktivasi-dasboard1.count-per-region_language') }}</h3></div>
            <div class="card-body" id="card_by_region"></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><h3 class="card-title">{{ __('aktivasi-dasboard1.count-per-segment_language') }}</h3></div>
            <div class="card-body" id="card_by_segment"></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><h3 class="card-title">{{ __('aktivasi-dasboard1.capacity-per-region_language') }}</h3></div>
            <div class="card-body" id="card_by_per_region"></div>
        </div>
    </div>

    
</div>

@push('scripts')
<script>
    var param = {id_type_service:'1'}
    initDashboard(param);
    
    $(document).on('change', 'select[name=service_type]', function(e){
        e.preventDefault();
        var id = $(this).val();
        param.id_type_service = id;
        
        emptyCharts();
        initDashboard(param);
    })
    
    function emptyCharts(){
        $('#card_by_customer').html('')
        $('#card_by_status').html('')
        $('#card_by_capasity').html('')
        $('#card_by_1gb').html('')
        $('#card_by_10gb').html('')
        $('#card_this_week').html('')
        $('#card_this_month').html('')
        $('#card_by_per_region').html('')
        $('#card_by_region').html('')
        $('#card_by_segment').html('')   
    }
    
    function initDashboard(param){
        var its = param.id_type_service;
            its = 'id_type_service='+ its;
        $.get('/api/getAktivasiDashboardData', param, function(response){
            var data = response;
            
            by_customer = data.by_customer;
            putChart($('#card_by_customer'), 'by_customer', 'by_customer', by_customer.colors, by_customer.labels, by_customer.dataset, 'DONUT', 'AKTIVASI_CUSTOMER', its);
            
            by_status = data.by_status;
            putChart($('#card_by_status'), 'by_status', 'Status', by_status.colors, by_status.labels, by_status.dataset, 'DONUT', 'AKTIVASI_STATUS', its);
            
            by_capasity = data.by_capasity;
            putChart($('#card_by_capasity'), 'by_capasity', 'RootCaused', by_capasity.colors, by_capasity.labels, by_capasity.dataset, 'DONUT', 'AKTIVASI_CAPASITY', its);
            
            by_1gb = data.by_1gb;
            putChart($('#card_by_1gb'), 'by_1gb', 'by_1gb', by_1gb.colors, by_1gb.labels, by_1gb.dataset, 'DONUT', 'AKTIVASI_1GB', its);
            
            by_10gb = data.by_10gb;
            putChart($('#card_by_10gb'), 'by_10gb', 'by_10gb', by_10gb.colors, by_10gb.labels, by_10gb.dataset, 'DONUT', 'AKTIVASI_10GB', its);
            
            
            this_week = data.this_week;
            putChart($('#card_this_week'), 'this_week', 'ThisWeek', '#007bff', this_week.labels, this_week.dataset, 'LINE');
            
            this_month = data.this_month;
            putChart($('#card_this_month'), 'this_month', 'ThisMonth', '#007bff', this_month.labels, this_month.dataset, 'LINE');
            
            
            by_per_region = data.by_per_region;
            putChart($('#card_by_per_region'), 'by_per_region', 'by_per_region', '#007bff', by_per_region.labels, by_per_region.dataset, 'BAR', 'AKTIVASI_PER_REGION', its);
            
            
            by_region = data.by_region;
            putChart($('#card_by_region'), 'by_region', 'by_region', '#007bff', by_region.labels, by_region.dataset, 'BAR', 'AKTIVASI_REGION', its);
            
            by_segment = data.by_segment;
            putChart($('#card_by_segment'), 'by_segment', 'by_segment', '#007bff', by_segment.labels, by_segment.dataset, 'BAR', 'AKTIVASI_SEGMENT', its);
        });
    }
    
</script>
@endpush