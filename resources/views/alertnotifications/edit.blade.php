@extends('base')

@section('title', 'Admin - Edit Alert Notification Details')

@section('main')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-address-card text-gray-300"></i> Edit Alert Notification Details</h1>

</div>
<div class="card shadow mb-4">
<div class="card-header">Edit Alert Notification Details</div>
<div class="card-body">
    <div>
        @if(session()->get('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
        @endif

        @if(session()->get('errors'))
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br/>
            @endforeach
        </div>
        @endif
    </div>
    <form method="post" action="{{ route('alertnotifications.update', $alertnotification->id) }}">
        @method('PATCH')
        @csrf
        <div class="form-group">
                    <label for="type">Select Type</label>
                    <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" id="type" name="type" value="{{ $alertnotification->type }}">
                        <option value="">Select Type</option>
                        @foreach($types as $type)
                            <option value="{{$type->id}}" {{ $alertnotification->type == $type->id ? 'selected' : '' }}>{{$type->name}}</option>
                        @endforeach
                    </select>
        </div>
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" value="{{ $alertnotification->title }}" />
        </div>
        <div class="form-group">
            <label for="summary">Summary:</label>
            <textarea name="summary" class="form-control {{ $errors->has('summary') ? 'is-invalid' : '' }}">{{ $alertnotification->summary }}</textarea>
        </div>
        <div class="form-group">
            <label for="url">Url:</label>
            <input type="text" class="form-control {{ $errors->has('url') ? 'is-invalid' : '' }}" name="url" value="{{ $alertnotification->url }}" />
        </div>
        <button type="submit" class="btn btn-primary float-right">Update</button>
    </form>
</div>
</div>
@endsection