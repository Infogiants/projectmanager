@extends('base')

@section('title', 'My Profile')

@section('main')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-user text-gray-300"></i> My Profile </h1>

</div>
<div class="card shadow mb-4">
<div class="card-header">My Profile</div>
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
    <div class="row">
        <div class="col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Account Details</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="mb-1" for="inputUsername"><strong>Name:</strong> {{ $user->name }}</label>
                    </div>
                    <div class="form-group">
                        <label class="mb-1" for="inputUsername"><strong>Email:</strong> {{ $user->email }}</label>
                    </div>
                    <div class="form-group">
                        <label class="mb-1" for="inputUsername"><strong>Email Verified Date:</strong> {{  \Carbon\Carbon::parse($user->email_verified_at)->format('F j, Y - h:i a') }}</label>
                    </div>
                    <div class="form-group">
                        <label class="mb-1" for="inputUsername"><strong>Created Date:</strong> {{  \Carbon\Carbon::parse($user->created_at)->format('F j, Y - h:i a') }}</label>
                    </div>
                    <div class="form-group">
                        <h6 class="font-weight-bold mb-4"><u>User Roles</u></h6>
                        @foreach($user->allroles as $k => $role)
                            <label for="role_ids">{{$role}}</label><br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Account Details</h6>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('saveprofile', $user->id) }}">
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
                        <button type="submit" class="btn btn-primary float-right">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection