@extends('template.default')
@section('title', $title)
@section('submenu')
<div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="m-0 text-dark"><strong>{{$title}}</strong></h3>
    </div>
</div>
@endsection
@section('content')
<div class="error-page">
<h2 class="headline text-danger">{{$error_code}}</h2>

<div class="error-content">
  <h3><i class="fas fa-exclamation-triangle text-danger"></i> {{$title}}.</h3>

  <p>
    <b>{{$message_title}}</b>
    <br>
    {{$message}}
  </p>

  <form class="search-form">
    <!--<div class="input-group">-->
    <!--  <input type="text" name="search" class="form-control" placeholder="Search">-->

    <!--  <div class="input-group-append">-->
    <!--    <button type="submit" name="submit" class="btn btn-danger"><i class="fa fa-search"></i>-->
    <!--    </button>-->
    <!--  </div>-->
    <!--</div>-->
    <!-- /.input-group -->
  </form>
</div>
</div>
<!-- /.error-page -->
@endsection