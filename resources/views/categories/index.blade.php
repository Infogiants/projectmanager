@extends('base')

@section('title', 'Admin - Category Listing')

@section('main')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Categories</h1>
</div>
<div>
   @if(session()->get('success'))
   <div class="alert alert-success">
      {{ session()->get('success') }}
   </div>
   @endif
   @if(session()->get('errors'))
   <div class="alert alert-danger">
      {{ session()->get('errors') }}
   </div>
   @endif
</div>

    <div>
        <a href="{{ route('categories.create')}}" class="btn btn-primary mb-3"><i class="fa fa-plus" aria-hidden="true"></i> Add New Category</a>
    </div>
    <!-- DataTales Example -->
<div class="card shadow mb-4">
   <div class="card-body">
      <div class="table-responsive">
         <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            
        <thead>
            <tr>
                <td>ID</td>
                <td>Image</td>
                <td>Name</td>
                <?php if (in_array('admin', Auth::user()->roles->pluck('slug')->toArray())): ?>
                    <td>Created By</td>
                <?php endif; ?>
                <td colspan = 2>Actions</td>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{$category->id}}</td>
                <td>
                    @empty($category->image)
                        <img src="{{ '/demo_images/def.jpg' }}" width="48" height="48">
                    @else
                        <img src="{{ '/storage/category_images/'.$category->image }}" width="48" height="48">
                    @endempty
                </td>
                <td>{{$category->name}}</td>
                <?php if (in_array('admin', Auth::user()->roles->pluck('slug')->toArray())): ?>
                    <td>{{$category->user_id}}</td>
                <?php endif; ?>
                <td>
                    <a href="{{ route('categories.edit',$category->id)}}" class="btn btn-primary">Edit</a>
                </td>
                <td>
                    <form action="{{ route('categories.destroy', $category->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $categories->links() }}
</div>
</div>
</div>
    @endsection