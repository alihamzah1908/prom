@if($approval)
<div>
    <div class="card col-md-12" style="border-top: 2px solid #ddd; margin-left: 0px; padding:0.1rem; margin-bottom: 2px !important; border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
        <ul class="nav nav-pills row text-center col-md-10" style="margin-left: 0;margin-right: 0;">
            <li class="nav-item col-md-2"><a style="border-radius:0" class="nav-link {{$is_approver == 1 ? 'is_mine':''}} active" href="#approver_1" data-toggle="tab">Approver I</a></li>
            <li class="nav-item col-md-2"><a style="border-radius:0" class="nav-link {{$is_approver == 2 ? 'is_mine':''}}" href="#approver_2" data-toggle="tab">Approver II</a></li>
            <li class="nav-item col-md-2"><a style="border-radius:0" class="nav-link {{$is_approver == 3 ? 'is_mine':''}}" href="#approver_3" data-toggle="tab">Approver III</a></li>
        </ul>
    </div>
    @if($data->id_type != 4)
        <div class="card p0">
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="approver_1">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td width="15%"><b>VALIDATOR</b></td>
                                        <td><b>{{isset($approval->approver1)?$approval->approver1->name:'-'}}</b></td>
                                    </tr>
                                    <tr>
                                        <td width="15%"><b>Customer</b></td>
                                        <td>
                                            <b>
                                                {{isset($data->id_customer)?$data->id_customer:'-'}}
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="15%"><b>Site</b></td>
                                        <td>
                                            <b>
                                                {{isset($data->site)?$data->site->name_site:'-'}}
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="15%"><b>Region</b></td>
                                        <td>
                                            <b>
                                                {{isset($data->region)?$data->region->region_name:'-'}}
                                            </b>
                                        </td>
                                    </tr>
                                   
                                    <tr>
                                        <td width="15%"><b>Capasity Type</b></td>
                                        <td>
                                            <b>
                                                {{$data->capasity_type}}
                                            </b>
                                        </td>
                                    </tr>
                                    @if($data->capasity_type == "Sewa Kapasitas")
                                    <tr>
                                        <td width="15%"><b>Capacity</b></td>
                                        <td>
                                            <b>
                                                 {{isset($data->capacity)?$data->capacity->capacity_name:'-'}}
                                                <!--{{$data->capasity}}-->
                                            </b>
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td width="15%"><b>Capacity</b></td>
                                        <td>
                                            <b>
                                                {{isset($data->cord)?$data->cord->name_cord:'-'}}
                                            </b>
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td width="15%"><b>Memo</b></td>
                                        <td>
                                            <a href="/aktivasi/memo/{{$data->memo_file}}" target="new">
                                                <img src="/aktivasi/memo/{{$data->memo_file}}" width="20%">
                                            </a>
                                        </td>
                                    </tr>
                                     <tr>
                                        <td width="15%"><b>Bakti</b></td>
                                        <td>
                                            <a href="/aktivasi/bakti/{{$data->bakti_file}}" target="new">
                                                <img src="/aktivasi/bakti/{{$data->bakti_file}}" width="20%">
                                            </a>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        @if($is_approver == 1)
                        <div class="card-footer bg-transparent">
                            <button class="btn btn-sm btn-success float-right text-light btn-approval" data-status="APPROVED">APPROVE</button>
                            <button class="btn btn-sm btn-danger float-right text-light btn-approval mr-2" data-status="REJECTED">REJECT</button>
                        </div>
                        @endif
                    </div>
                    <div class="tab-pane" id="approver_2">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td width="15%"><b>VALIDATOR</b></td>
                                        <td><b>{{isset($approval->approver2)?$approval->approver2->name:'-'}}</b></td>
                                    </tr>
                                    <tr>
                                        <td width="15%"><b>Customer</b></td>
                                        <td>
                                            <b>
                                                {{isset($data->id_customer)?$data->id_customer:'-'}}
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="15%"><b>Site</b></td>
                                        <td>
                                            <b>
                                                {{isset($data->site)?$data->site->name_site:'-'}}
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="15%"><b>Region</b></td>
                                        <td>
                                            <b>
                                                {{isset($data->region)?$data->region->region_name:'-'}}
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="15%"><b>Segment</b></td>
                                        <td>
                                            <b>
                                                {{isset($data->segment)?$data->segment->segment_name:'-'}}
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="15%"><b>Capasity Type</b></td>
                                        <td>
                                            <b>
                                                {{$data->capasity_type}}
                                            </b>
                                        </td>
                                    </tr>
                                    @if($data->capasity_type == "Sewa Kapasitas")
                                    <tr>
                                        <td width="15%"><b>Capasity</b></td>
                                        <td>
                                            <b>
                                                {{$data->capasity}}
                                            </b>
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td width="15%"><b>Capasit</b></td>
                                        <td>
                                            <b>
                                                {{isset($data->cord)?$data->cord->name_cord:'-'}}
                                            </b>
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td width="15%"><b>Memo</b></td>
                                        <td>
                                            <a href="/aktivasi/memo/{{$data->memo_file}}" target="new">
                                                <img src="/aktivasi/memo/{{$data->memo_file}}" width="20%">
                                            </a>
                                        </td>
                                    </tr>
                                     <tr>
                                        <td width="15%"><b>Bakti</b></td>
                                        <td>
                                            <a href="/aktivasi/baksi/{{$data->bakti_file}}" target="new">
                                                <img src="/aktivasi/bakti/{{$data->bakti_file}}" width="20%">
                                            </a>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        @if($is_approver == 2)
                        <div class="card-footer bg-transparent">
                            <button class="btn btn-sm btn-success float-right text-light btn-approval" data-status="APPROVED">APPROVE</button>
                            <button class="btn btn-sm btn-danger float-right text-light btn-approval mr-2" data-status="REJECTED">REJECT</button>
                        </div>
                        @endif
                    </div>
                    <div class="tab-pane" id="approver_3">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td width="15%"><b>APPROVER</b></td>
                                        <td><b>{{isset($approval->approver3)?$approval->approver3->name:'-'}}</b></td>
                                    </tr>
                                    <tr>
                                        <td width="15%"><b>Customer</b></td>
                                        <td>
                                            <b>
                                                {{isset($data->id_customer)?$data->id_customer:'-'}}
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="15%"><b>Site</b></td>
                                        <td>
                                            <b>
                                                {{isset($data->site)?$data->site->name_site:'-'}}
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="15%"><b>Region</b></td>
                                        <td>
                                            <b>
                                                {{isset($data->region)?$data->region->region_name:'-'}}
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="15%"><b>Segment</b></td>
                                        <td>
                                            <b>
                                                {{isset($data->segment)?$data->segment->segment_name:'-'}}
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="15%"><b>Capasity Type</b></td>
                                        <td>
                                            <b>
                                                {{$data->capasity_type}}
                                            </b>
                                        </td>
                                    </tr>
                                    @if($data->capasity_type == "Sewa Kapasitas")
                                    <tr>
                                        <td width="15%"><b>Capasity</b></td>
                                        <td>
                                            <b>
                                                {{$data->capasity}}
                                            </b>
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td width="15%"><b>Capasity</b></td>
                                        <td>
                                            <b>
                                                {{isset($data->cord)?$data->cord->name_cord:'-'}}
                                            </b>
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td width="15%"><b>Memo</b></td>
                                        <td>
                                            <a href="/aktivasi/memo/{{$data->memo_file}}" target="new">
                                                <img src="/aktivasi/memo/{{$data->memo_file}}" width="20%">
                                            </a>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td width="15%"><b>Bakti</b></td>
                                        <td>
                                            <a href="/aktivasi/bakti/{{$data->bakti_file}}" target="new">
                                                <img src="/aktivasi/bakti/{{$data->bakti_file}}" width="20%">
                                            </a>
                                        </td>
                                    </tr>
                                    <tr><td width="15%"><b>&nbsp;</b></td><td><b>&nbsp;</b></td></tr>
                                    <tr>
                                        <td width="15%"><b>VALIDATOR I</b></td>
                                        <td><b>{{isset($approval->approver1)?$approval->approver1->name:'-'}}</b></td>
                                    </tr>
                                    <tr>
                                        <td width="15%"><b>Status</b></td>
                                        <td><b>{{isset($approval->approver_1_status)?$approval->approver_1_status:'-'}}</b></td>
                                    </tr>
                                    <tr>
                                        <td width="15%"><b>Remark</b></td>
                                        <td><b>{{isset($approval->approver_1_remark)?$approval->approver_1_remark:'-'}}</b></td>
                                    </tr>
                                    
                                    <tr><td width="15%"><b>&nbsp;</b></td><td><b>&nbsp;</b></td></tr>
                                    <tr>
                                        <td width="15%"><b>VALIDATOR II</b></td>
                                        <td><b>{{isset($approval->approver2)?$approval->approver2->name:'-'}}</b></td>
                                    </tr>
                                    <tr>
                                        <td width="15%"><b>Status</b></td>
                                        <td><b>{{isset($approval->approver_2_status)?$approval->approver_2_status:'-'}}</b></td>
                                    </tr>
                                    @if($data->id_type_service == 3)
                                    <tr>
                                        <td width="15%"><b>Remark</b></td>
                                        <td><b>{{isset($approval->approver_2_remark)?$approval->approver_2_remark:'-'}}</b></td>
                                    </tr>
                                    <tr>
                                        <td width="15%"><b>Document</b></td>
                                        <td>
                                            @if($approval->approver_2_document)
                                            <a href="/aktivasi/document/{{$approval->approver_2_document}}" target="new">
                                                <img src="/aktivasi/document/{{$approval->approver_2_document}}" width="20%">
                                            </a>
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td width="15%"><b>CID</b></td>
                                        <td>
                                            <b>
                                                {{isset($approval->approver_2_cid)?$approval->approver_2_cid:'-'}}
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="15%"><b>Document</b></td>
                                        <td>
                                            @if($approval->approver_2_document)
                                            <a href="/aktivasi/document/{{$approval->approver_2_document}}" target="new">
                                                <img src="/aktivasi/document/{{$approval->approver_2_document}}" width="20%">
                                            </a>
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="15%"><b>NE</b></td>
                                        <td>
                                            <?php 
                                            $approver_2_ne = $approval->approver_2_ne;
                                            if(!is_array($approver_2_ne)) $approver_2_ne = json_decode($approver_2_ne);
                                            if(!is_array($approver_2_ne)) $approver_2_ne = []
                                            ?>
                                            @forelse($approver_2_ne as $key => $val)
                                            <label>Segment {{$key + 1}}</label>
                                            <table class="table">
                                                <thead style="background: #c1c1c1;">
                                                    <tr>
                                                        <th>NE name</td>
                                                        <th>Shelf</td>
                                                        <th>Slot</td>
                                                        <th>Port</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{isset($val->ne_name_1)?$val->ne_name_1:'-'}}</td>
                                                        <td>{{isset($val->id_shelf_1)?$val->id_shelf_1:'-'}}</td>
                                                        <td>{{isset($val->id_slot_1)?$val->id_slot_1:'-'}}</td>
                                                        <td>{{isset($val->id_port_1)?$val->id_port_1:'-'}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{isset($val->ne_name_2)?$val->ne_name_2:'-'}}</td>
                                                        <td>{{isset($val->id_shelf_2)?$val->id_shelf_2:'-'}}</td>
                                                        <td>{{isset($val->id_slot_2)?$val->id_slot_2:'-'}}</td>
                                                        <td>{{isset($val->id_port_2)?$val->id_port_2:'-'}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            @empty
                                            @endforelse
                                        </td>
                                    </tr>
                                    @endif
                                    
                                    <tr><td width="15%"><b>&nbsp;</b></td><td><b>&nbsp;</b></td></tr>
                                    <tr>
                                        <td width="15%"><b>APPROVER III</b></td>
                                        <td><b>{{isset($approval->approver3)?$approval->approver3->name:'-'}}</b></td>
                                    </tr>
                                    <tr>
                                        <td width="15%"><b>Status</b></td>
                                        <td><b>{{isset($approval->approver_3_status)?$approval->approver_3_status:'-'}}</b></td>
                                    </tr>
                                    @if($data->id_type_service == 3)
                                    <tr>
                                        <td width="15%"><b>Remark</b></td>
                                        <td><b>{{isset($approval->approver_3_remark)?$approval->approver_3_remark:'-'}}</b></td>
                                    </tr>
                                    @else
                                    @endif
                                    <tr>
                                        <td width="15%"><b>Document</b></td>
                                        <td>
                                            @if($approval->approver_3_document)
                                            <a href="/aktivasi/document/{{$approval->approver_3_document}}" target="new">
                                                <img src="/aktivasi/document/{{$approval->approver_3_document}}" width="20%">
                                            </a>
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    
                                </thead>
                            </table>
                        </div>
                        @if($is_approver == 3)
                        <div class="card-footer bg-transparent">
                            <button class="btn btn-sm btn-success float-right text-light btn-approval" data-status="APPROVED">APPROVE</button>
                            <button class="btn btn-sm btn-danger float-right text-light btn-approval mr-2" data-status="REJECTED">REJECT</button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="modalApproval">
            <div class="modal-dialog @if($data->id_type_service != 3) @if($is_approver == 2) modal-lg @endif @endif">
                <div class="modal-content">
                    <form method="POST" action="/aktivasi-layanan/aktivasi-layanan-approval/{{$data->id}}" enctype="multipart/form-data"> 
                    @csrf
                        <div class="modal-header">
                            <h4 class="modal-title">Aktivasi Approval</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group text-center">
                                <img src="/images/approve.png">
                                <h5 class="mt-3 mb-4">
                                   Aktivasi Entry will be <span class="approval_status"></span>!
                                   <br>
                                   @if($data->id_type_service == 3)
                                   Please leave note:
                                   @else
                                       @if($is_approver == 1)
                                       Please leave note: 
                                       @endif
                                   @endif
                                </h5>
                                <div class="text-left">
                                    @if($is_approver == 1)
                                    <textarea class="form-control" name="note" required autofocus></textarea>
                                    @elseif($is_approver == 2)
                                        @if($data->id_type_service == 3)
                                        <div class="form-group">
                                            <label>Document</label>
                                            <input class="form-control" type="file" name="document" required autofocus>
                                        </div>
                                        <div class="form-group">
                                            <label>Remark</label>
                                            <textarea class="form-control" name="note" required autofocus></textarea>
                                        </div>
                                        @else
                                        <div>
                                            <div class="form-group">
                                                <label>CID</label>
                                                
                                                    <input class="form-control"  name="id_cid" required autofocus>
                                                
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Document</label>
                                                <input class="form-control" type="file" name="document" required autofocus>
                                            </div>
                                            
                                            <div id="ne_segment" class="form-group">
                                                <button id="add" type="button" class="btn-default float-right rounded"><i class="fa fa-plus nav-icon"></i></button>
                                                <button type="button" class="deleteBtn btn-default float-right mr-1 rounded"><i class="fa fa-minus nav-icon"></i></button>
                                                <label for="layer" class="text_name form-control-label">NE Segments</label>
                                                <div class="form-group" style="border: 1px solid #ced4da; padding: 0.5rem; border-radius: 5px; margin-top: 0.5rem;">
                                                    <label>Segment 1</label>
                                                    <div class="form-group row col-md-12">
                                                        <div class="col-md-6">
                                                            <label>NE Name</label>
                                                            <input class="form-control" placeholder="Name" name="segment[0][ne_name_1]" required autofocus>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="name">Shelf</label>
                                                            <select class="form-control btn-default" name="segment[0][id_shelf_1]" required autofocus>
                                                                <option value="" selected disabled>Shelf</option>
                                                                @foreach($shelfs as $c)
                                                                    <option value="{{$c->name_shelf}}">{{$c->name_shelf}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="name">Slot</label>
                                                            <select class="form-control btn-default" name="segment[0][id_slot_1]" required autofocus>
                                                                <option value="" selected disabled>Slot</option>
                                                                @foreach($slots as $v)
                                                                    <option value="{{$v->name_slot}}">{{$v->name_slot}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="name">Port</label>
                                                            <select class="form-control btn-default" name="segment[0][id_port_1]" required autofocus>
                                                                <option value="" selected disabled>Port</option>
                                                                @foreach($ports as $v)
                                                                    <option value="{{$v->port_name}}">{{$v->port_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row col-md-12">
                                                        <div class="col-md-6">
                                                            <label>NE Name</label>
                                                            <input class="form-control" placeholder="Name" name="segment[0][ne_name_2]" required autofocus>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="name">Shelf</label>
                                                            <select class="form-control btn-default" name="segment[0][id_shelf_2]" required autofocus>
                                                                <option value="" selected disabled>Shelf</option>
                                                                @foreach($shelfs as $c)
                                                                    <option value="{{$c->name_shelf}}">{{$c->name_shelf}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="name">Slot</label>
                                                            <select class="form-control btn-default" name="segment[0][id_slot_2]" required autofocus>
                                                                <option value="" selected disabled>Slot</option>
                                                                @foreach($slots as $v)
                                                                    <option value="{{$v->name_slot}}">{{$v->name_slot}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="name">Port</label>
                                                            <select class="form-control btn-default" name="segment[0][id_port_2]" required autofocus>
                                                                <option value="" selected disabled>Port</option>
                                                                @foreach($ports as $v)
                                                                    <option value="{{$v->port_name}}">{{$v->port_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @elseif($is_approver == 3)
                                        @if($data->id_type_service == 3)
                                        <textarea class="form-control" name="note" required autofocus></textarea>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control btn-default" name="id_status" required autofocus>
                                                <option value="" selected disabled>-- STATUS --</option>
                                                @foreach(\App\Model\AktivasiStatusCollocation::whereIn('id', [3,4])->get() as $c)
                                                    <option value="{{$c->id}}">{{$c->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @else
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control btn-default" name="id_status" required autofocus>
                                                <option value="" selected disabled>-- STATUS --</option>
                                                @foreach(\App\Model\AktivasiStatus::whereIn('id', [4,5])->get() as $c)
                                                    <option value="{{$c->id}}">{{$c->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif
                                        <div class="form-group">
                                            <label>Document</label>
                                            <input class="form-control" type="file" name="approver_3_document" required autofocus>
                                        </div>
                                    @endif
                                </div>
                                <input hidden value="" name="approval_status">
                            </div>
                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @push('scripts')
    <script>
        $(".deleteBtn").hide();
        $("#add").click(function(e) {
            $(".deleteBtn").fadeIn("1000");
            $("#ne_segment").append(getNewSegment());
            setSps()
        });
        $("body").on("click", ".deleteBtn", function(e) {
            $(".next_segment").last().remove();
        });
        function getNewSegment(){
            var num = 1;
            var ava = $('.next_segment');
            if(ava){
               num = ava.length + 1; 
            }
            var name = num + 1;
            if(true){
                var segment = '<div class="form-group next_segment" style="border: 1px solid #ced4da; padding: 0.5rem; border-radius: 5px; margin-top: 0.5rem;"><label>Segment '+name+'</label>' +
                    '<div class="form-group row col-md-12">' +
                        '<div class="col-md-6"><label>NE Name</label><input class="form-control" placeholder="Name" name="segment['+num+'][ne_name_1]" required autofocus></div>' +
                        '<div class="col-md-2"><label for="name">Shelf</label>' +
                            '<select class="form-control btn-default select_shelf" name="segment['+num+'][id_shelf_1]" required autofocus></select>' +
                        '</div>' +
                        '<div class="col-md-2"><label for="name">Slot</label>' +
                            '<select class="form-control btn-default select_slot" name="segment['+num+'][id_slot_1]" required autofocus></select>' +
                        '</div>' +
                        '<div class="col-md-2"><label for="name">Port</label>' +
                            '<select class="form-control btn-default select_port" name="segment['+num+'][id_port_1]" required autofocus></select>' +
                        '</div>' +
                    '</div>'+
                    '<div class="form-group row col-md-12">' +
                        '<div class="col-md-6"><label>NE Name</label><input class="form-control" placeholder="Name" name="segment['+num+'][ne_name_2]" required autofocus></div>' +
                        '<div class="col-md-2"><label for="name">Shelf</label>' +
                            '<select class="form-control btn-default select_shelf" name="segment['+num+'][id_shelf_2]" required autofocus></select>' +
                        '</div>' +
                        '<div class="col-md-2"><label for="name">Slot</label>' +
                            '<select class="form-control btn-default select_slot" name="segment['+num+'][id_slot_2]" required autofocus></select>' +
                        '</div>' +
                        '<div class="col-md-2"><label for="name">Port</label>' +
                            '<select class="form-control btn-default select_port" name="segment['+num+'][id_port_2]" required autofocus></select>' +
                        '</div>' +
                    '</div>'+
                '</div>';
            }
            return segment;
        }
        $(document).ready(function(){
            $(document).on('click', '.btn-approval', function(e){
                e.preventDefault();
                var ini = $(this),
                    status = ini.data('status');
                $('.approval_status').html(status);
                $('input[name=approval_status]').val(status);
                $('#modalApproval').modal('show');
            });
        });
        
        function setSps(){
            $(".select_port").select2({
                placeholder: "Port",
            ajax: {
                url: "/setup/getPort",
                dataType: "json",
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.port_name,
                                id: item.id_port
                            };
                        })
                    };
                },
                cache: false
            }
            });
            $(".select_slot").select2({
                placeholder: "Slot",
            ajax: {
                url: "/setup/getSlot",
                dataType: "json",
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.name_slot,
                                id: item.id_slot
                            };
                        })
                    };
                },
                cache: false
            }
            });
            $(".select_shelf").select2({
                placeholder: "Shelf",
            ajax: {
                url: "/setup/getShelf",
                dataType: "json",
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.name_shelf,
                                id: item.id_shelf
                            };
                        })
                    };
                },
                cache: false
            }
            });
        }
    </script>
    @endpush
    @else
        {{$data->type->service_name}}
    @endif
</div>
@else
<div class="alert alert-info">
    APPROVAL DATA DOES NOT EXIST OR HAS BEEN DELETED!
</div>
@endif