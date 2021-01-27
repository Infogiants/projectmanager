@extends('base')

@section('title', 'Admin - Add New Category')

@section('main')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Add New Category</h1>
   
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
    <form method="post" action="{{ route('categories.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name') }}" />
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="form-control-file border {{ $errors->has('image') ? 'is-invalid' : '' }}" name="image" value="{{ old('image') }}" />
        </div>        
        <button type="submit" class="btn btn-primary float-right">Add Category</button>
    </form>
</div>
</div>
@endsection