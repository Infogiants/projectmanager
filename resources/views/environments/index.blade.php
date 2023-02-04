@extends('base')

@section('title', 'Admin - Enviornments Listing')

@section('main')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Enviornments</h1>
</div>
<p class="mb-4">Your projects environments section, you can manage your project environments from this page.</p>
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
        <a href="{{ route('environments.create')}}" class="btn btn-primary mb-3"><i class="fa fa-plus" aria-hidden="true"></i> Add New Environments</a>
    </div>
    <!-- DataTales Example -->
<div class="card shadow mb-4">
   <div class="card-body">
      <div class="table-responsive">
         <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

        <thead>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <?php if (in_array('admin', Auth::user()->roles->pluck('slug')->toArray())): ?>
                    <td>Created By</td>
                <?php endif; ?>
                <td colspan = 2>Actions</td>
            </tr>
        </thead>
        <tbody>
            @forelse($environments as $environment)
            <tr>
                <td>{{$environment->id}}</td>
                <td>{{$environment->name}}</td>
                <?php if (in_array('admin', Auth::user()->roles->pluck('slug')->toArray())): ?>
                    <td>{{$environment->user_id}}</td>
                <?php endif; ?>
                <td>
                    <a href="{{ route('environments.edit',$environment->id)}}" class="btn btn-primary">Edit</a>
                </td>
                <td>
                    <form action="{{ route('environments.destroy', $environment->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
               <tr>
                  <td colspan="8" class="text-center">No environments found</td>
               </tr>
            @endforelse
        </tbody>
    </table>
    {{ $environments->links() }}
</div>
</div>
</div>
    @endsection