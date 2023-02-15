@extends('base')
@section('title', 'Admin - Alert Notifications Listing')
@section('main')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-address-card text-gray-300"></i> Alert Notifications</h1>
   <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Export Contacts</a> -->
</div>
<p class="mb-4">Alert Notifications section, You can manage alert notifications from this page.</p>
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
<?php if(in_array('admin', Auth::user()->roles->pluck('slug')->toArray())): ?>
<div>
   <a href="{{ route('alertnotifications.create')}}" class="btn btn-primary mb-3"><i class="fa fa-plus" aria-hidden="true"></i> Add New Alert Notifications</a>
</div>
<?php endif; ?>
<!-- DataTales Example -->
<div class="card shadow mb-4">
   <div class="card-body">
      <div class="table-responsive">
         <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Type</th>
                  <th>Title</th>
                  <th>Summary</th>
                  <th>Url</th>
                  <th>Assigned To</th>
                  <!-- <th colspan = 2>Actions</th> -->
               </tr>
            </thead>
            <tbody>
               @forelse($alertnotifications as $alertnotification)
               <tr>
                  <td>{{$alertnotification->id}}</td>
                  <td>
                     <?php $type = $alertnotification->getTypeById($alertnotification->type); ?>
                        <div class="icon-circle {{$type['background']}}">
                           <i class="{{$type['icon']}}"></i>
                        </div>
                        {{$alertnotification->getTypeById($alertnotification->type, 'type')}}
                  </td>
                  <td>{{$alertnotification->title}}</td>
                  <td>{{$alertnotification->summary}}</td>
                  <td>{{$alertnotification->url}}</td>
                  <td>{{$alertnotification->user_id}}</td>
                  <!-- <td>
                     <a href="{{ route('alertnotifications.edit',$alertnotification->id)}}" class="btn btn-primary">Edit</a>
                  </td> -->
                  <!-- <td>
                     <form action="{{ route('alertnotifications.destroy', $alertnotification->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                     </form>
                  </td> -->
               </tr>
               @empty
               <tr>
                  <td colspan="8" class="text-center">No Alert Notification found</td>
               </tr>
               @endforelse
            </tbody>
         </table>
         {{ $alertnotifications->links() }}
      </div>
   </div>
</div>
@endsection