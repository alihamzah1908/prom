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
    @forelse($task->getLog()->orderBy('id_log','DESC')->get() as $log)
    <li>
        <i class="fa {{$log->action == 'CREATE' ? 'fa-plus bg-success':'fa-edit bg-warning'}}" style="color: white !important;"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> {{date('l H:i, F jS, Y', strtotime($log->created_at))}}</span>
            <h3 class="timeline-header">
                <a href="#">{{isset($log->creator)?$log->creator->name:''}}</a> {{$log->action}} <i>{{$task->subject}}</i>
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
                            <td width="20%">TASK ID</td>
                            <td>: TASKI {{isset($log_to->Task_UID)?$log_to->Task_UID:'-'}}</td>
                        </tr>
                        <tr>
                            <td width="20%">SUBJECT</td>
                            <td>:  {{isset($log_to->Subject)?$log_to->Subject:'-'}}</td>
                        </tr>
                        <tr>
                            <td width="20%">STATUS</td>
                            <td>:  {{$log->status_to}}</td>
                        </tr>
                        <tr>
                            <td width="20%">LOGGED BY</td>
                            <td>:  {{$task->creator->name}}</td>
                        </tr>
                        <tr>
                            <td width="20%">PRIORITY</td>
                            <td>:  {{isset($log_to->Priority_Name)?$log_to->Priority_Name:'-'}}</td>
                        </tr>
                        <tr>
                            <td width="20%">REGION</td>
                            <td>:  {{isset($log_to->Region)?$log_to->Region:'-'}}</td>
                        </tr>
                        <tr>
                            <td width="20%">IMPACT</td>
                            <td>:  {{isset($log_to->Impact)?$log_to->Impact:'-'}}</td>
                        </tr>
                        <tr>
                            <td width="20%">IMPACT DETAIL</td>
                            <td>:  {{isset($log_to->Impact_Detail)?$log_to->Impact_Detail:'-'}}</td>
                        </tr>
                        <tr>
                            <td width="20%">CATEGORY</td>
                            <td>:  {{isset($log_to->Category)?$log_to->Category:'-'}}</td>
                        </tr>
                          <tr>
                            <td width="20%">CREATED DATE</td>
                            <td>: {{date('l H:i, F jS, Y', strtotime($log->created_at))}}</td>
                        </tr>
                          <tr>
                            <td width="20%">NOTE</td>
                            <td>: {{isset($log->note)?$log->note:'-'}}</td>
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
                Task doesn`t have any log yet!
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