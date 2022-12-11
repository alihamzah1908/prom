<?php 
$user = Auth::user();
?>
<style>
    .brand-image {
        border: 0 !important;
        box-sizing: border-box;
    }
</style>
<!-- Brand Logo -->
<a href="/" class="brand-link text-center">
    <img src="/images/PROM4.png" alt="PROM" style="width:80%;height:30%" class="sidebar_logo">
    <span class="brand-text font-weight-light pl-4"> </span>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <!--<div class="user-panel d-flex">-->
    <!--    <div class="info">-->
    <!--        <h5 href="#" class="d-block" style="color: #8c9094 !important;">Main Menu</h5>-->
    <!--    </div>-->
    <!--</div>-->

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->
            @if(getAccess('/dashboard'))           
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-globe-africa"></i>
                    <p>Dashboard</p><i class="right fa fa-angle-left"></i>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('dashboard.test') }}" class="nav-link {{request()->path() == 'test' ? 'active':''}}" target="new">
                        <i class="fa fa-angle-right nav-icon"></i>
                            SLA Pairing</p>
                            <span class="right badge badge-danger"></span>
                        </a>
                    </li>
                </ul>                
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('dashboard.trouble') }}" class="nav-link {{request()->path() == 'trouble' ? 'active':''}}" target="new">
                            <i class="fa fa-angle-right nav-icon"></i>
                            Ticket Progress
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('dashboard.incident') }}" class="nav-link {{request()->path() == 'incident' ? 'active':''}}" target="new">
                            <i class="fa fa-angle-right nav-icon"></i>
                            Incident Parameter
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('dashboard.ticket') }}" class="nav-link {{request()->path() == 'ticket' ? 'active':''}}" target="new">
                            <i class="fa fa-angle-right nav-icon"></i>
                            Ticket Monitoring
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('dashboard.achievement') }}" class="nav-link {{request()->path() == 'achievement' ? 'active':''}}" target="new">
                            <i class="fa fa-angle-right nav-icon"></i>
                            Task Achievement
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('dashboard.taskmon') }}" class="nav-link {{request()->path() == 'taskmon' ? 'active':''}}" target="new">
                            <i class="fa fa-angle-right nav-icon"></i>
                            Task Monitoring
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('dashboard.personal') }}" class="nav-link {{request()->path() == 'personal' ? 'active':''}}" target="new">
                            <i class="fa fa-angle-right nav-icon"></i>
                            Personal Monitoring
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            <!-- <li class="nav-item has-treeview @if(in_array(request()->path(), ['dashboard', 'test'])) menu-open @endif">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-globe-africa"></i>
                    <p>
                        Dashboard New
                    </p>

                </a>
                @if(getAccess('/dashboard'))
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{request()->path() == 'dashboard' ? 'active':''}}" target="new">
                            <i class="nav-icon fas fa-globe-africa"></i>
                            <p>
                                {{ __('sidebar1.dasboard_language') }}
                            </p>
                        </a>
                    </li>
                </ul>
                @endif
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('dashboard.test') }}" class="nav-link {{request()->path() == 'test' ? 'active':''}}" target="new">
                            <i class="nav-icon fas fa-globe-africa"></i>
                            <p>
                                test
                            </p>
                        </a>
                    </li>
                </ul>
            </li> -->
            
            @if(getAccess('/task'))
            @if(date('Y-m-d H:i:s') < date('2022-01-01 00:00:00'))
            <li class="nav-item">
                <a href="{{ route('task') }}" class="nav-link {{request()->path() == 'task/old' ? 'active':''}}" target="new">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>
                        {{ __('sidebar1.task_language') }}
                    </p>
                </a>
            </li>
            @endif
            <li class="nav-item">
                <a href="{{ route('task.testing') }}" class="nav-link {{request()->path() == 'task' ? 'active':''}}" target="new">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>
                        Task List
                    </p>
                    @if(date('Y-m-d H:i:s') < date('2021-12-13 00:00:00'))
                    <span class="right badge badge-warning">CR</span>
                    @else
                    <span class="right badge badge-success">Stable</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('task_schedule') }}" class="nav-link {{request()->path() == 'task_schedule' ? 'active':''}}" target="new">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>
                        {{ __('sidebar1.task_language') }} Schedule
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('form_bulanan.index',9) }}" class="nav-link {{request()->path() == 'form_bulanan.index' ? 'active':''}}" target="new">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>
                        Form Bulanan
                    </p>
                </a>
            </li>
            @endif
            @if(getAccess('/aktivasi-layanan'))
            <li class="nav-item">
                <a href="{{ route('aktivasi') }}" class="nav-link {{request()->path() == 'aktivasi-layanan' ? 'active':''}}" target="new">
                    <i class="nav-icon far fa-image"></i>
                    <p>
                        {{ __('sidebar1.layanan_language') }}
                    </p>
                </a>
            </li>
            @endif
            @if(getAccess('/site-permit'))
            <li class="nav-item">
                <a href="{{ route('sitePermit') }}" class="nav-link {{request()->path() == 'site-permit' ? 'active':''}}" target="new">
                    <i class="nav-icon fas fa-user-cog"></i>
                    <p>
                        {{ __('sidebar1.site-permit_language') }}
                    </p>
                </a>
            </li>
            @endif
            @if(getAccess('/user_location'))
            <li class="nav-item">
                <a href="/user_location" class="nav-link {{request()->path() == 'user_location' ? 'active':''}}" target="new">
                    <i class="nav-icon fas fa-crosshairs"></i>
                    <p>
                        {{ __('sidebar1.regional-gps_language') }}
                    </p>
                </a>
            </li>
            @endif
            @if(getAccess('/user'))
            <li class="nav-item">
                <a href="{{ route('user') }}" class="nav-link {{request()->path() == 'user' ? 'active':''}}" target="new">
                    <i class="nav-icon far fa-user"></i>
                    <p>
                        {{ __('sidebar1.user_language') }}
                    </p>
                </a>
            </li>
            @endif
            
            @if(getAccess('/waiting_approval') || getAccess('/waiting_approval/aktivasi') || getAccess('/waiting_approval/site-permit'))
            <?php 
            $is_info = false;
            if(getAccess('/waiting_approval')){
                $task_w = getWaitingApprovalTaskCount($user);
                if($task_w) $is_info = true; 
            }
            if(getAccess('/waiting_approval/aktivasi')){
                $aktivasi_w = getWaitingApprovalAktivasiCount($user);
                if($aktivasi_w) $is_info = true;
            }
            if(getAccess('/waiting_approval/site-permit')){
                $site_w = getWaitingApprovalSiteCount($user);
                if($site_w) $is_info = true;
            }
            ?>
            <!--menu-open-->
            <li class="nav-item has-treeview @if(in_array(request()->path(), ['waiting_approval/aktivasi', 'waiting_approval/site-permit', 'waiting_approval'])) menu-open @endif">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-globe-africa"></i>
                    <p>
                         {{ __('sidebar1.waiting-approval_language') }}
                        <i class="right fa fa-angle-left"></i>
                        @if($is_info)
                        <span class="right badge badge-danger">{{ __('sidebar1.new_language') }}</span>
                        @endif
                    </p>
                    
                </a>
                @if(getAccess('/waiting_approval'))
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="/waiting_approval" class="nav-link {{request()->path() == 'waiting_approval' ? 'active':''}}" target="new">
                            <i class="fa fa-angle-right nav-icon"></i>
                            <p>{{ __('sidebar1.task2_language') }}</p>
                            @if($task_w)
                            <span class="right badge badge-danger">{{$task_w}}</span>
                            @endif
                        </a>
                    </li>
                </ul>
                @endif
                @if(getAccess('/waiting_approval/aktivasi'))
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="/waiting_approval/aktivasi" class="nav-link {{request()->path() == 'waiting_approval/aktivasi' ? 'active':''}}" target="new">
                            <i class="fa fa-angle-right nav-icon"></i>
                            <p>{{ __('sidebar1.aktivasi_language') }}</p>
                            @if($aktivasi_w)
                            <span class="right badge badge-danger">{{$aktivasi_w}}</span>
                            @endif
                        </a>
                    </li>
                </ul>
                @endif
                @if(getAccess('/waiting_approval/site-permit'))
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="/waiting_approval/site-permit" class="nav-link {{request()->path() == 'waiting_approval/site-permit' ? 'active':''}}" target="new">
                            <i class="fa fa-angle-right nav-icon"></i>
                            <p>{{ __('sidebar1.site-permit2_language') }}</p>
                            @if($site_w)
                            <span class="right badge badge-danger">{{$site_w}}</span>
                            @endif
                        </a>
                    </li>
                </ul>
                @endif
            </li>
            @endif
            
            @if(getAccess('/task/task_chats'))
            <li class="nav-item">
                <a href="/task/task_chats" class="nav-link {{request()->path() == 'task/task_chats' ? 'active':''}}" target="new">
                    <i class="nav-icon fas fa-comments"></i>
                    <p>
                        {{ __('sidebar1.task-chats_language') }}
                    </p>
                </a>
            </li>
            @endif
            
            @if(getAccess('/report/task') || getAccess('/report/aktivasi') || getAccess('/report/site_entry') || getAccess('/report/permit_letter'))
            <li class="nav-item has-treeview @if(in_array(request()->path(), ['report/task', 'report/aktivasi', 'report/site_entry', 'report/permit_letter'])) menu-open @endif">
                <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-file-alt"></i>
                    <p>{{ __('sidebar1.report_language') }}<i class="right fa fa-angle-left"></i></p>
                </a>
                @if(getAccess('/report/task'))
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="/report/task" class="nav-link {{request()->path() == 'report/task' ? 'active':''}}" target="new">
                            <i class="fa fa-angle-right nav-icon"></i>
                            <p>{{ __('sidebar1.task-report_language') }}</p>
                        </a>
                    </li>
                </ul>
                @endif
                @if(getAccess('/report/aktivasi'))
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="/report/aktivasi" class="nav-link {{request()->path() == 'report/aktivasi' ? 'active':''}}" target="new">
                            <i class="fa fa-angle-right nav-icon"></i>
                            <p>{{ __('sidebar1.aktivasi-report_language') }}</p>
                        </a>
                    </li>
                </ul>
                @endif
                @if(getAccess('/report/site_entry'))
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="/report/site_entry" class="nav-link {{request()->path() == 'report/site_entry' ? 'active':''}}" target="new">
                            <i class="fa fa-angle-right nav-icon"></i>
                            <p>{{ __('sidebar1.site-entry-report_language') }}</p>
                        </a>
                    </li>
                </ul>
                @endif
                @if(getAccess('/report/permit_letter'))
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="/report/permit_letter" class="nav-link {{request()->path() == 'report/permit_letter' ? 'active':''}}" target="new">
                            <i class="fa fa-angle-right nav-icon"></i>
                            <p>{{ __('sidebar1.permit-letter-report_language') }}</p>
                        </a>
                    </li>
                </ul>
                @endif
            </li>
            @endif
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-file-alt text-dark"></i>
                    <p>Warehouse Master</p><i class="right fa fa-angle-left"></i>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('material.index') }}" class="nav-link {{request()->path() == 'test' ? 'active':''}}" target="new">
                        <i class="fa fa-angle-right nav-icon"></i>
                            Material</p>
                            <span class="right badge badge-danger"></span>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('unit.index') }}" class="nav-link {{request()->path() == 'test' ? 'active':''}}" target="new">
                        <i class="fa fa-angle-right nav-icon"></i>
                            Unit</p>
                            <span class="right badge badge-danger"></span>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('location.index') }}" class="nav-link {{request()->path() == 'test' ? 'active':''}}" target="new">
                        <i class="fa fa-angle-right nav-icon"></i>
                            Location</p>
                            <span class="right badge badge-danger"></span>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('project.index') }}" class="nav-link {{request()->path() == 'test' ? 'active':''}}" target="new">
                        <i class="fa fa-angle-right nav-icon"></i>
                            Project</p>
                            <span class="right badge badge-danger"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-file-alt text-dark"></i>
                    <p>Warehouse</p><i class="right fa fa-angle-left"></i>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('materialin.index') }}" class="nav-link {{request()->path() == 'test' ? 'active':''}}" target="new">
                        <i class="fa fa-angle-right nav-icon"></i>
                            Warehouse Material List</p>
                            <span class="right badge badge-danger"></span>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('materialout.index') }}" class="nav-link {{request()->path() == 'test' ? 'active':''}}" target="new">
                        <i class="fa fa-angle-right nav-icon"></i>
                            Warehouse Material Out</p>
                            <span class="right badge badge-danger"></span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-file-alt text-dark"></i>
                    <p>Material On Going Approval</p><i class="right fa fa-angle-left"></i>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('on-going.approval') }}" class="nav-link {{request()->path() == 'test' ? 'active':''}}" target="new">
                        <i class="fa fa-angle-right nav-icon"></i>
                             Material List</p>
                            <span class="right badge badge-danger"></span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-file-alt text-dark"></i>
                    <p>Material Approval Out</p><i class="right fa fa-angle-left"></i>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('on-going.approved') }}" class="nav-link {{request()->path() == 'test' ? 'active':''}}" target="new">
                        <i class="fa fa-angle-right nav-icon"></i>
                             Material List</p>
                            <span class="right badge badge-danger"></span>
                        </a>
                    </li>
                </ul>
            </li>
            
            @if(Auth::user())
            <li class="nav-item">
                <a class="nav-link" id="btn_logout" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="nav-icon fa fa-sign-out-alt"></i> 
                    <p>
                        {{ __('sidebar1.logout_language') }}
                    </p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            </li>
            @else
            <li class="nav-item">
                <a href="/login" class="nav-link">
                    <i class="nav-icon fas fa-sign-in-alt"></i>
                    <p>
                        {{ __('sidebar1.login_language') }}
                    </p>
                </a>
            </li>
            @endif
        </ul>

    </nav>
    <!-- /.sidebar-menu -->
</div>

<script>
    
    $(document).ready(function(e){
       if($('.sidebar-mini').hasClass('sidebar-collapse')){
            $('.sidebar_logo').attr('src', '/images/P Logo.png')
            collapsed();
        }else{
            $('.sidebar_logo').attr('src', '/images/PROM4.png')
            opened()
        } 
    });
    $('.push_menu_bar').on('click', function(){
        if($('.sidebar-mini').hasClass('sidebar-collapse')){
            $('.sidebar_logo').attr('src', '/images/PROM4.png')
            opened()
        }else{
            $('.sidebar_logo').attr('src', '/images/P Logo.png')
            collapsed();
        }
    });
    
    function opened(){
        $(".main-sidebar").hover(function(){
        //   $('.sidebar_logo').attr('src', '/images/P Logo.png')
        }, function(){
          $('.sidebar_logo').attr('src', '/images/PROM4.png')
        });   
    }
    function collapsed(){
        $(".main-sidebar").hover(function(){
          $('.sidebar_logo').attr('src', '/images/PROM4.png')
        }, function(){
          $('.sidebar_logo').attr('src', '/images/P Logo.png')
        });
    }
</script>




