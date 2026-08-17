<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;

use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    //
    // public function checkout(Request $request){
    //     $borrow_request = Borrow::find($request->borrow_id);
        

    //     $borrow_request->payment_status = 'paid';
    //     $borrow_request->transaction_id = uniqid();
    //     $borrow_request->fine = '0';
    //     $borrow_request->save();
    //     return redirect('/book_history');
    // }

    public function checkout(Request $request)
    {
        $borrow = Borrow::findOrFail($request->borrow_id);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],

            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',

                    'product_data' => [
                        'name' => 'Library Fine',
                    ],

                    // Stripe expects the smallest currency unit
                    'unit_amount' => $borrow->fine * 100,
                ],

                'quantity' => 1,
            ]],

            'mode' => 'payment',

            'success_url' => route('payment.success') . '?borrow=' . $borrow->id,

            'cancel_url' => route('payment.cancel'),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $borrow_request = Borrow::findOrFail($request->borrow);

        $borrow_request->payment_status = 'paid';
        $borrow_request->transaction_id = uniqid();
        $borrow_request->fine = '0';


        $borrow_request->save();

        return redirect('/book_history')
            ->with('message', 'Payment completed successfully.');
    }

    public function cancel()
    {
        return redirect('/book_history')->with('message', 'Payment was cancelled.');
    }

    public function webhook(Request $request)
    {
        $payload = $request->getContent();

        $signature = $request->header('Stripe-Signature');

        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $signature,
                $endpointSecret
            );
        } catch (\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        if ($event->type === 'checkout.session.completed') {

            $session = $event->data->object;

            // Your borrow ID
            $borrowId = $session->metadata->borrow_id ?? null;

            if (!$borrowId) {
                return response('Borrow ID missing', 400);
            }

            $borrow = Borrow::find($borrowId);

            if (!$borrow) {
                return response('Borrow not found', 404);
            }

            // Prevent processing the same payment twice
            if ($borrow->payment_status === 'paid') {
                return response('Already processed', 200);
            }

            $borrow->payment_status = 'paid';
            $borrow->transaction_id = $session->payment_intent;
            $borrow->save();
        }

        return response('Webhook received', 200);
    }
}
