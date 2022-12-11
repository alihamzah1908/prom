<!DOCTYPE html>
<html lang="en">

<head>
    <title>Setup</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ url('assets/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/style.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <script src="{{ url('adminlte/plugins/jquery/jquery.min.js') }}"></script>
</head>

<style>
    .display-none{
        display:none;
    }
    .pt-4{
    padding-top: .5rem!important;
    }
</style>

<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top setup_navbar">
        <div class="container">
            <a href="#" class="navbar-brand" style="color: #4F4F4F; font-weight: 600">{{ __('setup-index1.setup_language') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form class="form-inline my-2 my-lg-0 navbar-nav ml-auto">
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search" style="border-top-right-radius: 0px; background: #ECECEC; border-bottom-right-radius: 0px">
                    <button class="btn btn-primary my-2 my-sm-0" style="border-bottom-left-radius: 0px; border-top-left-radius: 0px" type="submit"><i class="fas fa-search text-white" aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
    </nav>
    
    <section id="explore-head-section">
        <div class="container">
            <div class="row pt-5">
                @if(getAccess('/setup/servicedesk'))
                <div class="col-md-4">
                    <div class="pt-5">
                        <a href="#" class="menu_setup">
                            <img src="{{url('adminlte/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle">
                        </a>
                        <a target="new" href="/setup/servicedesk" class="menu_setup">{{ __('setup-index1.servicedesk_language') }}</a>
                        <p class="pt-4 servicedesk">{{ __('setup-index1.servicedesk-desc_language') }}</p>
                    </div>
                </div>
                @endif
                
                @if(getAccess('/setup/userpermission'))
                <div class="col-md-4">
                    <div class="pt-5">
                        <a href="#" class="menu_setup">
                            <i class="fas fa-user icon_user"></i>
                        </a>
                        <a target="new" href="/setup/userpermission?view=role" class="menu_setup">{{ __('setup-index1.user-permissions_language') }}</a>
                        <p class="pt-4 text_setup">{{ __('setup-index1.user-permissions-desc_language') }}</p>
                    </div>
                </div>
                @endif
                @if(getAccess('/setup/notif-setting'))
                <div class="col-md-4 display-none">
                    <div class="pt-5">
                        <a href="#" class="menu_setup">
                            <i class="fas fa-envelope icon_notif"></i>
                        </a>
                        <a target="new" href="/setup/notif-setting" class="menu_setup">{{ __('setup-index1.setting-notification_language') }}</a>
                        <p class="pt-4 text_setup">{{ __('setup-index1.setting-notification-desc_language') }}</p>
                    </div>
                </div>
                @endif
                @if(getAccess('/setup/Customization'))
                <div class="col-md-4">
                    <div class="pt-5">
                        <a href="#" class="menu_setup">
                            <i class="fas fa-tools icon_custome"></i>
                        </a>
                        <a target="new" href="/setup/Customization" class="menu_setup">{{ __('setup-index1.customization_language') }}</a>
                        <p class="pt-4 servicedesk">{{ __('setup-index1.customization-desc_language') }}</p>
                    </div>
                </div>
                @endif
                @if(getAccess('/setup/template-form/{id_type}'))
                <div class="col-md-4">
                    <div class="pt-5">
                        <a href="" class="menu_setup">
                            <i class="fab fa-wpforms icon_form"></i>
                        </a>
                        <a target="new" href="/setup/template-form/1" class="menu_setup">{{ __('setup-index1.template-and-form_language') }}</a>
                        <p class="pt-4 text_setup">{{ __('setup-index1.template-and-form-desc_language') }}</p>
                    </div>
                </div>
                @endif
                @if(getAccess('/setup/data_administration'))
                <div class="col-md-4 display-none">
                    <div class="pt-5">
                        <a href="" class="menu_setup">
                            <i class="fas fa-cog icon_admin"></i>
                        </a>
                        <a href="#" class="menu_setup">{{ __('setup-index1.data-administration_language') }}</a>
                        <p class="pt-4 text_setup">{{ __('setup-index1.data-administration-desc_language') }}</p>
                    </div>
                </div>
                @endif
                @if(getAccess('/setup/chat'))
                <div class="col-md-4 display-none">
                    <div class="pt-5">
                        <a href="#" class="menu_setup">
                            <i class="fas fa-comment-dots icon_chat"></i>
                        </a>
                        <a href="#" class="menu_setup">{{ __('setup-index1.chat_language') }}</a>
                        <p class="pt-4 servicedesk">{{ __('setup-index1.chat-desc_language') }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="/js/theme.js"></script>
    <script>
        
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>