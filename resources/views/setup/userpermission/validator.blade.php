
<div id="menu3" class="content_header">
    <div class="content_menu">
        <h4 class="title_2">Validator</h4>
        <div class="row">
            <div class="col-md-2 form-group">
                <button type="button" class="form-control bg-primary" data-toggle="modal" data-target="#approverModal"> <i
                        class="fa fa-plus nav-icon"></i>&nbsp;&nbsp;Create
                </button>
            </div>
            <div class="col-md-2 form-group">
                <select class="form-control btn-default" type="text" name="region_name" id="region_id"
                onchange="document.location.href = '?view={{request()->view}}&region=' + this.value">
                        <option selected value="">Region</option>
                        @foreach($regions as $region)
                        <option value="{{$region->region_id}}" {{( request('region') == $region->region_id ) ? 'selected' : '' }}>
                            {{$region->region_name}}
                        </option>
                        @endforeach
                </select>
            </div>
        </div>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="8%"></th>
                            <th>Region</th>
                            <th>Service Type</th>
                            <th>Layer Approver</th>
                            <th>Approvers</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Model\AktivasiApprover::get() as $d)
                        <tr>
                            <td>
                                <a href="#"><i class="fas fa-pen icon_color"></i></a>&nbsp;
                                <a href="#"><i class="fas fa-trash icon_color"></i></a>
                            </td>
                            <td class="text_name">{{isset($d->region)?$d->region->region_name:''}}</td>
                            <td class="text_name">{{isset($d->type)?$d->type->service_name:''}}</td>
                            <td class="text_name">{{$d->count_layer}}</td>
                            <td class="text_name">
                                <ul>
                                @foreach(\App\Model\AktivasiApproverDetail::where('id_approver', $d->id_approver)->get() as $detail)
                                    <li>
                                        {{isset($detail->user)?$detail->user->name:''}}
                                    </li>
                                @endforeach
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="modal fade" id="approverModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Validator</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/setup/userpermission/new_validator" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="segment" class="text_name form-control-label">Region</label>
                            <select class="form-control btn-default" name="id_region" required autofocus>
                                <option selected value="" disabled>Region</option>
                                @foreach($regions as $region)
                                <option value="{{$region->region_id}}">{{$region->region_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="segment" class="text_name form-control-label">Service Type</label>
                            <select class="form-control btn-default" name="id_type" required autofocus>
                                <option selected value="" disabled>Service Type</option>
                                @foreach(\App\Model\AktivasiType::get() as $d)
                                <option value="{{$d->id_service}}">{{$d->service_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" style="font-family: Montserrat; line-height: 17px;">Validators</label>
                        </div>
                        
                        <div class="form-group">
                            <label class="text_name form-control-label">Layer 1</label>
                            <select class="form-control btn-default" name="id_approver[]" required autofocus>
                                <option selected disabled value="">-- Select --</option>
                                @foreach($users as $u)
                                <option value="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="text_name form-control-label">Layer 2</label>
                            <select class="form-control btn-default" name="id_approver[]" required autofocus>
                                <option selected disabled value="">-- Select --</option>
                                @foreach($users as $u)
                                <option value="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="text_name form-control-label">Layer 3</label>
                            <select class="form-control btn-default" name="id_approver[]" required autofocus>
                                <option selected disabled value="">-- Select --</option>
                                @foreach($users as $u)
                                <option value="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="text_name form-control-label">Layer 4</label>
                            <select class="form-control btn-default" name="id_approver[]" required autofocus>
                                <option selected disabled value="">-- Select --</option>
                                @foreach($users as $u)
                                <option value="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="text_name form-control-label">Layer 5</label>
                            <select class="form-control btn-default" name="id_approver[]" required autofocus>
                                <option selected disabled value="">-- Select --</option>
                                @foreach($users as $u)
                                <option value="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">Save</button>
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE">Cancle</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    function is_required(el){
        el.removeClass('display-none');
        el.attr('required','required');
        el.attr('autofocus','autofocus');
    }
    function is_unrequired(el){
        el.addClass('display-none');
        el.attr('required',false);
        el.attr('autofocus',false);
    }
</script>