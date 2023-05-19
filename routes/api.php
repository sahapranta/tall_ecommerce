<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/stripe-webhook', function () {
    $endpoint_secret = config('extra.stripe_webhook');
    $payload = @file_get_contents('php://input');
    $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
    $event = null;

    try {
        $event = \Stripe\Webhook::constructEvent(
            $payload,
            $sig_header,
            $endpoint_secret
        );
    } catch (\UnexpectedValueException $e) {
        Log::info('Stripe Invalid Payload', [$e]);
        return response('', 400);
    } catch (\Stripe\Exception\SignatureVerificationException $e) {
        Log::info('Stripe Invalid Signature', [$e]);
        return response('', 400);
    }

    // Handle the event
    switch ($event->type) {
        case 'charge.succeeded':
            Log::channel('payment')->info('Stripe Payment Success', [$event]);
            $object = $event->data->object;

            try {
                $transaction = Transaction::with('order')->firstWhere('code', $object->payment_intent);
                if ($transaction && $transaction->order->payment_status === 'unpaid') {
                    $transaction->order->update(['payment_status' => 'paid']);
                    $results_to_keep = collect($object)->only(['id', 'amount_captured', 'created', 'receipt_url'])->toArray();
                    $transaction->update(['result' => $results_to_keep]);
                    // Send email to customers
                }
            } catch (\Throwable $th) {
                Log::alert($th->getMessage(), [$th]);
            }


            // ... handle other event types
        default:
            echo 'Received unknown event type ' . $event->type;
    }

    return response('');
});
