<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

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
        $lava = config('payments');

        $client = new Client([
            'base_uri' => 'https://api.lava.ru/business/',
            'timeout' => 5,
        ]);

        $secretKey = $lava['lava_secret'];
        $user = Auth::user();
        $data = [
            'shopId' => $lava['lava_shop_id'],
            'sum' => $balance['Balance'],
            'orderId' => $user->name . time(),
            'hookUrl' => 'https://lite.jaehaerys.dev/payment/lava/webhook',
            'successUrl' => 'https://lite.jaehaerys.dev/',
            'failUrl' => 'https://lite.jaehaerys.dev/',
            'expire' => 300,
            'customFields' => $user->steamid,
            'comment' => 'Пополнение баланса пользователя' . $user->name,
            'includeService' => ['card', 'sbp', 'qiwi'],
        ];

        $json = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $signature = hash_hmac('sha256', $json, $secretKey);

        $response = $client->request('POST', 'invoice/create', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Signature' => $signature,
            ],
            'body' => $json,
        ]);

        $body = $response->getBody()->getContents();
        dd($body);

    }
}
