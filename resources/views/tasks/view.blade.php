

@extends('base')
@section('title', 'Admin - Mangage Task')
@section('main')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">{{ $task->project()->first()->toArray()['project_name'] }} - <small>Mange {{ $task->title }}</small></h1>
</div>
<div class="mb-4">
   <a href="{{ url()->previous() }}" style="text-decoration:none;">&#8592; Go Back</a>
</div>
<div class="row">
   <div class="col-lg-12">
      <div class="card shadow mb-4">
         <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Task ID: {{ $task->id }}</h6>
         </div>
         <div class="card-body">
            <div class="form-group">
               <label class="mb-1" for="inputUsername"><strong>Title:</strong> {{ $task->title }}</label>
            </div>
            <div class="form-group">
                  <strong>Status: </strong>
                  <?php if($task->status == 0): ?>
                  <label class="btn btn-sm btn-secondary active">To-Do</label>
                  <?php endif; ?>
                  <?php if($task->status == 1): ?>
                  <label class="btn btn-sm btn-info active">In-Progress</label>
                  <?php endif; ?>
                  <?php if($task->status == 2): ?>
                  <label class="btn btn-sm btn-success">Completed</label>
                  <?php endif; ?>
            </div>
            <div class="form-group">
               <label class="mb-1" for="inputUsername"><strong>Description:</strong> {{ $task->description }}</label>
            </div>
            <div class="form-group">
               <label class="mb-1" for="inputUsername">
                  <strong>Created By:</strong> 
                  <td>{{ $task->user()->first()->toArray()['name'] }} - {{ $task->user()->first()->toArray()['email'] }}</td>
               </label>
            </div>
            <div class="form-group">
               <label class="mb-1" for="inputUsername"><strong>Created Date:</strong> {{  \Carbon\Carbon::parse($task->created_at)->format('F j, Y - h:i a') }}</label>
            </div>
            <div class="form-group">
               <label class="mb-1" for="inputUsername"><strong>Last Updated:</strong> {{  \Carbon\Carbon::parse($task->updated_at)->format('F j, Y - h:i a') }}</label>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <div class="col-lg-12">
      <div class="card shadow mb-4">
         <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Comments</h6>
         </div>
         <div class="card-body">
            <form method="post" action="{{ route('tasks.store') }}">
               @csrf
               <div class="form-group">
                  <label for="description">Comment:</label>
                  <textarea name="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" rows="5">{{ old('description') }}</textarea>
               </div>
               <input type="hidden" name="task_id" value="<?php echo $task->id; ?>" />
               <button type="submit" class="btn btn-primary float-right mb-4">Add</button>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection

