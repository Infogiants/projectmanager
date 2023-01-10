@extends('base')

@section('title', 'Admin - Payment')

@section('main')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-address-card text-gray-300"></i> Payment (Fix css included in this page issues for sidebar and refactor ui of form)</h1>
</div>
<div class="mb-4">
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
    <div class="row text-center">
        <h3 class="panel-heading">Payment Details</h3>
    </div>
    <form role="form" action="{{ route('payment') }}" method="post" class="validation"
                                    data-cc-on-file="false"
                                    data-stripe-publishable-key="{{ config('stripe.api_keys.stripe_key')}}"
                                    id="payment-form">
                                    @csrf
                                    <div class='form-row row'>
                                    <div class='col-xs-12 form-group required'>
                                        <label class='control-label'>Name on Card</label> <input
                                            class='form-control' size='4' type='text'>
                                    </div>
                                    </div>
                                    <div class='form-row row'>
                                    <div class='col-xs-12 form-group card required'>
                                        <label class='control-label'>Card Number</label> <input
                                            autocomplete='off' class='form-control card-num' size='20'
                                            type='text'>
                                    </div>
                                    </div>
                                    <div class='form-row row'>
                                    <div class='col-xs-12 col-md-4 form-group cvc required'>
                                        <label class='control-label'>CVC</label>
                                        <input autocomplete='off' class='form-control card-cvc' placeholder='e.g 415' size='4'
                                            type='text'>
                                    </div>
                                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                                        <label class='control-label'>Expiration Month</label> <input
                                            class='form-control card-expiry-month' placeholder='MM' size='2'
                                            type='text'>
                                    </div>
                                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                                        <label class='control-label'>Expiration Year</label> <input
                                            class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                            type='text'>
                                    </div>
                                    </div>
                                    <div class='form-row row'>
                                    <div class='col-md-12 hide error form-group'>
                                        <div class='alert-danger alert'>Fix the errors before you begin.</div>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-xs-12">
                                        <button class="btn btn-danger btn-lg btn-block" type="submit">Pay Now (₹100)</button>
                                    </div>
                                    </div>
                                </form>
</div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
      <style type="text/css">
         .container {
         margin-top: 40px;
         }
         .panel-heading {
         display: inline;
         font-weight: bold;
         }
         .flex-table {
         display: table;
         }
         .display-tr {
         display: table-row;
         }
         .display-td {
         display: table-cell;
         vertical-align: middle;
         width: 55%;
         }
      </style>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
   <script type="text/javascript">
      $(function() {
          var $form         = $(".validation");
        $('form.validation').bind('submit', function(e) {
          var $form         = $(".validation"),
              inputVal = ['input[type=email]', 'input[type=password]',
                               'input[type=text]', 'input[type=file]',
                               'textarea'].join(', '),
              $inputs       = $form.find('.required').find(inputVal),
              $errorStatus = $form.find('div.error'),
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
                  $('.error')
                      .removeClass('hide')
                      .find('.alert')
                      .text(response.error.message);
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
