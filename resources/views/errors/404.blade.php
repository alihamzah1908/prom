<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @yield('title', '404 Error Page')
    </title>
    <?php 
    $logo = url('adminlte/img/logo.png');
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:type" content="website" />
    <meta property="og:title" content="PROM" />
    <link rel="icon" href="{{$logo}}">
    
    
    <link rel="stylesheet" href="{{ url('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/style.css') }}">
    <!-- Select2 -->
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{ url('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('adminlte/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ url('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <script src="{{ url('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    @stack('css')
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light bg-white">
            @include('template.partials.header')
        </nav>
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            @include('template.partials.sidebar')
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h3 class="m-0 text-dark"><strong>404 Error Page</strong></h3>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="error-page">
                    <h2 class="headline text-warning">404</h2>
                    
                    <div class="error-content">
                      <h3><i class="fas fa-exclamation-triangle text-warning"></i>  Oops! Page not found.</h3>
                    
                      <p>
                        We could not find the page you were looking for. Meanwhile, you may <a href="/">return to dashboard</a>
                      </p>
                    </div>
                    </div>
                </div>
            </section>
        </div>
        @include('template.partials.footer')
    </div>
    @include('modals')
    @include('template.partials.scripts')
</body>

</html>