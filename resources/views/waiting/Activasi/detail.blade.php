@extends('template.default')
@section('submenu')
<div class="row mb-2 pb-3">
    <div class="col-sm-6">
        <h3 class="m-0 text-dark"><strong>Mop</strong></h3>
        <small>Aktivasi > Mop</small>
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
@if(Session::has('message_2'))
<div class="alert {{Session::get('alert-class-2')}} alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>{{ Session::get('message_2') }}</div>
@endif
<style>
    .is_mine{
        border: solid 2px red;
    }
    .main-sidebar{
        z-index:1000 !important;
    }
</style>
<link rel="stylesheet" href="/css/adminlte.min.css">
<div class="card col-md-12" style="border-top: 2px solid #ddd; margin-left: 0px; padding:0.1rem; margin-bottom: 2px !important; border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
    <ul class="nav nav-pills row text-center col-md-10" style="margin-left: 0;margin-right: 0;">
        <li class="nav-item col-md-2"><a style="border-radius:0" class="nav-link active" href="#detail" data-toggle="tab">Detail</a></li>
        <li class="nav-item col-md-2"><a style="border-radius:0" class="nav-link {{$is_approver ? 'is_mine':''}}" href="#approval" data-toggle="tab">Approval</a></li>
    </ul>
</div>
<div class="card" style="border-top-left-radius: 0; border-top-right-radius: 0;">
    <div class="card-body" style="background-color: #f1f1f1;">
        <div class="tab-content">
            <div class="active tab-pane" id="detail">
                @include('Activasi.a_detail')
            </div>
            <div class="tab-pane" id="approval"> 
                @include('Activasi.a_approval')
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a class="btn btn-md btn-default col-md-2" href="/aktivasi-layanan">BACK</a>
    </div>
</div>
@endsection
