@extends('base')
@section('title', 'Admin - Stores Listing')
@section('main')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-store text-gray-300"></i> Your Store</h1>
</div>
<p class="mb-4">Add/Edit your busniess details, It will be visible to your clients to know about your online business.</p>
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
<?php if(count($stores) == 0) { ?>
   <a href="{{ route('stores.create')}}" class="btn btn-primary mb-3"><i class="fa fa-plus" aria-hidden="true"></i> Add Your Store</a>
<?php } ?>
</div>
<!-- DataTales Example -->
<div class="card shadow mb-4">
   <div class="card-body">
      <div class="table-responsive">
         <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Store Logo</th>
                  <th>Store Name</th>
                  <th>Store Website</th>
                  <th>Store Status</th>
                  <th>Store Contact</th>
                  <th colspan="2">Actions</th>
               </tr>
            </thead>
            <tbody>
               @forelse($stores as $store)
               <tr>
                  <td>{{$store->id}}</td>
                  <td>
                     @empty($store->store_logo)
                        <img src="{{ '/demo_images/shop_black.png' }}" width="32" height="32">
                     @else
                        <img src="{{ '/storage/'.$store->store_logo }}" width="32" height="32">
                     @endempty
                  </td>
                  <td>{{$store->store_name}}</td>
                  <td><a href="{{ $store->store_website }}" target="_blank" title="{{ $store->store_website }}">{{ $store->store_website }}</a></td>
                  <td><?php echo ($store->store_status == '1') ? '<i class="fas fa-toggle-on store_enabled"></i> Enabled' : '<i class="fas fa-toggle-off store_disabled"></i> Disabled'; ?></td>
                  <td>{{$store->store_contact_no}}</td>
                  <td>
                     <form action="{{ route('stores.destroy', $store->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                     </form>
                  </td>
                  <td>
                     <a href="{{ route('stores.edit',$store->id)}}" class="btn btn-primary">Edit</a>
                  </td>
               </tr>
               @empty
               <tr>
                  <td colspan="8" class="text-center">No store found</td>
               </tr>
               @endforelse
            </tbody>
         </table>
         {{ $stores->links() }}
      </div>
   </div>
</div>

<div class="row">
   <div class="col-lg-6">
      <div class="card mb-4 py-3 border-left-primary">
         <div class="card-body">
            <div class="row no-gutters align-items-center">
               <div class="col mr-2">
                  <div class="font-weight-bold text-primary text-uppercase mb-2">Preview Your Store ➡️</div>
                  <div class="mb-0 text-gray-800">
                     <p class="mb-4">This is how your store information will be presented to your client/customers dashboard.</p>
                     <p class="mb-4">You can always edit the store details from Edit button and in case you, For specific day if store is offiline then you can set store stauts to offline along with message to client/customers.</p>
                  </div>
               </div>
               <div class="col-auto">
                  <i class="fas fa-store fa-2x text-gray-300"></i>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-lg-6">
      <div class="card mb-4 py-3 border-left-primary">
         <div class="card-body">
            <div class="row no-gutters align-items-center">
               @empty($store)
               <div class="col mr-2">
                  Your Store Details
               </div>
               @else
               <div class="col mr-2">
                  <div class="h5 mb-2 font-weight-bold text-gray-800">
                     @empty($store->store_logo)
                        <img src="{{ '/demo_images/shop_black.png' }}" width="32" height="32">
                     @else
                        <img src="{{ '/storage/'.$store->store_logo }}" width="32" height="32">
                     @endempty
                     &nbsp;&nbsp;{{ $store->store_name }}
                  </div>
                  <div class="mb-2 text-gray-800">
                     <strong>Our Website: </strong> <a href="{{ $store->store_website }}" target="_blank">{{ $store->store_website }}</a>
                  </div>
                  <div class="mb-2 text-gray-800">
                     <strong>About Us: </strong> {{ $store->store_description }}
                  </div>
                  <div class="mb-2 text-gray-800">
                     <strong>Contact No: </strong> {{ $store->store_contact_no }}
                  </div>
                  <div class="mb-2 text-gray-800">
                     <strong>Our Address:</strong> {{ $store->store_address }}
                  </div>
                  <div class="mb-2 text-gray-800">
                     <strong>Status:</strong> <?php echo $store->store_status == 1 ? 'We are working and operational today.' : $store->store_closed_message; ?>
                  </div>
               </div>
               @endempty
               <div class="col-auto">
                  <i class="fas fa-store fa-2x text-gray-300"></i>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection