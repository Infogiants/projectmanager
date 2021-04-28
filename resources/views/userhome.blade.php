<!-- @extends('layouts.admin')

@section('title', 'Admin - Dashboard')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>
<div class="row">
   <div class="col-lg-6">
      <div class="card mb-4 py-3 border-left-primary">
         <div class="card-body">
            <div class="row no-gutters align-items-center">
               <div class="col mr-2">
                  <div class="font-weight-bold text-primary text-uppercase mb-1">Projects</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $projects }}</div>
               </div>
               <div class="col-auto">
                  <i class="fas fa-cubes fa-2x text-gray-300"></i>
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
@endsection -->
