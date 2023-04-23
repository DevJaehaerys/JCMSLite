<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EnotController extends Controller
{
    public function redirect(Request $request){
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $validatedData = $request->validate([
            'Balance' => ['required', 'numeric', 'min:1'],
        ]);
        $enot = config('payments');

        $user = Auth::user();
        $MERCHANT_ID = $enot['enot_merchant_id'];

        $SECRET_WORD = $enot['enot_secret_word'];
        $ORDER_AMOUNT = $validatedData['Balance'];
        $PAYMENT_ID = time();

        $sign = md5($MERCHANT_ID . ':' . $ORDER_AMOUNT . ':' . $SECRET_WORD . ':' . $PAYMENT_ID);

        $url = 'https://enot.io/pay?' . http_build_query([
                'm' => $MERCHANT_ID,
                'oa' => $ORDER_AMOUNT,
                'cf' => $user->steamid,
                'o' => $PAYMENT_ID,
                's' => $sign,
            ]);
        return Inertia::location($url);

    }

    public function handler(Request $request){
        $merchant = $_REQUEST['merchant'];
        $enot = config('payments');
        $secret_word2 = $enot['enot_secret_word2'];

        $sign = md5($merchant.':'.$_REQUEST['amount'].':'.$secret_word2.':'.$_REQUEST['merchant_id']);

        if ($sign != $_REQUEST['sign_2']) {
            die('bad sign!');
        }

        $user = User::where('steamid', $request->custom_field)->first();
        if ($user) {
            $user->balance += $request->amount;
            $user->save();
        }

    }
}
