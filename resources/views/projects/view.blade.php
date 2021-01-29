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
   <div class="col-lg-2">
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
   <div class="col-lg-2">
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
   <div class="col-lg-2">
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
</div>
<div class="row">
   <div class="col-lg-12">
      <div class="card shadow mb-4">
         <!-- Card Header - Accordion -->
         <a href="#project_details" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Project Details</h6>
         </a>
         <!-- Card Content - Collapse -->
         <div class="collapse show" id="project_details" style="">
            <div class="card-body">
               <div class="form-group">
                  <label class="mb-1" for="inputUsername"><strong>Name:</strong> {{ $project->project_name }}</label>
               </div>
               <div class="form-group">
                  <label class="mb-1" for="inputUsername"><strong>Status:</strong> <?php echo ($project->project_status == '1') ? '<i class="fas fa-toggle-on"></i> In-Progress' : '<i class="fas fa-toggle-off"></i> Completed'; ?></label>
               </div>
               <div class="form-group">
                  <label class="mb-1" for="inputUsername"><strong>Price:</strong> {{ $project->project_price }} &#8377;</label>
               </div>
               <div class="form-group">
                  <label class="mb-1" for="inputUsername"><strong>Start Date:</strong> {{  \Carbon\Carbon::parse($project->project_start_date)->format('F j, Y') }}</label>
               </div>
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
            <div>.
               <a href="{{ route('tasks.create')}}" class="btn btn-primary mb-3"><i class="fa fa-plus" aria-hidden="true"></i> Add Task</a>
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
               <a href="{{ route('milestones.create')}}" class="btn btn-primary mb-3"><i class="fa fa-plus" aria-hidden="true"></i> Create Milestone</a>
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
            <h6 class="m-0 font-weight-bold text-primary">Project Documents</h6>
         </a>
         <!-- Card Content - Collapse -->
         <div class="collapse show" id="project_documents" style="">
            <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                           <svg class="svg-inline--fa fa-cc-visa fa-w-18 fa-2x cc-color-visa" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="cc-visa" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M470.1 231.3s7.6 37.2 9.3 45H446c3.3-8.9 16-43.5 16-43.5-.2.3 3.3-9.1 5.3-14.9l2.8 13.4zM576 80v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h480c26.5 0 48 21.5 48 48zM152.5 331.2L215.7 176h-42.5l-39.3 106-4.3-21.5-14-71.4c-2.3-9.9-9.4-12.7-18.2-13.1H32.7l-.7 3.1c15.8 4 29.9 9.8 42.2 17.1l35.8 135h42.5zm94.4.2L272.1 176h-40.2l-25.1 155.4h40.1zm139.9-50.8c.2-17.7-10.6-31.2-33.7-42.3-14.1-7.1-22.7-11.9-22.7-19.2.2-6.6 7.3-13.4 23.1-13.4 13.1-.3 22.7 2.8 29.9 5.9l3.6 1.7 5.5-33.6c-7.9-3.1-20.5-6.6-36-6.6-39.7 0-67.6 21.2-67.8 51.4-.3 22.3 20 34.7 35.2 42.2 15.5 7.6 20.8 12.6 20.8 19.3-.2 10.4-12.6 15.2-24.1 15.2-16 0-24.6-2.5-37.7-8.3l-5.3-2.5-5.6 34.9c9.4 4.3 26.8 8.1 44.8 8.3 42.2.1 69.7-20.8 70-53zM528 331.4L495.6 176h-31.1c-9.6 0-16.9 2.8-21 12.9l-59.7 142.5H426s6.9-19.2 8.4-23.3H486c1.2 5.5 4.8 23.3 4.8 23.3H528z"></path>
                           </svg>
                           <i class="fab fa-cc-visa fa-2x cc-color-visa"></i>
                           <div class="ml-4">
                              <div class="small">Uploaded File 1</div>
                              <div class="text-xs text-muted">Uploaded By User1, Attached to Project1-Task2</div>
                           </div>
                        </div>
                        <div class="ml-4 small">
                           <div class="badge badge-light mr-3">PDF</div>
                           <a href="#!">Delete</a>
                        </div>
                     </div>
                     <hr>
                     <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                           <svg class="svg-inline--fa fa-cc-visa fa-w-18 fa-2x cc-color-visa" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="cc-visa" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M470.1 231.3s7.6 37.2 9.3 45H446c3.3-8.9 16-43.5 16-43.5-.2.3 3.3-9.1 5.3-14.9l2.8 13.4zM576 80v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h480c26.5 0 48 21.5 48 48zM152.5 331.2L215.7 176h-42.5l-39.3 106-4.3-21.5-14-71.4c-2.3-9.9-9.4-12.7-18.2-13.1H32.7l-.7 3.1c15.8 4 29.9 9.8 42.2 17.1l35.8 135h42.5zm94.4.2L272.1 176h-40.2l-25.1 155.4h40.1zm139.9-50.8c.2-17.7-10.6-31.2-33.7-42.3-14.1-7.1-22.7-11.9-22.7-19.2.2-6.6 7.3-13.4 23.1-13.4 13.1-.3 22.7 2.8 29.9 5.9l3.6 1.7 5.5-33.6c-7.9-3.1-20.5-6.6-36-6.6-39.7 0-67.6 21.2-67.8 51.4-.3 22.3 20 34.7 35.2 42.2 15.5 7.6 20.8 12.6 20.8 19.3-.2 10.4-12.6 15.2-24.1 15.2-16 0-24.6-2.5-37.7-8.3l-5.3-2.5-5.6 34.9c9.4 4.3 26.8 8.1 44.8 8.3 42.2.1 69.7-20.8 70-53zM528 331.4L495.6 176h-31.1c-9.6 0-16.9 2.8-21 12.9l-59.7 142.5H426s6.9-19.2 8.4-23.3H486c1.2 5.5 4.8 23.3 4.8 23.3H528z"></path>
                           </svg>
                           <i class="fab fa-cc-visa fa-2x cc-color-visa"></i>
                           <div class="ml-4">
                              <div class="small">Uploaded File 1</div>
                              <div class="text-xs text-muted">Uploaded By User2, Attached to Project1-Task2</div>
                           </div>
                        </div>
                        <div class="ml-4 small">
                           <div class="badge badge-light mr-3">Docx</div>
                           <a href="#!">Delete</a>
                        </div>
                     </div>
                     <hr>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection