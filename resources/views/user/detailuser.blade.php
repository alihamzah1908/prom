@extends('template.default')
@section('title', 'User Detail')
@section('submenu')
<div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="m-0 text-dark"><strong>User Account</strong></h3>
        <small>User Account > Detail</small>
    </div>
</div>
@endsection
@section('content')

<div class="card">
    <!-- /.card-header -->
    <div class="card-header">
        <h3 class="card-title"> <strong>Lists</strong></h3>
    </div>
    {{-- card body --}}
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <p for="subject" class="text-name" style="margin-bottom: 0;">Nama</p>
                    <label for="subject">User One</label>
                </div>
                <div class="form-group">
                    <p for="subject" class="text-name" style="margin-bottom: 0;">Email</p>
                    <label for="subject">Userone@gmail.com</label>
                </div>
                <div class="form-group">
                    <p for="subject" class="text-name" style="margin-bottom: 0;">Role</p>
                    <label for="subject">Customer</label>
                </div>
                <div class="form-group">
                    <p for="subject" class="text-name" style="margin-bottom: 0;">Deskripsi</p>
                    <label for="subject">Guest from xl</label>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <a href="#" class="btn btn-primary">Back</a>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $('.select2').select2();

</script>
@endpush
