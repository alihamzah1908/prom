@extends('template.default')
@section('content')
@if (session('success'))
<div class="alert alert-danger">
    {{ session('success') }}
</div>
@endif
<div class="row mt-4">
    <div class="col-md-12">
        <form action="{{ route('location.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Location Name</label>
                        <input type="text" name="location_name" class="form-control" placeholder="Please insert location name" />
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-sm" type="submit">save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <label class="font-weight-bold">Data Location</label>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" width="10%">No</th>
                    <th scope="col" width="50%">Location Name</th>
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
                    <td>{{ $val->location_name }}</td>
                    <td>
                        <a href="{{ route('location.delete', $val->id) }}" onclick="confirm('Are you sure want to delete?')">
                            <button class="btn btn-sm btn-danger" type="button">delete</button>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection