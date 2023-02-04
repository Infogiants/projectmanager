@extends('base')

@section('title', 'Admin - Add New Environment')

@section('main')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Add New Environment</h1>

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
    <form method="post" action="{{ route('environments.store') }}">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name') }}" />
        </div>
        <div class="form-group">
            <label for="summary">Summary:</label>
            <textarea name="summary" class="form-control {{ $errors->has('summary') ? 'is-invalid' : '' }}" rows="5">{{ old('summary') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary float-right">Add Environment</button>
    </form>
</div>
</div>
@endsection