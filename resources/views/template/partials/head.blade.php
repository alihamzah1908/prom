<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>
    @yield('title', 'PROM')
</title>
<!-- Tell the browser to be responsive to screen width -->
<?php 
$logo = url('adminlte/img/logo.png');
// $logo = url('images/logo-white.png');
$desc = "PALAPA RING OPERATION & MAINTENEANCE";
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta property="og:type" content="website" />
<meta property="og:title" content="PROM" />
<meta property="og:description" content="{{$desc}}" />
<meta name="description" content="{{$desc}}" />
<meta property="og:url" content="{{request()->path()}}" />
<meta property="og:site_name" content="PROM" />
<meta property="og:image" content="{{$logo}}" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:image:src" content="{{$logo}}">
<meta name="twitter:description" content="{{$desc}}">
<meta property="og:image:secure_url" content="{{$logo}}" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<link rel="icon" href="{{$logo}}">


<link rel="stylesheet" href="{{ url('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/style.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ url('adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet" href="{{ url('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<!-- iCheck -->
<link rel="stylesheet" href="{{ url('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- JQVMap -->
<link rel="stylesheet" href="{{ url('adminlte/plugins/jqvmap/jqvmap.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ url('adminlte/dist/css/adminlte.min.css') }}">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ url('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ url('adminlte/plugins/daterangepicker/daterangepicker.css') }}">
<!-- summernote -->
<link rel="stylesheet" href="{{ url('adminlte/plugins/summernote/summernote-bs4.css') }}">
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<script src="{{ url('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>


<style>
    .text-link {
        color: #007bff;
        cursor: pointer;
    }
    .cursor-default {
        cursor: default;
    }
    body{
        /*font-family: Montserrat !important;*/
    }
    body {
     font-family: Montserrat !important;
     font-size: small;
    }
    a {
     font-family: Montserrat !important;
     font-size: small;
    }
    
    .table-border-gray{
        border: 2px solid gray !important;
        padding: 0.5rem !important;
        border-radius: 0.5rem !important;
    }
    .table-border-gray td{
        padding-top: 1rem !important;
        padding-bottom: 1rem !important;
    }
    .form-control{
        font-size: small !important;
    }
</style>

<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-analytics.js"></script>
<script> var AuthUser = "{{ (\Auth::user()) ? Auth::user() : null }}";</script>
@stack('css')
