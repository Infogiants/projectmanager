@extends('base')

@section('title', 'Admin - Add New Contact')

@section('main')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-user text-gray-300"></i> Add New Contact</h1>

</div>
<div class="card shadow mb-4">
<div class="card-header">Add Contact Details</div>
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
    <form method="post" action="{{ route('contacts.store') }}">
        @csrf
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" />
            <!-- @error('first_name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror -->
        </div>
        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" />
        </div>
        <div class="form-group">
            <label for="about">About:</label>
            <textarea name="about" class="form-control {{ $errors->has('about') ? 'is-invalid' : '' }}">{{ old('about') }}</textarea>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}" />
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" />
        </div>
        <button type="submit" class="btn btn-primary float-right">Add Contact</button>
    </form>
</div>
</div>
@endsection