@extends('template.default')
@section('content')
<div class="card">
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-danger">
            {{ session('success') }}
        </div>
        @endif
        <div class="row mt-4">
            <div class="col-md-12">
                <form action="{{ route('materialin.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Material Name</label>
                                <input type="text" id="material_name" class="form-control" placeholder="Please search material name" />
                                <input type="hidden" name="material_id" id="material_id" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Unit</label>
                                <select name="unit_id" class="form-control">
                                    <option value="">Please select</option>
                                    @foreach($unit as $val)
                                    <option value="{{$val->id }}">{{ $val->unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Location Name</label>
                                <input type="text" id="location_name" class="form-control" placeholder="Please search location name" />
                                <input type="hidden" name="location_id" id="location_id" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Project Name</label>
                                <select name="project_id" class="form-control">
                                    <option value="">Please select</option>
                                    @foreach($project as $val)
                                    <option value="{{$val->id }}">{{ $val->project_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Qty</label>
                                <input type="text" name="qty" class="form-control" placeholder="Please insert qty name" />
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Notes</label>
                                <textarea name="notes" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
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
                            <th scope="col" width="10%">Total Qty</th>
                            <th scope="col" width="20%">Available Qty</th>
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
                            <td>{{ $val->qty_in }}</td>
                            <td>
                                {{ is_numeric($val->available) == true ? $val->available : $val->qty_in }}
                            </td>
                            <td>{{ $val->unit }}</td>
                            <td>
                                <a href="javascript:void(0)" onclick="confirm('Are you sure want to delete?')">
                                    <button class="btn btn-sm btn-danger" type="button">delete</button>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        // GET MATERIAL
        var url = "{{ route('get.material') }}"
        $("#material_name").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                console.log(ui)
                $('#material_name').val(ui.item.label);
                $('#material_id').val(ui.item.id);
                return false;
            }
        });

        // GET LOCATION 
        var urlLocation = "{{ route('get.location') }}"
        $("#location_name").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: urlLocation,
                    type: 'GET',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $('#location_name').val(ui.item.label);
                $('#location_id').val(ui.item.id);
                console.log(ui.item);
                return false;
            }
        });
    })
</script>
@endpush