@extends('base')
@section('title', 'Admin - View User')
@section('main')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">{{ $project->project_name }} <small>(<?php echo ($project->project_status == '1') ? 'In-Progress' : 'Completed'; ?>)</small></h1>
</div>
<div class="mb-4">
   <a href="{{ url()->previous() }}" style="text-decoration:none;">&#8592; Go Back</a>
</div>
<div class="row">
<div class="col-lg-6">
      <div class="card shadow mb-4">
         <!-- Card Header - Accordion -->
         <a href="#project_details" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Project Details</h6>
         </a>
         <!-- Card Content - Collapse -->
         <div class="collapse show" id="project_details" style="">
            <div class="card-body">
               <div class="row">
                  <div class="col-lg-6">
                     <div class="form-group">
                        <label class="mb-1" for="inputUsername"><strong>Name:</strong> {{ $project->project_name }}</label>
                     </div>
                     <div class="form-group">
                        <label class="mb-1" for="inputUsername"><strong>Status:</strong> <?php echo ($project->project_status == '1') ? '<i class="fas fa-toggle-on"></i> In-Progress' : '<i class="fas fa-toggle-off"></i> Completed'; ?></label>
                     </div>
                     <div class="form-group">
                        <label class="mb-1" for="inputUsername"><strong>Type:</strong> <?php echo ($project->project_type == '1') ? 'Fixed Price' : 'Hourly Price'; ?></label>
                     </div>
                     <div class="form-group">
                        <label class="mb-1" for="inputUsername"><strong>Price:</strong> {{ $project->project_price }} &#8377;</label>
                     </div>
                     <div class="form-group">
                        <label class="mb-0" for="inputUsername"><strong>Start Date:</strong> {{  \Carbon\Carbon::parse($project->project_start_date)->format('F j, Y') }}</label>
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="form-group">
                        <label class="mb-1" for="inputUsername"><strong>End Date:</strong> {{ $project->project_end_date }}</label>
                     </div>
                     <div class="form-group">
                        <label class="mb-1" for="inputUsername"><strong>Description:</strong> {{ $project->project_description }}</label>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-lg-6">
      <div class="row">
         <div class="col-lg-6">
            <div class="card mb-4 border-left-primary">
               <div class="card-body">
                  <div class="row no-gutters align-items-center">
                     <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">All Tasks</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">10</div>
                     </div>
                     <div class="col-auto">
                        <i class="fas fa-fw fa-list-ul fa text-gray-300"></i>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-6">
            <div class="card mb-4 border-left-primary">
               <div class="card-body">
                  <div class="row no-gutters align-items-center">
                     <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Documents</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">10</div>
                     </div>
                     <div class="col-auto">
                        <i class="fas fa-fw fa-list-ul fa text-gray-300"></i>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-6">
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
         <div class="col-lg-6">
            <div class="card mb-4 border-left-primary">
               <div class="card-body">
                  <div class="row no-gutters align-items-center">
                     <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Milestones</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">10</div>
                     </div>
                     <div class="col-auto">
                        <i class="fas fa-fw fa-list-ul fa text-gray-300"></i>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-6">
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
         <div class="col-lg-6">
            <div class="card mb-4 border-left-primary">
               <div class="card-body">
                  <div class="row no-gutters align-items-center">
                     <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Invoices</div>
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
   </div>
   
</div>
<div class="row">
   <div class="col-lg-12">
      <div class="card shadow mb-4">
         <!-- Card Header - Accordion -->
         <a href="#project_tasks" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Project Tasks</h6>
         </a>
         <!-- Card Content - Collapse -->
         <div class="collapse show" id="project_tasks" style="">
            <div class="card-body">
               <div>
                  <button class="btn btn-primary mb-3" type="button" data-toggle="collapse" data-target="#addtaskform" aria-expanded="false" aria-controls="addtaskform">
                  <i class="fa fa-plus" aria-hidden="true"></i> Add Task
                  </button>
                  <div class="collapse" id="addtaskform">
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
                     <form method="post" action="{{ route('tasks.store') }}">
                        @csrf
                        <div class="form-group">
                              <label for="title">Title:</label>
                              <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" value="{{ old('title') }}" />
                        </div>
                        <div class="form-group">
                              <label for="description">Description:</label>
                              <textarea name="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" rows="5">{{ old('description') }}</textarea>
                        </div>        
                        <button type="submit" class="btn btn-primary float-right mb-4">Save</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <div class="col-lg-12">
      <div class="card shadow mb-4">
         <!-- Card Header - Accordion -->
         <a href="#project_milestones" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Project MileStones</h6>
         </a>
         <!-- Card Content - Collapse -->
         <div class="collapse show" id="project_milestones" style="">
            <div class="card-body">
               <div>
                  <button class="btn btn-primary mb-3" type="button" data-toggle="collapse" data-target="#addmilestoneform" aria-expanded="false" aria-controls="addmilestoneform">
                  <i class="fa fa-plus" aria-hidden="true"></i> Create Milestone
                  </button>
                  <div class="collapse" id="addmilestoneform">
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
                        <form method="post" action="{{ route('milestones.store') }}">
                           @csrf
                           <div class="form-group">
                                 <label for="title">Title:</label>
                                 <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" value="{{ old('title') }}" />
                           </div>
                           <div class="form-group">
                                 <label for="description">Description:</label>
                                 <textarea name="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" rows="5">{{ old('description') }}</textarea>
                           </div>
                           <div class="row">
                              <div class="col">
                                 <div class="form-group">
                                    <label for="start_date">Start Date:</label>
                                    <input type="date" class="form-control {{ $errors->has('start_date') ? 'is-invalid' : '' }}" name="start_date" value="{{ old('start_date') }}" />
                                 </div>
                              </div>
                              <div class="col">
                                 <div class="form-group">
                                    <label for="end_date">End Date:</label>
                                    <input type="date" class="form-control {{ $errors->has('end_date') ? 'is-invalid' : '' }}" name="end_date" value="{{ old('end_date') }}" />
                                 </div>
                              </div>
                           </div>        
                           <button type="submit" class="btn btn-primary float-right mb-4">Save</button>
                        </form>  
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <div class="col-lg-12">
      <div class="card shadow mb-4">
         <!-- Card Header - Accordion -->
         <a href="#project_documents" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Project Documents (To-do)</h6>
         </a>
         <!-- Card Content - Collapse -->
         <div class="collapse show" id="project_documents" style="">
            <div class="card-body">
               <div>
                  <button class="btn btn-primary mb-3" type="button" data-toggle="collapse" data-target="#uploaddocument" aria-expanded="false" aria-controls="uploaddocument">
                  <i class="fa fa-upload" aria-hidden="true"></i> Upload Document
                  </button>
                  <div class="collapse mb-4" id="uploaddocument">
                     Upload Document Form
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection