<!-- Brand Logo -->
<a href="{{ route('dashboard') }}" class="brand-link text-center" style="border-bottom: none">
    <img src="/images/PROM4.png" alt="PROM" style="width:80%">
    <span class="brand-text font-weight-light pl-4"> </span>
</a>

<style>
    .display-none{
        display:none;
    }
</style>
<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="{{ route('servicedesk') }}" class="nav-link" target="new">
                    <p>
                        {{ __('setup-sidebar2.service-desk_language') }}
                        
                    </p>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="{{ route('Customization') }}" class="nav-link" target="new">
                    <p>
                        {{ __('setup-sidebar2.customization_language') }}
                    </p>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="/setup/template-form/1" class="nav-link" target="new">
                    <p>
                        {{ __('setup-sidebar2.template-form_language') }}
                    </p>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="/setup/userpermission" class="nav-link" target="new">
                    <p>
                        {{ __('setup-sidebar2.users-permissions_language') }}
                    </p>
                </a>
            </li>
            
            <li class="nav-item display-none">
                <a href="/setup/aktivasi_layanan" class="nav-link" target="new">
                    <p>
                        {{ __('setup-sidebar2.service-activation_language') }}
                    </p>
                </a>
            </li>
            <li class="nav-item display-none">
                <a href="{{ route('notif') }}" class="nav-link" target="new">
                    <p>
                        {{ __('setup-sidebar2.setting-notifications_language') }}
                    </p>
                </a>
            </li>
            <li class="nav-item display-none">
                <a href="{{ route('archive') }}" class="nav-link" target="new">
                    <p>
                        {{ __('setup-sidebar2.data-administration_language') }}
                    </p>
                </a>
            </li>
            <li class="nav-item display-none">
                <a href="{{ route('chat') }}" class="nav-link" target="new">
                    <p>
                        {{ __('setup-sidebar2.chat_language') }}
                    </p>
                </a>
            </li>
        </ul>

    </nav>
    <!-- /.sidebar-menu -->
</div>
