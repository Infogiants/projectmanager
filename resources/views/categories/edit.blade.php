@extends('base')

@section('title', 'Admin - Edit Category')

@section('main')


<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Edit Category: {{ $category->name }}</h1>
  
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
    <form method="post" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ $category->name }}" />
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="image">Image:</label>
                    <input type="file" class="form-control-file border {{ $errors->has('image') ? 'is-invalid' : '' }}" name="image" value="{{ $category->image }}" />
                </div>
            </div>
            <div class="col">
                <div class="form-group text-center">
                    @empty($category->image)
                        <img src="{{ '/demo_images/def.jpg' }}" width="100" height="100">
                    @else
                        <img src="{{ '/storage/category_images/'.$category->image }}" width="100" height="100">
                    @endempty
                </div>                           
            </div> 
        </div>
        <button type="submit" class="btn btn-primary float-right">Update</button>
    </form>
</div>
</div>
@endsection