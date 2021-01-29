@extends('base')

@section('title', 'Admin - Edit Project')

@section('main')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Edit Project: {{ $project->id }}</h1>
  
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
            {{ session()->get('errors') }}
        </div>
        @endif
    </div>
    <form method="post" action="{{ route('projects.update', $project->id) }}" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="project_status">Project Status: </label></br>
                    <select class="form-control {{ $errors->has('project_status') ? 'is-invalid' : '' }}" id="project_status" name="project_status" value="{{ $project->project_status }}">
                        <option value="1" {{ $project->project_status == '1' ? 'selected' : '' }}>In-Progress</option>
                        <option value="0" {{ $project->project_status == '0' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="project_image">Project Image:</label>
                            <input type="file" class="form-control-file border {{ $errors->has('project_image') ? 'is-invalid' : '' }}" name="project_image" value="{{ $project->project_image }}" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group text-center">
                            @empty($project->project_image)
                                <img src="{{ '/demo_images/def.jpg' }}" width="100" height="100">
                            @else
                            <img src="{{ '/storage/project_images/'.$project->project_image }}" width="100" height="100">
                            @endempty
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <div class="row">    
            <div class="col">
                <div class="form-group">
                    <label for="project_category_id">Choose Category:</label>
                    <select class="form-control {{ $errors->has('project_category_id') ? 'is-invalid' : '' }}" id="project_category_id" name="project_category_id" value="{{ $project->project_category_id }}">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" {{ $project->project_category_id == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="project_name">Project Name:</label>
                    <input type="text" class="form-control {{ $errors->has('project_name') ? 'is-invalid' : '' }}" name="project_name" value="{{ $project->project_name }}" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="client_user_id">Choose Client:</label>
                    <select class="form-control {{ $errors->has('client_user_id') ? 'is-invalid' : '' }}" id="client_user_id" name="client_user_id" value="{{ $project->client_user_id }}">
                        <option value="">Select Client</option>
                        @foreach($users as $user)
                            <option value="{{$user->id}}" {{ $project->client_user_id == $user->id ? 'selected' : '' }}>{{$user->name}} | {{ $user->email }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="project_price">Price (&#8377;):</label>
                    <input type="number" class="form-control {{ $errors->has('project_price') ? 'is-invalid' : '' }}" name="project_price" value="{{ $project->project_price }}" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="project_start_date">Start Date:</label>
                    <input type="date" class="form-control {{ $errors->has('project_start_date') ? 'is-invalid' : '' }}" name="project_start_date" value="{{ $project->project_start_date }}" />
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="project_end_date">End Date:</label>
                    <input type="date" class="form-control {{ $errors->has('project_end_date') ? 'is-invalid' : '' }}" name="project_end_date" value="{{ $project->project_end_date }}" />
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="project_description">Project Description:</label>
            <textarea name="project_description" class="form-control {{ $errors->has('project_description') ? 'is-invalid' : '' }}" rows="5">{{ $project->project_description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary float-right">Update</button>
    </form>
</div>
</div>
@endsection