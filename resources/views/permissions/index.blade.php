@extends('base')

@section('title', 'Admin - Permissions Listing')

@section('main')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Permissions</h1>
</div>
<p class="mb-4">Note: User roles permission section, Only for advanced users for customizations in webapp.</p>
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
        <a href="{{ route('permissions.create')}}" class="btn btn-primary mb-3"><i class="fa fa-plus" aria-hidden="true"></i> Add New Permission</a>
    </div>
    <!-- DataTales Example -->
<div class="card shadow mb-4">
   <div class="card-body">
      <div class="table-responsive">
         <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            
        <thead>
            <tr>
                <td>Name</td>
                <td colspan = 2>Actions</td>
            </tr>
        </thead>
        <tbody>
            @foreach($permissions as $permission)
            <tr>
                <td>{{$permission->name}}</td>
                <td>
                    <a href="{{ route('permissions.edit',$permission->id)}}" class="btn btn-primary">Edit</a>
                </td>
                <td>
                    <form action="{{ route('permissions.destroy', $permission->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $permissions->links() }}
</div>
</div>
</div>
    @endsection