@extends('base')

@section('title', 'Admin - Add New Project')

@section('main')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cubes text-gray-300"></i> Add New Project</h1>

</div>
<div class="card shadow mb-4">
<div class="card-header">Add Project Details</div>
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
    <form method="post" action="{{ route('projects.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="project_name">Project Name</label>
                    <input type="text" class="form-control {{ $errors->has('project_name') ? 'is-invalid' : '' }}" name="project_name" value="{{ old('project_name') }}" />
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="project_type">Select Type</label></br>
                    <select class="form-control {{ $errors->has('project_type') ? 'is-invalid' : '' }}" id="project_type" name="project_type">
                        <option value="1">Fixed Price</option>
                        <option value="0">Hourly Price</option>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="project_category_id">Select Category</label>
                    <select class="form-control {{ $errors->has('project_category_id') ? 'is-invalid' : '' }}" id="project_category_id" name="project_category_id" value="{{ old('project_category_id') }}">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="client_user_id">Select Client</label>
                    <select class="form-control {{ $errors->has('client_user_id') ? 'is-invalid' : '' }}" id="client_user_id" name="client_user_id" value="{{ old('client_user_id') }}">
                        <option value="">Select Client</option>
                        @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}} | {{$user->email}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="project_type">Select Currency</label></br>
                    <select class="form-control {{ $errors->has('project_currency') ? 'is-invalid' : '' }}" id="project_currency" name="project_currency" value="{{ old('project_currency') }}">
                        <option value="">Select Currency</option>
                        @foreach($countries as $country)
                            <option value="{{$country['Code']}}">{{$country['CountryName']}} - {{$country['Code']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="project_price">Price</label>
                    <input type="number" min="0" class="form-control {{ $errors->has('project_price') ? 'is-invalid' : '' }}" name="project_price" value="{{ old('project_price') }}" title="Add price based on type Fixed/Hourly" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="project_status">Select Status</label></br>
                    <select class="form-control {{ $errors->has('project_status') ? 'is-invalid' : '' }}" id="project_status" name="project_status">
                    <option value="">Select Status</option>
                    <option value="0">To-do</option>
                        <option value="1">In-Progress</option>
                        <option value="2">Completed</option>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="project_start_date">Start Date</label>
                    <input type="date" class="form-control {{ $errors->has('project_start_date') ? 'is-invalid' : '' }}" name="project_start_date" value="{{ old('project_start_date') }}" />
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="project_end_date">End Date</label>
                    <input type="date" class="form-control {{ $errors->has('project_end_date') ? 'is-invalid' : '' }}" name="project_end_date" value="{{ old('project_end_date') }}" />
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="project_description">Project Details</label>
            <textarea name="project_description" class="form-control {{ $errors->has('project_description') ? 'is-invalid' : '' }}" rows="5">{{ old('project_description') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary float-right">Add Project</button>
    </form>
</div>
</div>
@endsection