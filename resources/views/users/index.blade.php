@extends('base')
@section('title', 'Admin - Users Listing')
@section('main')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-users text-gray-300"></i> Users</h1>
   <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Export Users</a> -->
</div>
<p class="mb-4">You can manage admin or client users into system from this section.</p>
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
   <a href="{{ route('users.create')}}" class="btn btn-primary mb-3"><i class="fa fa-plus" aria-hidden="true"></i> Add New User</a>
</div>
<!-- DataTales Example -->
<div class="card shadow mb-4">
   <div class="card-body">
      <div class="table-responsive">
         <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
               <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Email Verified</th>
                  <th>Roles</th>
                  <th>Phone</th>
                  <th colspan = 2>Actions</th>
               </tr>
            </thead>
            @forelse($users as $user)
            <tr>
               <td>{{$user->name}}</td>
               <td>{{$user->email}}</td>
               <td>{{!empty($user->email_verified_at) ? 'Yes': 'No'}}</td>
               <td>{{ implode(", ", $user->roles->pluck('name')->toArray()) }}</td>
               <td>
                  <a href="{{ route('users.edit',$user->id)}}" class="btn btn-primary">Edit</a>
               </td>
               <td>
                  <form action="{{ route('users.destroy', $user->id)}}" method="post">
                     @csrf
                     @method('DELETE')
                     <button class="btn btn-danger" type="submit">Delete</button>
                  </form>
               </td>
            </tr>
            @empty
               <tr>
                  <td colspan="8" class="text-center">No users found</td>
               </tr>
            @endforelse
            </tbody>
         </table>
         {{ $users->links() }}
      </div>
   </div>
</div>
@endsection