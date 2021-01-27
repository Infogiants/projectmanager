@extends('base')
@section('title', 'Admin - View User')
@section('main')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">{{ $user->name }} - {{ $user->email }}</h1>
</div>
<div class="mb-4">
<a href="{{ url()->previous() }}" style="text-decoration:none;">&#8592; Go Back</a>
</div>
<div class="row">
   <div class="col-lg-4">
      <div class="card shadow mb-4">
         <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Profile Picture</h6>
         </div>
         <div class="card-body text-center">
            <!-- Profile picture image-->
            <img class="img-account-profile rounded-circle mb-2" src="{{ '/demo_images/profile-1.png' }}" width="100" height="100">
            <!-- Profile picture help block-->
            <div class="font-italic text-muted mb-4">{{ $user->name }} - {{ $user->email }}</div>
         </div>
      </div>
   </div>
   <div class="col-lg-8">
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
            <label class="mb-1" for="inputUsername"><strong>Created at:</strong> {{ $user->created_at }}</label>
        </div>
         </div>
      </div>
   </div>
</div>
@endsection