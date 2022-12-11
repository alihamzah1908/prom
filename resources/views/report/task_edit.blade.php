@extends('template.default')
@section('title', 'Task Reports')
@section('submenu')
<div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="m-0 text-dark"><strong>Task Reports</strong></h3>
    </div>
</div>
@endsection
@section('content')

@if(Session::has('message'))
<div class="alert {{Session::get('alert-class')}} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{ Session::get('message') }}
</div>
@endif
<link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link href='/css/dragula.css' rel='stylesheet' type='text/css' />
<link href='/css/dragula_example.css' rel='stylesheet' type='text/css' />
<style>
    td.details-control {
        background: url('/images/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('/images/details_close.png') no-repeat center center;
    }
    
    .display-none{
        display:none !important;
    }
</style>

<form method="POST" action="/report/task_columns" class="form-report-column">
@csrf
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-10">
                <h3 class="card-title"><strong>New Reports</strong></h3>
            </div>
            <div class="col-md-2">
                <a href="/report/task?id={{isset($report_columns->id)?$report_columns->id:''}}" class="btn btn-sm btn-success pull-right">Report Query</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label>Name</label>
            <input name="id" value="{{isset($report_columns->id)?$report_columns->id:''}}" hidden>
            <input class="form-control" name="name" required autofocus placeholder="Name" value="{{isset($report_columns->name)?$report_columns->name:''}}">
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" name="description" required autofocus placeholder="Description" rows="3">{{isset($report_columns->description)?$report_columns->description:''}}</textarea>
        </div>
        <div class="wrapper row">
            <div class="col-md-6 container" id="left-rm-spill" style="border: 1px solid; max-height: 75vh; overflow: auto;">
                @foreach(getTaskColumns() as $key => $val)
                    @if(!in_array($val['field'], $columns))
                        <div id="{{$val['field']}}" data-field="{{$val['field']}}">{{$val['name']}}</div>
                    @endif
                @endforeach
            </div>
            
            <div class="col-md-6 container" id="right-rm-spill" style="border: 1px solid; max-height: 75vh; overflow: auto;">
                @foreach(getTaskColumns() as $key => $val)
                    @if(in_array($val['field'], $columns))
                        <div id="{{$val['field']}}" data-field="{{$val['field']}}">{{$val['name']}}</div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="/report/task" class="btn btn-md btn-default">BACK</a>
        <button type="submit" class="btn btn-md btn-success float-right">Submit</button>
    </div>
</div>
</form>

<script src='https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.js'></script>
<script>
    var main_drake = dragula([document.getElementById('left-rm-spill'),document.getElementById('right-rm-spill')], {
      revertOnSpill: true,
      removeOnSpill: false,
    });
    
    main_drake.on('drop', function(el, target, source, sibling){
        var ini = $(el)
    });
    
    $(document).on('submit', '.form-report-column', function(e){
        e.preventDefault();
        $('#modal_new_data').modal('hide');
        var e_modal_wait = $("#modalWait");
        showLoading(e_modal_wait);
        
        var ini = $(this),  input_token = ini.find('input[name=_token]'),   url = ini.attr('action');
        
        var divs = $("#right-rm-spill").children("div");
            fields = []
            $.each(divs, function( index, value ) {
                el = $(value);
                fields.push(el.data('field')); 
            });
        
        $.ajax({
            url: url,
            type: "post",
            data: {
                is_ajax: true,
                _token: input_token.val(),
                id: ini.find('input[name=id]').val(),
                name: ini.find('input[name=name]').val(),
                description: ini.find('textarea[name=description]').val(),
                fields: fields,
            }
        })
        .done(function (result) {
            hideLoading(e_modal_wait);
            input_token.val(result.newtoken);
            if (result.status) {
                var message = result.message || 'Success';
                successAlert(message);
                location.reload()
            } else {
                var message = result.message || 'Api connection problem';
                failedAlert(message);
            }
        })
        .fail(ajax_fail);
    });
</script>
@endsection