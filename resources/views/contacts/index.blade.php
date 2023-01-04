@extends('base')
@section('title', 'Admin - Contacts Listing')
@section('main')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-address-card text-gray-300"></i> Contacts</h1>
   <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Export Contacts</a>
</div>
<p class="mb-4">Business contacts section, You can manage your important contact details from this page.</p>
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
<div>
   <a href="{{ route('contacts.create')}}" class="btn btn-primary mb-3"><i class="fa fa-plus" aria-hidden="true"></i> Add New contact</a>
</div>
<!-- DataTales Example -->
<div class="card shadow mb-4">
   <div class="card-body">
      <div class="table-responsive">
         <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>About</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Created By</th>
                  <th colspan = 2>Actions</th>
               </tr>
            </thead>
            <tbody>
               @foreach($contacts as $contact)
               <tr>
                  <td>{{$contact->id}}</td>
                  <td>{{$contact->first_name}} {{$contact->last_name}}</td>
                  <td>{{$contact->about}}</td>
                  <td>{{$contact->email}}</td>
                  <td>{{$contact->phone}}</td>
                  <td>{{$contact->user_id}}</td>
                  <td>
                     <a href="{{ route('contacts.edit',$contact->id)}}" class="btn btn-primary">Edit</a>
                  </td>
                  <td>
                     <form action="{{ route('contacts.destroy', $contact->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                     </form>
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
         {{ $contacts->links() }}
      </div>
   </div>
</div>
@endsection