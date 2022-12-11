<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link mt-1 push_menu_bar" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item">
        <b><a href="#" class="nav-link">{{ __('header1.judul_language') }}</a></b>
    </li>

</ul>
<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-globe"></i>
                        {{ __('header1.switch_language') }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}" href="{{ route('localization.switch', 'en') }}">English</a>
                        <a class="dropdown-item {{ app()->getLocale() == 'id' ? 'active' : '' }}" href="{{ route('localization.switch', 'id') }}">Bahasa Indonesia</a>
                    </div>
                </li>
    @if(getAccess('/setup'))
    <li class="nav-item ">
        <a class="nav-link" href="{{ route('setup') }}">
            <i class="fas fa-cog"></i>
        </a>
    </li>
    @endif
    <!--<li class="nav-item dropdown">-->
    <!--    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">-->
    <!--      <i class="fa fa-comments"></i>-->
    <!--      <span class="badge badge-danger navbar-badge">1</span>-->
    <!--    </a>-->
    <!--    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">-->
    <!--      <span class="dropdown-item dropdown-header">1 Message</span>-->
    <!--      <div class="dropdown-divider"></div>-->
    <!--      <a href="#" class="dropdown-item">-->
    <!--        <div class="media">-->
    <!--          <img src="/adminlte/img/logo1.png" alt="User Avatar" class="img-size-50 mr-3 img-circle">-->
    <!--          <div class="media-body">-->
    <!--            <h3 class="dropdown-item-title">-->
    <!--              Brad Diesel-->
    <!--            </h3>-->
    <!--            <p class="text-sm">Call me whenever you can...</p>-->
    <!--            <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>-->
    <!--          </div>-->
    <!--        </div>-->
    <!--      </a>-->
    <!--      <div class="dropdown-divider"></div>-->
          <!--<a href="#" class="dropdown-item dropdown-footer">See All Messages</a>-->
    <!--    </div>-->
    <!--  </li>-->
     
     <li class="nav-item dropdown list_notification"></li>
     
     @if(Auth::user())
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-user-circle"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="padding:1rem; min-width:15rem">
            <?php $user = Auth::user(); ?>
            <div class="form-group">
                <b>{{isset($user->name)?$user->name:''}}</b>
                <b>{{isset($user->email)?$user->email:''}}</b>
            </div>
            <div class="dropdown-divider"></div>
            <div class="row">
                <div class="col-md-12">
                    <a class="dropdown-item text-center btn-change-theme" href="#"></a>
                </div>
                
                <div class="col-md-6">
                    <a class="dropdown-item text-right" href="/user/profile">
                        <i class="fas fa-user-circle"></i>&nbsp;{{ __('header1.profile_language') }}
                    </a>
                </div>
                <div class="col-md-6">
                    <a class="dropdown-item text-right" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>&nbsp;{{ __('header1.logout_language') }}
                    </a>
                </div>
            </div>
        </div>
    </li>
    @endif

</ul>

