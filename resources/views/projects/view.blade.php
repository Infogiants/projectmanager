@extends('base')
@section('title', 'Admin - View User')
@section('main')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">{{ $project->project_name }} |  <?php echo ($project->project_status == '1') ? '<i class="fas fa-toggle-on"></i> In-Progress' : '<i class="fas fa-toggle-off"></i> Completed'; ?></h1>
</div>
<div class="mb-4">
   <a href="{{ url()->previous() }}" style="text-decoration:none;">&#8592; Go Back</a>
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
            </div>
         </div>
      </div>
   </div>
</div>
@endsection