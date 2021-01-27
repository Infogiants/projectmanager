@extends('base')

@section('title', 'Admin - Add New Configuration')

@section('main')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Add New Configuration</h1>
   
</div>
<div class="card shadow mb-4">
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
    <form method="post" action="{{ route('configurations.store') }}">
        @csrf
        <div class="form-group">
            <label for="path">Path:</label>
            <input type="text" class="form-control {{ $errors->has('path') ? 'is-invalid' : '' }}" name="path" value="{{ old('path') }}" />
        </div>
        <div class="form-group">
            <label for="value">Value:</label>
            <input type="text" class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}" name="value" value="{{ old('value') }}" />
        </div>
        <button type="submit" class="btn btn-primary float-right">Add Configuration</button>
    </form>
</div>
</div>
@endsection