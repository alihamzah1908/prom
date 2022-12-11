@extends('setup.template.default')

@section('title','Task Template')

@section('navbar')

@endsection
@section('content')

<link href='/css/dragula.css' rel='stylesheet' type='text/css' />
<!--<link href='/css/dragula_example.css' rel='stylesheet' type='text/css' />-->

<style>
    .card-body {
        padding-top: 0.45 !important;
        padding-right: 0.45rem !important;
        padding-bottom: 0 !important;
        padding-left: 0.45rem !important;
        min-height: 5rem;
    }
    .card{
        border-radius:0;
        margin-bottom: 0.5rem;
    }
    .handle{
        cursor:pointer;
    }
    #el_source > div{
        /*cursor:pointer;*/
    }
    #main_target > div{
        /*cursor:pointer;*/
    }
    .bg-grays {
        background-color: #ebeef3;
        color: #1f2d3d;
    }
    .border-1{
        border:1px solid #000;
    }
    .input-transparent{
        border:none;
    }
    .display-none{
        display:none;
    }
    .modal-footer {
        padding: 0.5rem;
        margin-top: 30px !important;
        border-top: 1px solid #e9ecef;
    }
    .form-field {
        cursor:pointer;
    }
    .tooltip {
      position: relative;
      /*display: inline-block;*/
      /*border-bottom: 1px dotted black;*/
      opacity:1;
      z-index: 1;
      margin-bottom: 1rem;
    }
    
    .tooltip .tooltiptext {
      visibility: hidden;
      width: 150px;
      background-color: black;
      color: #fff;
      text-align: center;
      border-radius: 6px;
      padding: 5px 0;
      position: absolute;
      z-index: 1;
      bottom: 80%;
      left: 50%;
      margin-left: -60px;
    }
    
    .tooltip .tooltiptext::after {
      content: "";
      position: absolute;
      top: 100%;
      left: 50%;
      margin-left: -5px;
      border-width: 5px;
      border-style: solid;
      border-color: black transparent transparent transparent;
    }
    .tooltip:hover .tooltiptext {
      visibility: visible;
    }
    
    .btn , .handle{
        text-align:left !important;
    }
</style>
<form method="POST" action="#" class="">
@csrf
<div class="card martop-1">
    <div class="card-header">
        <div class="row">
            <div class="col-md-7">
                <h3 class="card-title">Template Add ons</h3>
            </div>
        </div>
    </div>
    <br>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <label>Template</label>
                <select class="form-control" onchange="document.location.href='?id='+this.value">
                    <option value="" selected disabled>- Template-</option>
                    @foreach(\App\Templates::where('id_task_type', $id_template)->get() as $t)
                        <option value="{{$t->id}}" {{request()->id == $t->id ? 'selected':''}}>{{$t->template_name}}</option>
                    @endforeach
                </select>
                <br><hr><br>
            </div>
            @if(request()->id)
            @if($temp->template_name)
            <div class="col-md-10">
                @include('task_templates.add_ons')
            </div>
            <div class="col-md-2 bg-grays card display-nones">
                <div class="card-header">
                    <div class="card-title">
                        Elements
                    </div>
                </div>
                <div id="el_source" class="card-body margin text-left mb-3" style="overflow:overflow;">
                    @foreach($elements as $k => $el)
                        <div class="btn btn-sm bg-white col-md-12 mt-1 handle" data-type="{{$el['type']}}">
                            <i class="fas {{$el['icon']}} mr-1">{{getIndex($el, 'icon_alt', '')}}</i> {{$el['text']}}
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
            @endif
        </div>
    </div>
    <div class="card-footer">
        <!--<a class="btn btn-md btn-default" href="/setup/template-form">Back</a>-->
        <a class="btn btn-md btn-default" href="/setup/template-form/{{$id_template}}">Back</a>
    </div>
</div>
</form>

<div class="modal fade" id="modal_update_element">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="#" class="form-update-element">
                <div class="modal-header">
                    <h3 class="modal-title">Field Set</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Field ID</label>
                        <input class="form-control" readonly name="field_id">
                    </div>
                    <div class="form-group">
                        <label>Field Type</label>
                        <input class="form-control" readonly name="field_type">
                    </div>
                    <div class="form-group">
                        <label>Field Name</label>
                        <input class="form-control" placeholder="Field Name" name="field_name">
                    </div>
                    <div class="form-group">
                        <label>Default value</label>
                        <input class="form-control" placeholder="Default value" name="field_default_value">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-info btn-sm text-light" style="font-weight:bold; font-size:15px" data-dismiss="modal">Close</a>
                    <button class="btn btn-success btn-updatae-element">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src='https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.js'></script>


<script>
    
function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
$(document).on('click', '.save-form-template-add-ons', function(e){
    e.preventDefault();
    
    var e_modal_wait = $("#modalWait");
    showLoading(e_modal_wait);
    
    var ini = $(this), input_token = $('input[name=_token]'), url = ini.data('action');
    
    var post_data = {
        is_ajax: true,
        _token: input_token.val(),
    };
    
    var fields = [];
    var form_fields = document.getElementsByClassName('form-field');
    for(var i = 0; i < form_fields.length; i++){
        var form_field = $(form_fields[i]);
        var field = form_field.data('field');
        fields.push(field)
    }
    post_data.fields = fields;
    var parents = $('input[name^=section_name]').map(function(idx, elem) {
        return $(elem).val();
    }).get();
    
    parents_id = []
    parents_div = document.getElementsByClassName('card_body_target');
    for(var t = 0; t < parents_div.length; t++){
        var target = parents_div[t];
        target = document.getElementById(target.id);
        parents_id.push(target.id)
    }
    
    post_data.parents = parents;
    post_data.parents_id = parents_id;
    
    postData(post_data);
    
    function postData(post_data) {
        $.ajax({
            url: url,
            type: "post",
            data: post_data
        })
        .done(function (result) {
            hideLoading(e_modal_wait);
            input_token.val(result.newtoken);
            if (result.status) {
                var message = result.message || 'Success';
                successAlert(message);
            } else {
                var message = result.message || 'Api connection problem';
                failedAlert(message);
            }
            input_token.val(result.newtoken);
        })
        .fail(ajax_fail);
    }
});
    
$(document).on('dblclick', '.form-field', function(e){
    e.preventDefault();
       
    var ini = $(this),
        field = ini.data('field'),
        id = this.id,
        modal_update_element = $('#modal_update_element');
       
    modal_update_element.find('input[name=field_id]').val(id);
    modal_update_element.find('input[name=field_type]').val(field.type);
    modal_update_element.find('input[name=field_default_value]').attr('type', field.type);
    modal_update_element.find('input[name=field_name]').val(field.name);
    modal_update_element.find('input[name=field_default_value]').val(field.default_value);
    modal_update_element.modal('show');
});

$(document).on('submit', '.form-update-element', function(e){
    e.preventDefault();
    
    var ini = $(this);
    var id = ini.find('input[name=field_id]').val();
    var name = ini.find('input[name=field_name]').val();
    var default_value = ini.find('input[name=field_default_value]').val();
    
    var el = $("#"+id);
    var field = el.data('field');
    field.name = name;
    field.default_value = default_value;
    field = JSON.stringify(field);
    el.attr('data-field', field);
    el.val(default_value);
    
    parent = el.parents('.form-group');
    parent.find('label').html(name);
    
    var modal_update_element = $('#modal_update_element');
    modal_update_element.modal('hide');
})
</script>

<script>

var main_source = document.getElementById('el_source');
var main_target = document.getElementById('main_target');
var arr_target = [main_source, main_target];

function newSectionTemplate(id){
    var section_template = '<div class="card section_card">' +
                                '<div class="card-header">' +
                                    '<h3 class="card-title text-dark"><i class="fa fa-arrows-alt handle"></i>Title</h3>' +
                                    '<div class="card-tools">' +
                                        '<button class="btn-remove-section">'+
                                            '<i class="fa fa-trash">' +
                                        '</button>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="card-body row card_body_target" id="'+id+'"></div>' +
                            '</div>';
    // return section_template;
}

$(document).ready(function () {
    // $('body').addClass('sidebar-collapse');
    
    initDragula()
    
    $('.btn-new-section').on('click', function(e){
        e.preventDefault();
        var main_target = $('#main_target'),
            main_html = main_target.html(),
            template_id = makeid(8),
            template = newSectionTemplate(template_id);
        
        main_html += template;
        main_target.html(main_html);
        
        initDragula()
    });
});

$("#main_target").delegate(".btn-remove-section", "click", function(e){
    e.preventDefault();
    var ini = $(this),
        card = ini.parents('.section_card');
    console.log(card)
    card.remove();
    initDragula()
});
 
function initDragula(){
    var main_source = document.getElementById('el_source');
    var main_target = document.getElementById('main_target');
    var new_arr_target = [main_source, main_target];
    
    targets = document.getElementsByClassName('card_body_target');
    for(var t = 0; t < targets.length; t++){
        var target = targets[t];
        target = document.getElementById(target.id);
        new_arr_target.push(target);
    }
    
    setDragula(new_arr_target);
}
function setDragula(arr_target){
  var main_drake = dragula(arr_target, {
      revertOnSpill: true,
      removeOnSpill: true,
      copy: function (el, source) {
        return source === main_source
      },
      accepts: function (el, target, source, sibling) {
        if(target.id === "main_target"){
            if(el.classList.contains('card')){
                return el.classList.contains('card')
            }
            return target.id !== "main_target"
        }
        if(target.className === "card-body"){
            if(el.classList.contains('card')){
                return !el.classList.contains('card')
            }
            return target.id !== "main_target"
        }
        if(el.className === "undragable"){
          return el.className !== "undragable";
        }
        
        return target !== main_source
      },
    //   moves: function (el, container, handle) {
    //     //   console.log(handle);
    //     return handle.classList.contains('handle');
    //   }
      invalid: function (el, handle) {
        return el.classList.contains('card');
      }
    });
    
    main_drake.on('drop', function(el, target, source, sibling){
        var ini = $(el),
            type = ini.data('type');
            ini.removeClass();
            target = target.id;
        var html_base = newInputBase(target,type);
        
        ini.addClass('form-group');
        ini.addClass('tooltip');
        ini.addClass('col-md-6');
        ini.addClass('handle');
        ini.html(html_base);
    });
}
function makeid(length) {
   var result           = '';
   var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return result;
}

function newInputBase(target, type){
    var html_base = "";
    var id = makeid(12);
    var field = {
            'parent': target,
            'id': id,
            'name': id,
            'type': type,
            'default_value': '',
        };
    if(type === 'select'){
        field.options = [
                            {
                                'value': '',
                                'text': "Select",
                                'selected': true,
                                'disabled': false,
                            }
                        ];
                        
        field = JSON.stringify(field);
        html_base = '<label>Select Name</label>' + 
                    "<select class='form-control form-field' placeholder='Select Name' id='"+id+"' data-field='"+field+"'>" + 
                        '<option value="">Select</option>' +
                    '</select>';
    
    }else if(type === 'checkbox'){
        field.options = [
                            {
                                'id': id,
                                'name': id,
                                'value': 'Checkbox 1',
                                'text': "Checkbox 1",
                                'selected': true,
                                'disabled': false,
                            }
                        ];
        field = JSON.stringify(field);
        html_base = '<label>Checkbox Name</label>' +
                    "<div class='input-group form-field' data-field='"+field+"'>" +
                        '<div class="input-group-prepend">' +
                            '<span class="input-group-text">' +
                                '<input type="checkbox" id="'+id+'" name="'+id+'" selected data-field="'+field+'">' +
                            '</span>' +
                        '</div>' +
                        '<input type="text" readonlys value="Checkbox 1" class="form-control">' +
                    '</div>';
    
    }else if(type === 'radio'){
        field.options = [
                            {
                                'id': id,
                                'name': id,
                                'value': 'Radio 1',
                                'text': "Radio 1",
                                'selected': true,
                                'disabled': false,
                            }
                        ];
        field = JSON.stringify(field);
        html_base = '<label>Radio Name</label>' +
                    "<div class='input-group form-field' data-field='"+field+"'>" +
                        '<div class="input-group-prepend">' +
                            '<span class="input-group-text">' +
                                '<input type="radio" id="'+id+'" name="'+id+'">' +
                            '</span>'  +
                        '</div>' +
                        '<input type="text" readonlys value="radio text" class="form-control">' +
                    '</div>';
    }else if(type === 'textarea'){
        field.placeholder = 'Textarea';
        field.rows = "";
        field.max_length = "";
        field.title = "";
        field = JSON.stringify(field);
        html_base = '<label>Textarea Name</label>' +
                    "<textarea class='form-control form-field' id='"+id+"' data-field='"+field+"' placeholder='Text area name' style='resize: none;' rows='3' readonlys></textarea>";
    }else if(type === 'EMPTY_ROW'){
        field = JSON.stringify(field);
        html_base = "<input class='form-field' type='"+type+"' id='"+id+"' data-field='"+field+"' hidden>";
    }else{
        field.placeholder = '';
        field.min_length = "";
        field.max_length = "";
        field.min = "";
        field.max = "";
        field.pattern = "";
        field.title = "";
        field.autocomplete = "off";
        field.accept = "";
        field = JSON.stringify(field);
        html_base = '<label>Input Name</label>' +
                    "<input class='form-control form-field' placeholder='Input Name' type='"+type+"' id='"+id+"' data-field='"+field+"' autocomplete='off' readonlys>";
    }
    
    if(type === 'EMPTY_ROW'){
        html_base += '<span class="tooltiptext">Empty Row</span>';
    }else{
        html_base += '<span class="tooltiptext">Double Click to modify!</span>';
    }
    return html_base;
}
</script>
@endsection




