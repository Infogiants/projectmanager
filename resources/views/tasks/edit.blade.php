

@extends('base')
@section('title', 'Admin - Edit Task')
@section('main')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">{{ $task->project()->first()->toArray()['project_name'] }} - <small>Edit {{ $task->title }}</small></h1>
</div>
<div class="mb-4">
   <a href="{{ url()->previous() }}" style="text-decoration:none;">&#8592; Go Back</a>
</div>
<div class="card shadow mb-4">
   <div class="card-body">
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
      <form method="post" action="{{ route('tasks.update', $task->id) }}">
         @method('PATCH')
         @csrf
         <div class="row">
            <div class="col">
               <div class="form-group">
                  <label for="title">Title:</label>
                  <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" value="{{ $task->title }}" />
               </div>
            </div>
            <div class="col">
               <div class="form-group">
                  <label for="status">Status: </label></br>
                  <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" id="status" name="status" value="{{ $task->status }}">
                        <option value="0" {{ $task->status == '0' ? 'selected' : '' }}>To-Do</option>
                        <option value="1" {{ $task->status == '1' ? 'selected' : '' }}>In-Progress</option>
                        <option value="2" {{ $task->status == '2' ? 'selected' : '' }}>Completed</option>
                    </select>
               </div>
            </div>
            <div class="col">
               <div class="form-group">
                  <label for="estimated_hours">Estimated Hours:</label>
                  <input type="number" class="form-control {{ $errors->has('estimated_hours') ? 'is-invalid' : '' }}" name="estimated_hours" value="{{ $task->estimated_hours }}" min="0" />
               </div>
            </div>
         </div>
         <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" rows="5">{{ $task->description }}</textarea>
         </div>
         <button type="submit" class="btn btn-primary float-right">Update</button>
      </form>
   </div>
</div>
@endsection

