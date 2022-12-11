@extends('setup.template.default')
@section('title_menu', 'Customization')
@section('content')


@if(Session::has('message'))
<div class="alert {{Session::get('alert-class')}} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{ Session::get('message') }}
</div>
@endif
<div class="content_menu">
    <h4 class="title_2">{{ __('setup-customization-index.type-task_language') }}</h4>
    <div class="row">
        <div class="col-md-4">
            <form role="form" enctype="multipart/form-data" class="form-select-type">
                <div class="form-group">
                    <!--<label>List Type Task</label>-->
                    <select class="form-control" id="select_type" required>
                        <option value="">{{ __('setup-customization-index.select-type-task_language') }}</option>
                        @foreach(\App\Model\TaskType::get() as $type)
                        <option value="{{$type->id_type}}">{{$type->type_name}}</option>
                        @endforeach
                        <option value="aktivasi_layanan">{{ __('setup-customization-index.services-activation_language') }}</option>
                    </select>
                </div>
                <div class="modal-footer" style="justify-content: end">
                    <button name="submit" type="submit"  style="width: 70px;" class="btn btn-primary">{{ __('setup-customization-index.next_language') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).on('submit', '.form-select-type', function(e){
        e.preventDefault(); 
        var type = document.getElementById("select_type").value;
        if(type === "aktivasi_layanan"){
            url = '/setup/aktivasi_layanan/cord';
        }else{
            url = '/setup/Customization/'+type+'/category';   
        }
        document.location.href = url
        
    })
</script>
@endsection
