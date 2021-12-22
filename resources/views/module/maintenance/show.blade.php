@section('content')

    <div class="form-group row">
        <label class="col-sm-4">Ticket Number</label>
        <div class="col-sm-6">:  {{ $data->maintenance->number }}</div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4">Category</label>
        <div class="col-sm-6">:  {{ $data->maintenance->category->name }}</div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4">Description</label>
        <div class="col-sm-6">:  {{ $data->maintenance->description }}</div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4">Maintenance By</label>
        <div class="col-sm-6">:  {{ $data->maintenance->user->name }}</div>
    </div>

@endsection