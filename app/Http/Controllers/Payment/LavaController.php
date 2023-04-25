<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class LavaController extends Controller
{
    public function redirect(Request $request){

        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $validatedData = $request->validate([
            'Balance' => ['required', 'numeric', 'min:1'],
        ]);
        $balance = $validatedData['Balance'];
        $user = Auth::user();
        $lava = config('payments');
        $jwt = $lava['lava_jwt'];
        $url = "https://api.lava.ru/invoice/create";
        $data = [
            'wallet_to' => $lava['lava_wallet_id'],
            'sum'      => $balance,
            'order_id' => $user->name . time(),
            'hookUrl' => $lava['lava_hook'],
            'successUrl' => $lava['lava_success'],
            'failUrl' => $lava['lava_fail'],
            'expire' => 300,
            'subtract' => $lava['lava_commission'],
            'merchant_id' => '123456789',
            'merchant_name' => 'JCMS Lite'
        ];
        $response = Http::withHeaders([
            "Authorization" => $jwt,
        ])->post($url, $data);
        $response = $response->json();
        return Inertia::location($response->url);
    }
    public function webhook(Request $request){
        $data = $request->all();
        $invoiceId = $data['invoice_id'];
        $amount = $data['amount'];
        $lava = config('payments');
        $payTime = $data['pay_time'];
        $secretKey = $lava['lava_secret_2'];
        $signature = md5("$invoiceId:$amount:$payTime:$secretKey");
        if ($signature === $data['sign']) {
            $user = User::where('steamid', $data['custom_fields'])->first();
            if ($user) {
                $user->balance += $data['amount'];
                $user->save();
            }
            return response()->json(['message' => 'Success'], 200);
        } else {
            return response()->json(['message' => 'Bad sign'], 400);
        }
    }
}
