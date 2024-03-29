@extends('base')

@section('title', 'Admin - Edit Configuration')

@section('main')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Edit Configuration: {{ $configuration->id }}</h1>

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
    <form method="post" action="{{ route('configurations.update', $configuration->id) }}">
        @method('PATCH')
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ $configuration->name }}" />
        </div>
        <div class="form-group">
            <label for="name">Path</label>
            <input type="text" class="form-control {{ $errors->has('path') ? 'is-invalid' : '' }}" name="path" value="{{ $configuration->path }}" disabled />
            <small>Note: This will be used in code for dynamic configurations.</small>
        </div>
        <div class="form-group">
            <input type="text" class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}" name="value" value="{{ $configuration->value }}" />
        </div>
        <button type="submit" class="btn btn-primary float-right">Update</button>
    </form>
</div>
</div>
@endsection