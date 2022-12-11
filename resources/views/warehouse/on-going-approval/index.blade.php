@extends('template.default')
@section('content')
@if (session('success'))
<div class="alert alert-danger">
    {{ session('success') }}
</div>
@endif
<div class="row mt-4">
    <div class="col-md-12">
        <label class="font-weight-bold">Data Material</label>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" width="10%">No</th>
                    <th scope="col" width="50%">Materinal Name</th>
                    <th scope="col" width="10%">Total Qty Out</th>
                    <th scope="col" width="10%">Unit</th>
                    <th scope="col" width="10%">Action </th>
                </tr>
            </thead>
            <tbody>
                @php
                $i = 1;
                @endphp
                @foreach($data as $val)
                <tr>
                    <td scope="row">{{ $i++ }}</td>
                    <td>{{ $val->material_name }}</td>
                    <td>{{ $val->qty }}</td>
                    <td>{{ $val->unit }}</td>
                    <td>
                        <a href="javascript:void(0)" data-id="{{ $val->id }}" class="approve">
                            <button class="btn btn-sm btn-success" type="button">approve</button>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('body').on('click', '.approve', function() {
            if (confirm('Are you sure want to approve ?')) {
                var id = $(this).attr('data-id')
                $.ajax({
                    dataType: 'json',
                    method: 'get',
                    url: '{{ route("material.approval") }}',
                    data: {
                        id: id
                    }
                }).done(function(response) {
                    if (response.status == 200) {
                        location.reload()
                    }
                })
            }
        })
    })
</script>
@endpush