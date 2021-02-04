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
            <h6 class="m-0 font-weight-bold text-primary">Task Documents ({{ $documentscount }})</h6>
         </div>
         <div class="card-body">
            <form method="post" action="{{ route('documents.store') }}" enctype="multipart/form-data">
               @csrf
               <div class="input-group mb-4">
                  <div class="custom-file">
                     <input type="file" class="custom-file-input  {{ $errors->has('file') ? 'is-invalid' : '' }}" name="file" value="{{ old('file') }}" id="inputGroupFile04">
                     <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                  </div>
                  <div class="input-group-append">
                     <button class="btn btn-primary" type="submit">Upload</button>
                  </div>
               </div>
               <input type="hidden" name="task_id" value="<?php echo $task->id; ?>" />
               <input type="hidden" name="project_id" value="<?php echo $task->project()->first()->toArray()['id']; ?>" />
            </form>
            <div class="table-responsive">
               <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Uploaded By</th>
                        <th colspan="2">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($documents as $document)
                     <tr>
                        <td>{{$document->id}}</td>
                        <td>{{$document->name}}</td>
                        <td>{{ $document->user()->first()->toArray()['name'] }}</td>
                        <?php if (Auth::user()->id === $document->user_id): ?>
                        <td>
                           <a href="{{ '/storage/documents/'.$document->url }}" class="btn btn-primary" target="_blank">Download</a>
                        </td>
                        <td>
                           <form action="{{ route('documents.destroy', $document->id)}}" method="post">
                              @csrf
                              @method('DELETE')
                              <button class="btn btn-danger" type="submit">Delete</button>
                           </form>
                        </td>
                        <?php else: ?>
                        <td colspan="2">
                           <a href="{{ '/storage/documents/'.$document->url }}" class="btn btn-primary" target="_blank">Download</a>
                        </td>
                        <?php endif;?>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
               {{ $documents->appends(request()->except('documentpage'))->links() }}
            </div>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <div class="col-lg-12">
      <div class="card shadow mb-4">
         <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Comments({{ $commentscount }})</h6>
         </div>
         <div class="card-body">
            @foreach($comments as $comment)
            <div class="card mb-4">
               <div class="card-body">
                  {{ $comment->description }}
               </div>
               <div class="card-footer">
                  <small>
                  Added By: <?php echo $comment->user()->first()->toArray()['name']; ?> |  {{  \Carbon\Carbon::parse($comment->created_at)->format('F j, Y - h:i:a ') }}
                  </small>
               </div>
            </div>
            @endforeach    
            {{ $comments->appends(request()->except('commentpage'))->links() }}     
            <form method="post" action="{{ route('comments.store') }}">
               @csrf
               <div class="form-group">
                  <label for="description">Comment:</label>
                  <textarea name="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" rows="5" autofocus>{{ old('description') }}</textarea>
               </div>
               <input type="hidden" name="task_id" value="<?php echo $task->id; ?>" />
               <input type="hidden" name="project_id" value="<?php echo $task->project()->first()->toArray()['id']; ?>" />
               <button type="submit" class="btn btn-primary float-right mb-4">Add</button>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection