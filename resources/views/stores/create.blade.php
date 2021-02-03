@extends('base')

@section('title', 'Admin - Add Your Store')

@section('main')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-store text-gray-300"></i> Add Your Store</h1>   
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
    <form method="post" action="{{ route('stores.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="store_logo">Store Logo:</label>
            <input type="file" class="form-control-file border {{ $errors->has('store_logo') ? 'is-invalid' : '' }}" name="store_logo" value="{{ old('store_logo') }}" />
        </div>
        
        <div class="form-group">
            <label for="store_name">Store Name:</label>
            <input type="text" class="form-control {{ $errors->has('store_name') ? 'is-invalid' : '' }}" name="store_name" value="{{ old('store_name') }}" />
        </div>
        <div class="form-group">
            <label for="store_website">Store Website:</label>
            <input type="url" class="form-control {{ $errors->has('store_website') ? 'is-invalid' : '' }}" name="store_website" value="{{ old('store_website') }}" />
        </div>
        <div class="form-group">
            <label for="store_description">Store Description:</label>
            <textarea name="store_description" class="form-control {{ $errors->has('store_description') ? 'is-invalid' : '' }}">{{ old('store_description') }}</textarea>
        </div>
        <div class="form-group">
            <label for="store_contact_no">Store Contact No:</label>
            <input type="text" class="form-control {{ $errors->has('store_contact_no') ? 'is-invalid' : '' }}" name="store_contact_no" value="{{ old('store_contact_no') }}" />
        </div>
        <div class="form-group">
            <label for="store_address">Store Address:</label>
            <textarea name="store_address" class="form-control {{ $errors->has('store_address') ? 'is-invalid' : '' }}">{{ old('store_address') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary float-right">Add Store</button>
    </form>
</div>
</div>
@endsection