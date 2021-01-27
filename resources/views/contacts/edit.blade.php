@extends('base')

@section('title', 'Admin - Edit Contact')

@section('main')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Edit Contact: {{ $contact->id }}</h1>
  
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
    <form method="post" action="{{ route('contacts.update', $contact->id) }}">
        @method('PATCH')
        @csrf
        
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" name="first_name" value="{{ $contact->first_name }}" />
        </div>
        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" name="last_name" value="{{ $contact->last_name }}" />
        </div>
        <div class="form-group">
            <label for="about">About:</label>
            <textarea name="about" class="form-control {{ $errors->has('about') ? 'is-invalid' : '' }}">{{ $contact->about }}</textarea>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ $contact->email }}" />
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" name="phone" value="{{ $contact->phone }}" />
        </div>
        <button type="submit" class="btn btn-primary float-right">Update</button>
    </form>
</div>
</div>
@endsection