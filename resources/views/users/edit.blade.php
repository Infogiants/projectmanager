@extends('base')

@section('title', 'Admin - Edit User')

@section('main')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Edit User: {{ $user->id }}</h1>
  
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
    <form method="post" action="{{ route('users.update', $user->id) }}">
        @method('PATCH')
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" value="{{ $user->name }}" />
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" name="email" value="{{ $user->email }}" />
        </div>
        <div class="form-group">
            <label for="current_password">Current Password:</label>
            <input type="password" class="form-control" name="current_password" value="" />
        </div>
        <div class="form-group">
            <label for="password">New Password:</label>
            <input type="password" class="form-control" name="password" value="" />
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm New Password:</label>
            <input type="password" class="form-control" name="password_confirmation" value="" />
        </div>
        <div class="form-group">
            <label for="name">Roles:</label><br><br>
            @foreach($user->allroles as $k => $role)
            <input type="checkbox" name="role_ids[]" value="{{$k}}" <?php echo (in_array($k, $user->roles->pluck('id')->toArray()) ? 'checked': '')?>>
            <label for="role_ids">{{$role}}</label><br>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary float-right">Update</button>
    </form>
</div>
</div>
@endsection