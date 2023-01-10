<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use Session;

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

    //Make payment & refund poc
    public function payment(Request $request)
    {
        // Set API secret
        Stripe\Stripe::setApiKey(config('stripe.api_keys.stripe_secret'));

        //Create a charge 
        $response = Stripe\Charge::create ([
                "amount" => 50 * 100,
                "currency" => "inr",
                "source" => $request->stripeToken,
                "description" => "Making test payment of 50 ruppes." 
        ]);

        echo "<pre>";
        print_r($response);
        die;

       //  //create full refund by charge id
       //  $response = Stripe\Refund::create ([
       //     'charge' => 'ch_1MOhjCBXq1Ys4N5RiOIx7rM6'
       //  ]);

       //  echo "<pre>";
       //  print_r($response);
       //  die;
           
       //$respomse obj if paid set to 1
        Session::flash('success', 'Payment has been successfully processed.');
          
        return back();
    }
}
