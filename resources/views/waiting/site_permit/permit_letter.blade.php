@extends('template.default')
@section('submenu')
<div class="row mb-2 pb-3">
    <div class="col-sm-6">
        <h3 class="m-0 text-dark"><strong>Permit Letter</strong></h3>
        <small>Site Permit > Permit Letter</small>
    </div>
</div>
@endsection
@section('content')

<form method="POST" action="/site-permit/new-permit-letter" enctype="multipart/form-data"> 
@csrf
<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">Permit Letter Form</h3>
    </div>
    <div class="card-body" style="border-bottom: 1px solid rgba(0, 0, 0, .125);">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label>Site</label>
                    <select class="form-control select2" style="width: 100%;" required autofocus name="id_site">
                        <option selected="selected" disabled value="">-- Select Site --</option>
                        @foreach(\App\Model\Site::get() as $site)
                            <option value="{{$site->site_id}}" @if(old('id_site') == $site->site_id) selected @endif>{{$site->name_site}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Nama Pemohon</label>
                    <input type="text" class="form-control" name="pemohon"  placeholder="Nama pemohon" required autfocus>
                </div>
                <div class="form-group">
                    <label>Nama Instansi</label>
                    <input type="text" class="form-control" name="instansi" placeholder="Nama instansi" required autfocus>
                </div>
                <div class="form-group">
                    <label>Departemen</label>
                    <input type="text" class="form-control" name="departemen" placeholder="Departemen" required autfocus>
                </div>
                <div class="form-group">
                    <label>Nama Atasan</label>
                    <input type="text" class="form-control" name="atasan" placeholder="Nama Atasan" required autfocus>
                </div>
                <div class="form-group">
                    <label for="telepon">Nomor Telepon</label>
                    <input type="number" class="form-control" name="nomor_telepon" placeholder="Nomor Telepon" required autfocus>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <div class="form-group">
                    <label>Tanggal Pengajuan</label>
                    <input type="datetime-local" class="form-control" name="tanggal_pengajuan" required autfocus>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Berlaku</label>
                            <input type="datetime-local" class="form-control" name="tanggal_berlaku" required autfocus>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>s.d</label>
                            <input type="datetime-local" class="form-control" name="tanggal_berlaku_sd" required autfocus>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Jumlah Pengunjung</label>
                    <input type="number" class="form-control jumlah_pengunjung" name="jumlah_pengunjung"  placeholder="Jumlah Pengunjung" min="1" max="5" value="1" required autfocus>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Nama Pengunjung</label>
                    </div>
                    <div class="col-md-6">
                        <label>ID Pengunjung</label>
                    </div>
                </div>
                <div class="row wrapper_pengunjung">
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" name="nama_pengunjung[]"  placeholder="Nama Pengunjung" required autfocus>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="file" class="form-control" name="id_pengunjung[]" required autfocus>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
</form>
<!-- /.card -->

@endsection
@push('scripts')
    <script>
        $('.select2').select2();
        var pengunjung = '<div class="form-group col-md-6">' +
                            '<input type="text" class="form-control" name="nama_pengunjung[]"  placeholder="Nama Pengunjung" required autfocus>' +
                         '</div>' +
                         '<div class="form-group col-md-6">' +
                            '<input type="file" class="form-control" name="id_pengunjung[]" required autfocus>' +
                         '</div>';
        $(document).on('change input paste', '.jumlah_pengunjung', function(e){
            e.preventDefault();
            wrapper = $('.wrapper_pengunjung');
            wrapper.html("")
            wrapper_html = "";
            for(var i = 1; i <= $(this).val(); i++){
                wrapper_html += pengunjung;
            }
            wrapper.html(wrapper_html);
        })
    </script>
@endpush
