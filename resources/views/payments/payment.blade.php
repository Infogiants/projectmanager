@extends('base')

@section('title', 'Admin - Add New User')

@section('main')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cubes text-gray-300"></i> Payment</h1>
</div>
<div class="card shadow mb-4">
<div class="card-header">Make Payment</div>
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
   <form role="form" action="{{ route('payment') }}" method="post" class="validation"
      data-cc-on-file="false"
      data-stripe-publishable-key="{{ config('stripe.api_keys.stripe_key')}}"
      id="payment-form">
      @csrf
      <div class='form-row row'>
         <div class='col-md-6'>
            <div class="row">
               <div class="col">
                  <div class='form-group required'>
                     <label class='control-label'>Name on Card</label>
                     <input  class='form-control' size='4' type='text'>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col">
                  <div class='form-group cc required'>
                     <label class='control-label'>Card Number</label>
                     <input autocomplete='off' class='form-control card-num' size='20' type='text'>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col">
                  <div class='form-group cvc required'>
                     <label class='control-label'>CVC</label>
                     <input autocomplete='off' class='form-control card-cvc' placeholder='e.g 415' size='4' type='text'>
                  </div>
               </div>
               <div class="col">
                  <div class='form-group expiration required'>
                     <label class='control-label'>Expiration Month</label>
                     <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
                  </div>
               </div>
               <div class="col">
                  <div class='form-group expiration required'>
                     <label class='control-label'>Expiration Year</label>
                     <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
                  </div>
               </div>
            </div>
            <div class='hide errorDiv form-group'>
               <p class="alert alert-danger">Fix the errors before you begin.</p>
            </div>
            <div>
               <button class="btn btn-secondary  btn" type="reset"><i class="fa-undo fa-xs fa text-gray-300"></i> Reset</button>
               <button class="btn btn-primary btn" type="submit">Pay Now (100)</button>
            </div>
         </div>
         <div class='col-md-6'>
            <div class="card shadow mt-4">
               <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Payment Guide and Test Data</h6>
               </div>
               <div class="card-body">
                  <p>
                     We are ussing Stripe payment gateway for the payments. Below are the test card details
                     that can be used for testing.
                  </p>
                  <p>Visa Card No: 4242424242424242</p>
                  <p>CVC: Any 3 digits (four digits for American Express cards).</p>
                  <p>Expiration Date: Any future date</p>
                  <p>More Details: <a href="https://stripe.com/docs/testing?testing-method=card-numbers" target="_blank">Testing Stripe Documentation</a></p>
               </div>
            </div>
         </div>
   </form>
   </div>
</div>
<style type="text/css">
   .hide {
   display: none;
   }
</style>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
   $(function() {
       var $form = $(".validation");
       $('form.validation').bind('submit', function(e) {
           var $form = $(".validation"),
           inputVal = ['input[type=text]'].join(', '),
           $inputs       = $form.find('.required').find(inputVal),
           $errorStatus  = $form.find('div.errorDiv'),
           valid         = true;
           $errorStatus.addClass('hide');

           $('.has-error').removeClass('has-error');
            $inputs.each(function(i, el) {
                var $input = $(el);
                if ($input.val() === '') {
                $input.parent().addClass('has-error');
                $errorStatus.removeClass('hide');
                e.preventDefault();
            }
       });

       if (!$form.data('cc-on-file')) {
         e.preventDefault();
         Stripe.setPublishableKey($form.data('stripe-publishable-key'));
         Stripe.createToken({
           number: $('.card-num').val(),
           cvc: $('.card-cvc').val(),
           exp_month: $('.card-expiry-month').val(),
           exp_year: $('.card-expiry-year').val()
         }, stripeHandleResponse);
       }

     });

    function stripeHandleResponse(status, response) {
            console.log(response);
           if (response.error) {
               $('.errorDiv').removeClass('hide').find('.alert').text(response.error.message);
           } else {
               var token = response['id'];
               $form.find('input[type=text]').empty();
               $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
               $form.get(0).submit();
           }
    }

   });
</script>
@endsection