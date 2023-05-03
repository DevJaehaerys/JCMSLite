<?php

namespace App\Http\Controllers\Payment;
use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    public function handlePayment(Request $request)
    {
        $validatedData = $request->validate([
            'Balance' => ['required', 'numeric', 'min:1'],
        ]);

        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $userAuth = Auth::user();

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('success.payment'),
                "cancel_url" => route('index'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $validatedData['Balance'],
                        ],
                    "custom_id" => $userAuth->steamid
                ]
            ]
        ]);
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return Inertia::location($links['href']);
                }
            }
        }
        abort(500);
    }

    public function paymentSuccess(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $customId = $response['purchase_units'][0]['payments']['captures'][0]['custom_id'];
            $amount = $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['gross_amount']['value'];
            $user = User::where('steamid', $customId)->first();
            if ($user) {
                $user->balance += $amount;
                $user->save();
                return Inertia::location('/');
            }
        } else {
            abort(500);
        }
    }
}
