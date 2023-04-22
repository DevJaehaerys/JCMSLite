<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\User;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function checkout()
    {
        return view('ch');
    }

    public function redirect(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $validatedData = $request->validate([
            'Balance' => ['required', 'numeric', 'min:1'],
        ]);
        $user = Auth::user();

        \Stripe\Stripe::setApiKey(config('stripe.sk'));

        $session = \Stripe\Checkout\Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Пополнение баланса пользователя ' . $user->steamid,
                        ],
                        'unit_amount_decimal' => $validatedData['Balance'] * 100,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'client_reference_id' => $user->steamid,
            'success_url' => route('stripe.success'),
            'cancel_url' => route('index'),
        ]);
        return Inertia::location($session->url);

    }

    public function webhook(Request $request)
    {
        $stripe = config('stripe');
        \Stripe\Stripe::setApiKey($stripe['sk']);
        $endpoint_secret = $stripe['wh'];
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            http_response_code(400);
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            http_response_code(402);
            exit();
        }
        $user = User::where('steamid', $event->data->object->client_reference_id)->first();
        if ($user) {
            $user->balance += $event->data->object->amount_total / 100;
            $user->save();
            http_response_code(200);
        }
    }

    public function success()
    {
        return Inertia::location('/');
    }
}
