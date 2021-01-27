@extends('base')
@section('title', 'Admin - Projects Listing')
@section('main')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Projects</h1>
</div>
<div class="row">
   <div class="col-lg-2">
         <div class="card mb-4 py-3 border-left-primary">
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
         <div class="card mb-4 py-3 border-left-primary">
            <div class="card-body">
               <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                     <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">In-Progress</div>
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
         <div class="card mb-4 py-3 border-left-primary">
            <div class="card-body">
               <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                     <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Completed</div>
                     <div class="h5 mb-0 font-weight-bold text-gray-800">10</div>
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
<div>
   <a href="{{ route('projects.create')}}" class="btn btn-primary mb-3"><i class="fa fa-plus" aria-hidden="true"></i> Add New Project</a>
</div>
<!-- DataTales Example -->
<div class="card shadow mb-4">
   <div class="card-body">
      <div class="table-responsive">
         <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Selling Price</th>
                  <th>Status</th>
                  <th>Client</th>
                  <th colspan="4">Actions</th>
               </tr>
            </thead>
            <tbody>
               @foreach($projects as $project)
               <tr>
                  <td>{{$project->id}}</td>
                  <td>
                     @empty($project->project_image)
                        <img src="{{ '/demo_images/def.jpg' }}" width="48" height="48">
                     @else
                        <img src="{{ '/storage/project_images/'.$project->project_image }}" width="48" height="48">
                     @endempty
                  </td>
                  <td>{{$project->project_name}}</td>
                  <td>{{$project->project_price}} &#8377;</td>
                  <td><?php echo ($project->project_status == '1') ? '<i class="fas fa-toggle-on"></i> In-Progress' : '<i class="fas fa-toggle-off"></i> Completed'; ?></td>
                  <td><a href="{{ route('users.show',$project->client_user_id)}}">{{ $project->client_user_id }}<a/></td>
                  <td>
                     <a href="{{ route('projects.edit',$project->id)}}" class="btn btn-primary">Edit</a>
                  </td>
                  <td>
                     <a href="{{ route('projects.edit',$project->id)}}" class="btn btn-primary">Milestones</a>
                  </td>
                  <td>
                     <a href="{{ route('projects.edit',$project->id)}}" class="btn btn-primary">Tasks</a>
                  </td>
                  <td>
                     <form action="{{ route('projects.destroy', $project->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                     </form>
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
         {{ $projects->links() }}
      </div>
   </div>
</div>
@endsection