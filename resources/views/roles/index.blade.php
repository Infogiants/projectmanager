@extends('base')
@section('title', 'Admin - Roles Listing')
@section('main')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Roles</h1>
</div>
<p class="mb-4">Note: User roles section, Only for advanced users for customizations in webapp.</p>
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
   <!-- <a href="{{ route('roles.create')}}" class="btn btn-primary mb-3"><i class="fa fa-plus" aria-hidden="true"></i> Add New Role</a> -->
</div>
<!-- DataTales Example -->
<div class="card shadow mb-4">
   <div class="card-body">
      <div class="table-responsive">
         <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
               <tr>
                  <td>Name</td>
                  <td>Details</td>
               </tr>
            </thead>
            <tbody>
               @foreach($roles as $role)
               <tr>
                  <td>{{$role->name}}</td>
                  <td><?php echo ($role->name == 'User') ? 'This role is defined for client users' : 'This role is defined for administrator users' ?></td>
                  <!-- <td>
                     <a href="{{ route('roles.edit',$role->id)}}" class="btn btn-primary">Edit</a>
                  </td>
                  <td>
                     <form action="{{ route('roles.destroy', $role->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                     </form>
                  </td> -->
               </tr>
               @endforeach
            </tbody>
         </table>
         {{ $roles->links() }}
      </div>
   </div>
</div>
@endsection