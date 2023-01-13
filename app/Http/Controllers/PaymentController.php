<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use Session;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('role:admin');
    }


    //render cc form
    public function index()
    {
        return view('payments.payment');
    }

    //Make Payment or Capture Charge
    public function payment(Request $request)
    {
        // Set API secret
        Stripe\Stripe::setApiKey(config('stripe.api_keys.stripe_secret'));

        //Create a charge
        $response = Stripe\Charge::create ([
                "amount" => 100 * 100,
                "currency" => "inr",
                "source" => $request->stripeToken,
                "description" => "Making test payment of 100 ruppes at time - ".Carbon::now()->toFormattedDateString()
        ]);

        //$respomse obj if paid set to 1
        Session::flash('success', 'Payment has been successfully processed.');

        return back();
    }

    //Refund a charge
    public function refund($chargeId)
    {
        // Set API secret
        Stripe\Stripe::setApiKey(config('stripe.api_keys.stripe_secret'));

       //  //create full refund by charge id
        $response = Stripe\Refund::create ([
           'charge' => $chargeId
        ]);

        Session::flash('success', 'Refund has been successfully processed for chargeId - '.$chargeId);

        return back();
    }
}
