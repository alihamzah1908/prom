<!--<script src="{{ url('adminlte/plugins/jquery/jquery.min.js') }}"></script>-->


<!--####################################################################################-->
<!--ini jangan tarok d sini-->
<!--ini khusus buat dashboard kan?-->
<!--klo khusus jan d tarok d tmpat yang bkal d pake dimana2-->

<!--####################################################################################-->


<!-- jQuery UI 1.11.4 -->
<script src="{{ url('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ url('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<!--<script src="{{ url('adminlte/plugins/chart.js/Chart.min.js') }}"></script>-->
<script src="/js/chart/Chart.min.js"></script>
<script src="/js/chart//utils.js"></script>
<!-- Sparkline -->
<script src="{{ url('adminlte/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ url('adminlte/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ url('adminlte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ url('adminlte/plugins/moment/moment.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ url('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ url('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ url('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ url('adminlte/dist/js/adminlte.js') }}"></script>



<!--############ data tables ############-->
<!--ane ndak tw posisi file local ny mka e ane pake yang dari dt table dulu-->
<!--klo ad yang local ntat ganti aj-->
<script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.min.js"></script>




<!--helpers ny-->
<!--<script src="{{ asset('/js/helper.js') }}"></script>-->
<script src="/js/helper.js?d={{date('H:i:s')}}"></script>
<script src="/js/notification.js?d={{date('H:i:s')}}"></script>
<script src="{{ asset('/js/data_table_helper.js?v=0.28') }}"></script>
<script>
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    if(dd<10){
        dd='0'+dd
    } 
    if(mm<10){
        mm='0'+mm
    } 
    
    today = yyyy+'-'+mm+'-'+dd;
    $('.select_creation_from').attr('max', today);
    $('.select_creation_to').attr('max', today);
    $('.select_completion_from').attr('max', today);
    $('.select_completion_to').attr('max', today);
    
    $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
        console.log(message);
    };
</script>
@stack('scripts')
