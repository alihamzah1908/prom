<div class="row " >
    <div class="col-md-3" id="row_priority">
        <div class="card" style="height:96.5%;">
            <div class="card-header"><h3 class="card-title">{{ __('task-dasboard1.priority_language') }}</h3></div>
            <div class="card-body" id="card_by_priority"></div>
            <div class="donut-legend text-center"></div>
        </div>
    </div>
    <div class="col-md" id="row_status">
        <div class="card w-100" style="height:96.5%;">
            <div class="card-header"><h3 class="card-title">{{ __('task-dasboard1.status_language') }}</h3></div>
            <div class="card-body" id="card_by_status"></div>
            <div class="donut-legend text-center"></div>
        </div>
    </div>
    <div class="col-md-6" id="row_root_coused">
        <div class="card" style="height:96.5%;">
            <div class="card-header"><h3 class="card-title">{{ __('task-dasboard1.root-case_language') }}</h3></div>
            <div class="card-body" id="card_by_root_caused"></div>
        </div>
    </div>
    <div class="col-md-12"></div>
    <div class="col-md-6" id="row_this_week">
        <div class="card">
            <div class="card-header"><h3 class="card-title">{{ __('task-dasboard1.this-week_language') }}</h3></div>
            <div class="card-body" id="card_this_week"></div>
        </div>
    </div>
    <div class="col-md-6" id="row_this_month">
        <div class="card">
            <div class="card-header"><h3 class="card-title">{{ __('task-dasboard1.this-month_language') }}</h3></div>
            <div class="card-body" id="card_this_month"></div>
        </div>
    </div>

    <div class="col-md-12" id="row_count">
        <div class="card">
            <div class="card-header"><h3 class="card-title">{{ __('task-dasboard1.count-per-region_language') }}</h3></div>
            <div class="card-body" id="card_by_region"></div>
        </div>
    </div>
    <div class="col-md-6" id="row_fo_link">
        <div class="card">
            <div class="card-header"><h3 class="card-title">{{ __('task-dasboard1.fo-link-frequency_language') }}</h3></div>
            
            <div class="card-body" id="card_by_segment"></div>
        </div>
    </div>
    <div class="col-md-6" id="row_mmtr">
        <div class="card">
            <div class="card-header"><h3 class="card-title">{{ __('task-dasboard1.chart-mmtr_language') }}</h3></div>
            <div class="card-body" id="card_site_frequency"></div>
        </div>
    </div>
    <div class="col-md-12" id="row_by_pencapaian_pm">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Total Pencapaian Bulanan per {{date('F')}}</h3></div>
            <div class="card-body" id="card_by_pencapaian_pm"></div>
        </div>
    </div>
    <div class="col-md-12" id="row_by_pencapaian_pm_dki">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Pencapaian Bulanan per {{date('F')}} untuk DKI Jakarta</h3></div>
            <div class="card-body" id="card_by_pencapaian_pm_project_dki"></div>
        </div>
    </div>
    <div class="col-md-12" id="row_by_pencapaian_pm_4">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Pencapaian Bulanan per {{date('F')}} untuk Project 4</h3></div>
            <div class="card-body" id="card_by_pencapaian_pm_project_4"></div>
        </div>
    </div>
    <div class="col-md-12" id="row_by_pencapaian_pm_5">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Pencapaian Bulanan per {{date('F')}} untuk Project 5</h3></div>
            <div class="card-body" id="card_by_pencapaian_pm_project_5"></div>
        </div>
    </div>
    <div class="col-md-12" id="row_by_pencapaian_pm_6">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Pencapaian Bulanan per {{date('F')}} untuk Project 6</h3></div>
            <div class="card-body" id="card_by_pencapaian_pm_project_6"></div>
        </div>
    </div>
    <div class="col-md-12" id="row_by_pencapaian_pm_7">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Pencapaian Bulanan per {{date('F')}} untuk Project 7</h3></div>
            <div class="card-body" id="card_by_pencapaian_pm_project_7"></div>
        </div>
    </div>
    <div class="col-md-12" id="row_by_pencapaian_pm_8a">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Pencapaian Bulanan per {{date('F')}} untuk Project 8A</h3></div>
            <div class="card-body" id="card_by_pencapaian_pm_project_8A"></div>
        </div>
    </div>
    <div class="col-md-12" id="row_by_pencapaian_pm_8b">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Pencapaian Bulanan per {{date('F')}} untuk Project 8B</h3></div>
            <div class="card-body" id="card_by_pencapaian_pm_project_8B"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    var param = {id_task_type:1, id_filter_type:1 }
    initDashboard(param);
    
    $(document).on('change', 'select[name=task_type]', function(e){
        e.preventDefault();
        var id = $(this).val();
        param.id_task_type = id;
        
        emptyCharts();
        initDashboard(param);
    })
    $(document).on('change', 'select[name=filter_type]', function(e){
        e.preventDefault();
        var id = $(this).val();
        param.id_filter_type = id;
        
        emptyCharts();
        initDashboard(param);
    })
    
    function emptyCharts(){
        $('#card_by_priority').html('')
        $('#card_by_status').html('')
        $('#card_by_root_caused').html('')
        $('#card_this_week').html('')
        $('#card_this_month').html('')
        $('#card_by_region').html('')
        $('#card_by_segment').html('')  
        $('#card_by_pencapaian_pm').html('')
        $('#card_by_pencapaian_pm_project_dki').html('')
        $('#card_by_pencapaian_pm_project_4').html('')
        $('#card_by_pencapaian_pm_project_5').html('')
        $('#card_by_pencapaian_pm_project_6').html('')
        $('#card_by_pencapaian_pm_project_7').html('')
        $('#card_by_pencapaian_pm_project_8A').html('')
        $('#card_by_pencapaian_pm_project_8B').html('')
    }
    
    function initDashboard(param){
        if(param.id_task_type == 1 && param.id_filter_type == 1){
            $('#row_root_coused').removeClass('display-none');
            $('#row_priority').removeClass('display-none');
            $('#row_status').removeClass('display-none');
            $('#row_this_week').removeClass('display-none');
            $('#row_this_month').removeClass('display-none');
            $('#row_count').addClass('display-none');
            $('#row_fo_link').addClass('display-none');
            $('#row_mmtr').addClass('display-none');
            $('#row_by_pencapaian_pm').addClass('display-none');
            $('#row_by_pencapaian_pm_dki').addClass('display-none');
            $('#row_by_pencapaian_pm_4').addClass('display-none');
            $('#row_by_pencapaian_pm_5').addClass('display-none');
            $('#row_by_pencapaian_pm_6').addClass('display-none');
            $('#row_by_pencapaian_pm_7').addClass('display-none');
            $('#row_by_pencapaian_pm_8a').addClass('display-none');
            $('#row_by_pencapaian_pm_8b').addClass('display-none');
        }
        if(param.id_task_type == 1 && param.id_filter_type == 2){
            $('#row_root_coused').addClass('display-none');
            $('#row_priority').addClass('display-none');
            $('#row_status').addClass('display-none');
            $('#row_this_week').addClass('display-none');
            $('#row_this_month').addClass('display-none');
            $('#row_count').removeClass('display-none');
            $('#row_fo_link').removeClass('display-none');
            $('#row_mmtr').removeClass('display-none');
            $('#row_by_pencapaian_pm').addClass('display-none');
            $('#row_by_pencapaian_pm_dki').addClass('display-none');
            $('#row_by_pencapaian_pm_4').addClass('display-none');
            $('#row_by_pencapaian_pm_5').addClass('display-none');
            $('#row_by_pencapaian_pm_6').addClass('display-none');
            $('#row_by_pencapaian_pm_7').addClass('display-none');
            $('#row_by_pencapaian_pm_8a').addClass('display-none');
            $('#row_by_pencapaian_pm_8b').addClass('display-none');
        }
        if(param.id_task_type == 1 && param.id_filter_type == 3){
            $('#row_root_coused').removeClass('display-none');
            $('#row_priority').removeClass('display-none');
            $('#row_status').removeClass('display-none');
            $('#row_this_week').removeClass('display-none');
            $('#row_this_month').removeClass('display-none');
            $('#row_count').removeClass('display-none');
            $('#row_fo_link').removeClass('display-none');
            $('#row_mmtr').removeClass('display-none');
            $('#row_by_pencapaian_pm').addClass('display-none');
            $('#row_by_pencapaian_pm_dki').addClass('display-none');
            $('#row_by_pencapaian_pm_4').addClass('display-none');
            $('#row_by_pencapaian_pm_5').addClass('display-none');
            $('#row_by_pencapaian_pm_6').addClass('display-none');
            $('#row_by_pencapaian_pm_7').addClass('display-none');
            $('#row_by_pencapaian_pm_8a').addClass('display-none');
            $('#row_by_pencapaian_pm_8b').addClass('display-none');
        }
        if(param.id_task_type == 2 && param.id_filter_type == 1){
            $('#row_root_coused').addClass('display-none');
            $('#row_priority').addClass('display-none');
            $('#row_status').removeClass('display-none');
            $('#row_this_week').removeClass('display-none');
            $('#row_this_month').removeClass('display-none');
            $('#row_count').addClass('display-none');
            $('#row_fo_link').addClass('display-none');
            $('#row_mmtr').addClass('display-none');
            $('#row_by_pencapaian_pm').addClass('display-none');
            $('#row_by_pencapaian_pm_dki').addClass('display-none');
            $('#row_by_pencapaian_pm_4').addClass('display-none');
            $('#row_by_pencapaian_pm_5').addClass('display-none');
            $('#row_by_pencapaian_pm_6').addClass('display-none');
            $('#row_by_pencapaian_pm_7').addClass('display-none');
            $('#row_by_pencapaian_pm_8a').addClass('display-none');
            $('#row_by_pencapaian_pm_8b').addClass('display-none');
            
        }
        if(param.id_task_type == 2 && param.id_filter_type == 2){
            $('#row_root_coused').addClass('display-none');
            $('#row_priority').addClass('display-none');
            $('#row_status').addClass('display-none');
            $('#row_this_week').addClass('display-none');
            $('#row_this_month').addClass('display-none');
            $('#row_count').removeClass('display-none');
            $('#row_fo_link').removeClass('display-none');
            $('#row_mmtr').removeClass('display-none');
            $('#row_by_pencapaian_pm').removeClass('display-none');
            $('#row_by_pencapaian_pm_dki').addClass('display-none');
            $('#row_by_pencapaian_pm_4').addClass('display-none');
            $('#row_by_pencapaian_pm_5').addClass('display-none');
            $('#row_by_pencapaian_pm_6').addClass('display-none');
            $('#row_by_pencapaian_pm_7').addClass('display-none');
            $('#row_by_pencapaian_pm_8a').addClass('display-none');
            $('#row_by_pencapaian_pm_8b').addClass('display-none');
            
        }
        if(param.id_task_type == 2 && param.id_filter_type == 3){
            $('#row_root_coused').addClass('display-none');
            $('#row_priority').addClass('display-none');
            $('#row_status').addClass('display-none');
            $('#row_this_week').addClass('display-none');
            $('#row_this_month').addClass('display-none');
            $('#row_count').addClass('display-none');
            $('#row_fo_link').addClass('display-none');
            $('#row_mmtr').addClass('display-none');
            $('#row_by_pencapaian_pm').addClass('display-none');
            $('#row_by_pencapaian_pm_dki').removeClass('display-none');
            $('#row_by_pencapaian_pm_4').removeClass('display-none');
            $('#row_by_pencapaian_pm_5').removeClass('display-none');
            $('#row_by_pencapaian_pm_6').removeClass('display-none');
            $('#row_by_pencapaian_pm_7').removeClass('display-none');
            $('#row_by_pencapaian_pm_8a').removeClass('display-none');
            $('#row_by_pencapaian_pm_8b').removeClass('display-none');
            
        }
        if(param.id_task_type == 3 && param.id_filter_type == 1){
            $('#row_root_coused').addClass('display-none');
            $('#row_priority').addClass('display-none');
            $('#row_status').removeClass('display-none');
            $('#row_this_week').removeClass('display-none');
            $('#row_this_month').removeClass('display-none');
            $('#row_count').addClass('display-none');
            $('#row_fo_link').addClass('display-none');
            $('#row_mmtr').addClass('display-none');
            $('#row_by_pencapaian_pm').addClass('display-none');
            $('#row_by_pencapaian_pm_dki').addClass('display-none');
            $('#row_by_pencapaian_pm_4').addClass('display-none');
            $('#row_by_pencapaian_pm_5').addClass('display-none');
            $('#row_by_pencapaian_pm_6').addClass('display-none');
            $('#row_by_pencapaian_pm_7').addClass('display-none');
            $('#row_by_pencapaian_pm_8a').addClass('display-none');
            $('#row_by_pencapaian_pm_8b').addClass('display-none');
        }
        if(param.id_task_type == 3 && param.id_filter_type == 2){
            $('#row_root_coused').addClass('display-none');
            $('#row_priority').addClass('display-none');
            $('#row_status').addClass('display-none');
            $('#row_this_week').addClass('display-none');
            $('#row_this_month').addClass('display-none');
            $('#row_count').removeClass('display-none');
            $('#row_fo_link').removeClass('display-none');
            $('#row_mmtr').removeClass('display-none');
            $('#row_by_pencapaian_pm').addClass('display-none');
            $('#row_by_pencapaian_pm_dki').addClass('display-none');
            $('#row_by_pencapaian_pm_4').addClass('display-none');
            $('#row_by_pencapaian_pm_5').addClass('display-none');
            $('#row_by_pencapaian_pm_6').addClass('display-none');
            $('#row_by_pencapaian_pm_7').addClass('display-none');
            $('#row_by_pencapaian_pm_8a').addClass('display-none');
            $('#row_by_pencapaian_pm_8b').addClass('display-none');
        }
        if(param.id_task_type == 3 && param.id_filter_type == 3){
            $('#row_root_coused').addClass('display-none');
            $('#row_priority').addClass('display-none');
            $('#row_status').removeClass('display-none');
            $('#row_this_week').removeClass('display-none');
            $('#row_this_month').removeClass('display-none');
            $('#row_count').removeClass('display-none');
            $('#row_fo_link').removeClass('display-none');
            $('#row_mmtr').removeClass('display-none');
            $('#row_by_pencapaian_pm').addClass('display-none');
            $('#row_by_pencapaian_pm_dki').addClass('display-none');
            $('#row_by_pencapaian_pm_4').addClass('display-none');
            $('#row_by_pencapaian_pm_5').addClass('display-none');
            $('#row_by_pencapaian_pm_6').addClass('display-none');
            $('#row_by_pencapaian_pm_7').addClass('display-none');
            $('#row_by_pencapaian_pm_8a').addClass('display-none');
            $('#row_by_pencapaian_pm_8b').addClass('display-none');
        }
        if(param.id_task_type == 4 && param.id_filter_type == 1){
            $('#row_root_coused').addClass('display-none');
            $('#row_priority').addClass('display-none');
            $('#row_status').removeClass('display-none');
            $('#row_this_week').removeClass('display-none');
            $('#row_this_month').removeClass('display-none');
            $('#row_count').addClass('display-none');
            $('#row_fo_link').addClass('display-none');
            $('#row_mmtr').addClass('display-none');
            $('#row_by_pencapaian_pm').addClass('display-none');
            $('#row_by_pencapaian_pm_dki').addClass('display-none');
            $('#row_by_pencapaian_pm_4').addClass('display-none');
            $('#row_by_pencapaian_pm_5').addClass('display-none');
            $('#row_by_pencapaian_pm_6').addClass('display-none');
            $('#row_by_pencapaian_pm_7').addClass('display-none');
            $('#row_by_pencapaian_pm_8a').addClass('display-none');
            $('#row_by_pencapaian_pm_8b').addClass('display-none');
        }
        if(param.id_task_type == 4 && param.id_filter_type == 2){
            $('#row_root_coused').addClass('display-none');
            $('#row_priority').addClass('display-none');
            $('#row_status').addClass('display-none');
            $('#row_this_week').addClass('display-none');
            $('#row_this_month').addClass('display-none');
            $('#row_count').removeClass('display-none');
            $('#row_fo_link').removeClass('display-none');
            $('#row_mmtr').removeClass('display-none');
            $('#row_by_pencapaian_pm').addClass('display-none');
            $('#row_by_pencapaian_pm_dki').addClass('display-none');
            $('#row_by_pencapaian_pm_4').addClass('display-none');
            $('#row_by_pencapaian_pm_5').addClass('display-none');
            $('#row_by_pencapaian_pm_6').addClass('display-none');
            $('#row_by_pencapaian_pm_7').addClass('display-none');
            $('#row_by_pencapaian_pm_8a').addClass('display-none');
            $('#row_by_pencapaian_pm_8b').addClass('display-none');
        }
        if(param.id_task_type == 4 && param.id_filter_type == 3){
            $('#row_root_coused').addClass('display-none');
            $('#row_priority').addClass('display-none');
            $('#row_status').removeClass('display-none');
            $('#row_this_week').removeClass('display-none');
            $('#row_this_month').removeClass('display-none');
            $('#row_count').removeClass('display-none');
            $('#row_fo_link').removeClass('display-none');
            $('#row_mmtr').removeClass('display-none');
            $('#row_by_pencapaian_pm').addClass('display-none');
            $('#row_by_pencapaian_pm_dki').addClass('display-none');
            $('#row_by_pencapaian_pm_4').addClass('display-none');
            $('#row_by_pencapaian_pm_5').addClass('display-none');
            $('#row_by_pencapaian_pm_6').addClass('display-none');
            $('#row_by_pencapaian_pm_7').addClass('display-none');
            $('#row_by_pencapaian_pm_8a').addClass('display-none');
            $('#row_by_pencapaian_pm_8b').addClass('display-none');
        }
        // if(param.id_task_type != 1){
        //     $('#row_root_coused').addClass('display-none');
        //     $('#row_priority').addClass('display-none');
        // }else{
        //     $('#row_root_coused').removeClass('display-none');
        //     $('#row_priority').removeClass('display-none');
        // }
        var its = param.id_task_type;
            its = 'id_type='+ its;
        $.get('/api/getDashboardData', param, function(response){
            var data = response;
            
            priority = data.by_priority;
            putChart($('#card_by_priority'), 'by_priority', 'Priority', priority.colors, priority.labels, priority.dataset, 'DONUT', 'TASK_PRIORITY', its);
            
            by_status = data.by_status;
            putChart($('#card_by_status'), 'by_status', 'Status', by_status.colors, by_status.labels, by_status.dataset, 'DONUT', 'TASK_STATUS', its);
            
            by_root_caused = data.by_root_caused;
            putChart($('#card_by_root_caused'), 'by_root_caused', 'by_root_caused', '#007bff', by_root_caused.labels, by_root_caused.dataset, 'BAR', 'TASK_ROOT_CAUSED', its);
            
            this_week = data.this_week;
            putChart($('#card_this_week'), 'this_week', 'ThisWeek', '#007bff', this_week.labels, this_week.dataset, 'LINE');
            
            this_month = data.this_month;
            putChart($('#card_this_month'), 'this_month', 'ThisMonth', '#007bff', this_month.labels, this_month.dataset, 'LINE');
            
            by_region = data.by_region;
            putChart($('#card_by_region'), 'by_region', 'by_region', '#007bff', by_region.labels, by_region.dataset, 'BAR', 'TASK_REGION', its);
            
            by_segment = data.by_segment;
            putChart($('#card_by_segment'), 'by_segment', 'by_segment', '#007bff', by_segment.labels, by_segment.dataset, 'BAR', 'TASK_SEGMENT', its);
            
            site_frequency = data.site_frequency;
            putChart($('#card_site_frequency'), 'site_frequency', 'site_frequency', '#007bff', site_frequency.labels, site_frequency.dataset, 'BAR');
            // putChart($('#card_site_frequency'), 'site_frequency', 'site_frequency', '#007bff', site_frequency.labels, site_frequency.dataset, 'BAR', 'TASK_FREQUENCY', its);
            
            by_pencapaian_pm = data.by_pencapaian_pm;
            putChart($('#card_by_pencapaian_pm'), 'by_pencapaian_pm', 'by_pencapaian_pm', '#007bff', by_pencapaian_pm.labels, by_pencapaian_pm.dataset, 'BAR', 'PENCAPAIAN_PM', its);
            
            
            by_pencapaian_pm_project_dki = data.by_pencapaian_pm_project_dki;
            putChart($('#card_by_pencapaian_pm_project_dki'), 'by_pencapaian_pm_project_dki', 'by_pencapaian_pm_project_dki', '#007bff', by_pencapaian_pm_project_dki.labels, by_pencapaian_pm_project_dki.dataset, 'BAR', 'PENCAPAIAN_PM_PROJECT_DKI', its);
            
            by_pencapaian_pm_project_4 = data.by_pencapaian_pm_project_4;
            putChart($('#card_by_pencapaian_pm_project_4'), 'by_pencapaian_pm_project_4', 'by_pencapaian_pm_project_4', '#007bff', by_pencapaian_pm_project_4.labels, by_pencapaian_pm_project_4.dataset, 'BAR', 'PENCAPAIAN_PM_PROJECT_4', its );
            
            by_pencapaian_pm_project_5 = data.by_pencapaian_pm_project_5;
            putChart($('#card_by_pencapaian_pm_project_5'), 'by_pencapaian_pm_project_5', 'by_pencapaian_pm_project_5', '#007bff', by_pencapaian_pm_project_5.labels, by_pencapaian_pm_project_5.dataset, 'BAR', 'PENCAPAIAN_PM_PROJECT_5', its);
            
            by_pencapaian_pm_project_6 = data.by_pencapaian_pm_project_6;
            putChart($('#card_by_pencapaian_pm_project_6'), 'by_pencapaian_pm_project_6', 'by_pencapaian_pm_project_6', '#007bff', by_pencapaian_pm_project_6.labels, by_pencapaian_pm_project_6.dataset, 'BAR', 'PENCAPAIAN_PM_PROJECT_6', its);
            
            by_pencapaian_pm_project_7 = data.by_pencapaian_pm_project_7;
            putChart($('#card_by_pencapaian_pm_project_7'), 'by_pencapaian_pm_project_7', 'by_pencapaian_pm_project_7', '#007bff', by_pencapaian_pm_project_7.labels, by_pencapaian_pm_project_7.dataset, 'BAR', 'PENCAPAIAN_PM_PROJECT_7', its);
            
            by_pencapaian_pm_project_8A = data.by_pencapaian_pm_project_8A;
            putChart($('#card_by_pencapaian_pm_project_8A'), 'by_pencapaian_pm_project_8A', 'by_pencapaian_pm_project_8A', '#007bff', by_pencapaian_pm_project_8A.labels, by_pencapaian_pm_project_8A.dataset, 'BAR', 'PENCAPAIAN_PM_PROJECT_8A', its);
            
            by_pencapaian_pm_project_8B = data.by_pencapaian_pm_project_8B;
            putChart($('#card_by_pencapaian_pm_project_8B'), 'by_pencapaian_pm_project_8B', 'by_pencapaian_pm_project_8B', '#007bff', by_pencapaian_pm_project_8B.labels, by_pencapaian_pm_project_8B.dataset, 'BAR', 'PENCAPAIAN_PM_PROJECT_8B', its);
        });
    }
</script>
@endpush