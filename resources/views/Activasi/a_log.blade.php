<style>
    table.dataTable.no-footer {
        border-bottom: 0 !important;
    }
    button.dt-button{
        padding:0.25rem !important;
    }
    .pull-right {
        float: right!important;
    }
</style>
<ul class="timeline timeline-inverse">
    @forelse($data->getLog()->orderBy('id_log','DESC')->get() as $log)
    <li>
        <i class="fa {{$log->action == 'CREATE' ? 'fa-plus bg-success':'fa-edit bg-warning'}}" style="color: white !important;"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> {{date('l H:i, F jS, Y', strtotime($log->created_at))}}</span>
            <h3 class="timeline-header">
                {{$log->action}} By <a href="#">{{isset($log->creator)?$log->creator->name:''}}</a>
            </h3>
            <div class="timeline-body text-right">
                <table class="table text-left" id="log_table_{{$log->id_log}}">
                    <thead style="display:none">
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    
                    <?php 
                    $log_to = json_decode($log->changed_data_to);
                    ?>
                    <tbody>
                        <tr>
                            <td width="20%">UID</td>
                            <td>:  {{isset($log_to->UID)?$log_to->UID:'-'}}</td>
                        </tr>
                          <tr>
                            <td width="20%">TYPE LAYANAN</td>
                            <td>:  {{isset($log_to->Type)?$log_to->Type:'-'}}</td>
                        </tr>
                        <tr>
                            <td width="20%">STATUS</td>
                            <td>:  {{$log->status_to}}</td>
                        </tr>
                        <tr>
                            <td width="20%">LOGGED BY</td>
                            <td>:  {{$log->creator->name}}</td>
                        </tr>
                        <tr>
                            <td width="20%">REGION</td>
                            <td>:  {{isset($log_to->Region)?$log_to->Region:'-'}}</td>
                        </tr>
                        <!--<tr>-->
                        <!--    <td width="20%">TYPE CAPACITY</td>-->
                        <!--   <td>:  {{isset($log_to->capacity_type)?$log_to->capacity:'-'}}</td>-->
                        <!--</tr>-->
                        <!--<tr>-->
                        <!--    <td width="20%">CAPACITY</td>-->
                        <!--    <td>:  {{isset($log_to->Capasity)?:'-'}}</td>-->
                        <!--</tr>-->
                         <tr>
                            <td width="20%">CREATE AT</td>
                            <td>:  {{date('l H:i, F jS, Y', strtotime($log->created_at))}}</td>
                        </tr>
                        
                    </tbody>
                </table>
                <button class="btn btn-sm btn-default btn-copy-table-{{$log->id_log}}">Copy</button>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                $('#log_table_{{$log->id_log}}').DataTable( {
                    ordering: false,
                    paginate: false,
                    searching: false,
                    info: false,
                    buttons: [  'copyHtml5' ],
                    dom:'',
                } );
            });
            $(document).on('click', '.btn-copy-table-{{$log->id_log}}', function(e) {
                var table = $("#log_table_{{$log->id_log}}");
                table.selectText();
                document.execCommand('copy');
            });
        </script>
    </li>
    @empty
    <li>
        <i class="fa fa-info bg-info"></i>
        <div class="timeline-item">
            <h3 class="timeline-header no-border">
                Aktivasi doesn`t have any log yet!
            </h3>
        </div>
    </li>
    @endforelse
    <li><i class="fa fa-clock bg-gray"></i></li>
</ul>
<script>
    jQuery.fn.selectText = function(){
        var doc = document;
        var element = this[0];
        console.log(this, element);
        if (doc.body.createTextRange) {
            var range = document.body.createTextRange();
            range.moveToElementText(element);
            range.select();
        } else if (window.getSelection) {
            var selection = window.getSelection();        
            var range = document.createRange();
            range.selectNodeContents(element);
            selection.removeAllRanges();
            selection.addRange(range);
        }
    };
</script>