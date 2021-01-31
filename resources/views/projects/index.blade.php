@extends('base')
@section('title', 'Admin - Projects Listing')
@section('main')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Projects</h1>
</div>
<p class="mb-4">Your projects section, you can manage your project from this page.</p>
<div class="row">
   <div class="col-lg-2">
         <div class="card mb-4 border-left-primary">
            <div class="card-body">
               <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                     <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">All</div>
                     <div class="h5 mb-0 font-weight-bold text-gray-800">10</div>
                  </div>
                  <div class="col-auto">
                     <i class="fas fa-fw fa-list-ul fa text-gray-300"></i>
                  </div>
               </div>
            </div>
         </div>
   </div>
   <div class="col-lg-2">
         <div class="card mb-4 border-left-warning">
            <div class="card-body">
               <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                     <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">In-Progress</div>
                     <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                  </div>
                  <div class="col-auto">
                     <i class="fas fa-fw fa-list-ul fa text-gray-300"></i>
                  </div>
               </div>
            </div>
         </div>
   </div>
   <div class="col-lg-2">
         <div class="card mb-4 border-left-success">
            <div class="card-body">
               <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                     <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Completed</div>
                     <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                  </div>
                  <div class="col-auto">
                     <i class="fas fa-fw fa-list-ul fa text-gray-300"></i>
                  </div>
               </div>
            </div>
         </div>
   </div>
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
<?php if(in_array('admin', Auth::user()->roles->pluck('slug')->toArray())): ?>
<div>
   <a href="{{ route('projects.create')}}" class="btn btn-primary mb-3"><i class="fa fa-plus" aria-hidden="true"></i> Add New Project</a>
</div> 
<?php endif; ?>
<!-- DataTales Example -->
<div class="card shadow mb-4">
   <div class="card-body">
      <div class="table-responsive">
         <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Price</th>
                  <th>Status</th>
                  <?php if(in_array('admin', Auth::user()->roles->pluck('slug')->toArray())): ?>
                     <th>Client</th>
                     <th colspan="3">Actions</th>
                  <?php else: ?>
                     <th>Actions</th>
                  <?php endif; ?>
               </tr>
            </thead>
            <tbody>
               @foreach($projects as $project)
               <tr>
                  <td>{{$project->id}}</td>
                  <td>{{$project->project_name}}</td>
                  <td><?php echo ($project->project_status == '1') ? 'Fixed Price' :  'Hourly Price'; ?></td>
                  <td>{{$project->project_price}} &#8377;</td>
                  <td>
                  <?php if($project->project_status == 1): ?>
                                 <label class="btn btn-info active">In-Progress</label>
                              <?php endif; ?>

                              <?php if($project->project_status == 0): ?>
                                 <label class="btn btn-success">Completed</label>
                              <?php endif; ?>
                 </td>
                  <?php if(in_array('admin', Auth::user()->roles->pluck('slug')->toArray())): ?>
                     <td><a href="{{ route('users.show',$project->client_user_id)}}">{{ $project->client()->first()->toArray()['name'] }}</a></td>
                     <td>
                        <a href="{{ route('projects.show',$project->id)}}" class="btn btn-primary">Manage</a>
                     </td>
                     <td>
                        <a href="{{ route('projects.edit',$project->id)}}" class="btn btn-primary">Edit Details</a>
                     </td>
                     <td>
                        <form action="{{ route('projects.destroy', $project->id)}}" method="post">
                           @csrf
                           @method('DELETE')
                           <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                     </td>
                  <?php else: ?>
                     <td>
                        <a href="{{ route('projects.show',$project->id)}}" class="btn btn-primary">Manage</a>
                     </td>
                  <?php endif; ?>
               </tr>
               @endforeach
            </tbody>
         </table>
         {{ $projects->links() }}
      </div>
   </div>
</div>
@endsection