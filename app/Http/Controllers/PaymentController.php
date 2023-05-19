<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function successd(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $sessionId = $request->get('session_id');

        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            if (!$session) {
                abort(404);
            }
            $customer = \Stripe\Customer::retrieve($session->customer);

            $order = Order::where('stripe_session', $session->id)->first();
            if (!$order) {
                abort(404);
            }
            if ($order->status === 'unpaid') {
                $order->status = 'paid';
                $order->save();
            }

            return view('shop.checkout-success', compact('customer'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function success()
    {
        return view('shop.checkout-success');
    }

    public function canceled(Request $request)
    {
        dd($request->all());
        return view('shop.checkout-cancel');
    }
}
