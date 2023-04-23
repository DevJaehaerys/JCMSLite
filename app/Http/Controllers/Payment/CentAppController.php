<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\IpUtils;

class CentAppController extends Controller
{
    public function redirect(Request $request){
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $validatedData = $request->validate([
            'Balance' => ['required', 'numeric', 'min:1'],
        ]);
        $cent = config('payments');

        $user = Auth::user();
        $apiURL = 'https://cent.app/api/v1/bill/create';
        $result = $validatedData['Balance'];
        $postInput = [
            'amount' => $result,
            'shop_id' => $cent['centapp_shop_id'],
            'name' => 'Пополнение счёта ' . $user->steamid,
            'custom' => $user->steamid,
        ];
        $headers = [
            'Authorization' => $cent['centapp_token']
        ];

        $response = Http::withHeaders($headers)->post($apiURL, $postInput);
        $responseBody = json_decode($response->getBody()->getContents(), true);
        $object = (object) $responseBody;
        return Inertia::location($object->link_page_url);

    }
    public function handler(Request $request){

        $client_ip = $request->getClientIp();
        $allowed_ips = ['95.108.213.65', '95.216.41.201'];
        if (!IpUtils::checkIp($client_ip, $allowed_ips)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $object = (object) $request;
        $cent = config('payments');

        $sign = strtoupper(md5($object->OutSum . ":" . $object->InvId . ":" . $cent['centapp_token']));
        if ($sign != $object->SignatureValue) {
            die('bad sign!');
        }
        if($object->Status == 'SUCCESS') {
            $user = User::where('steamid', $object->custom)->first();
            if ($user) {
                $user->balance += $object->OutSum;
                $user->save();
            }
        } else {
            abort('403');
        }
    }
}
