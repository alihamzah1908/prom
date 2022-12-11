@extends('template.default')
@section('title', 'User')
@section('submenu')
<div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="m-0 text-dark"><strong>User Account</strong></h3>
        <small>User Account > Create</small>
    </div>
</div>
@endsection
@section('content')

<div class="card">
    <!-- /.card-header -->
    <div class="card-header">
        <h3 class="card-title"> <strong>Create</strong></h3>
    </div>
    {{-- card body --}}
    <form action="">
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="User One">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="departemen">Departemen</label>
                        <input type="email" class="form-control" name="departemen" id="departemen" placeholder="Departemen">
                    </div>
                    <div class="form-group">
                        <label for="email">Role</label>
                        <select class="form-control select2" style="width: 100%;">
                            <option>CUSTOMER</option>
                            <option>KEPALA DIVISI</option>
                            <option>MANAJER</option>
                            <option>KEPALA SUB</option>
                            <option>STAFF</option>
                            <option>SITE SUPERVISOR</option>
                            <option>PATROL SUPPORT</option>
                            <option>SITE KEEPER INT</option>
                            <option>ENGINER & KOORDINATOR P4</option>
                            <option>TECHNICAL ENGINER</option>
                            <option>SITE KEEPER TS</option>
                            <option>HELPER</option>
                            <option>JOINTER</option>
                            <option>VENDOR</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="site_address">Deskripsi</label>
                        <textarea name="site_address"
                            class="form-control" id="site_address"
                            rows="4" placeholder="Customer One"></textarea>
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-5">
                    <div class="form-group" >
                        <label>Access</label>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox">
                            <label class="form-check-label text_name">Weekly</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox">
                            <label class="form-check-label text_name">Dashboard</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox">
                            <label class="form-check-label text_name">Task</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox">
                            <label class="form-check-label text_name">Aktivasi Layanan</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox">
                            <label class="form-check-label text_name">Site Permit</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox">
                            <label class="form-check-label text_name">Regional GPS</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer" style="    background-color: #fff;">
            <button type="submit" class="btn btn-primary mr-3">Submit</button>
            <button type="submit" class="btn" style="color: #ffff; background-color: #CECECE">Cancle</button>
        </div>
    </form>
    <!-- /.card-body -->
</div>
@endsection
@push('scripts')
<script>
    $('.select2').select2();

</script>
@endpush
