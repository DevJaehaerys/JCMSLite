<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\IpUtils;

class FreeKassaController extends Controller
{
    public function redirect(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $validatedData = $request->validate([
            'Balance' => ['required', 'numeric', 'min:1'],
        ]);
        $user = Auth::user();

        $freekassa = config('payments');
        $merchant_id = $freekassa['fk_project_id'];
        $secret_word = $freekassa['fk_secret_word'];
        $order_id = $user->steamid;
        $order_amount = $validatedData['Balance'];
        $currency = $freekassa['fk_currency'];
        $sign = md5($merchant_id . ':' . $order_amount . ':' . $secret_word . ':' . $currency . ':' . $order_id);
        return Inertia::location('https://pay.freekassa.ru/?m=' . $merchant_id . '&oa=' . $order_amount . '&o=' . $order_id . '&s=' . $sign . '&currency=RUB');

    }

    public function paymentSuccess(Request $request)
    {
        $client_ip = $request->getClientIp();
        $allowed_ips = ['168.119.157.136', '168.119.60.227', '138.201.88.124', '178.154.197.79'];
        if (!IpUtils::checkIp($client_ip, $allowed_ips)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $freekassa = config('payments');
        $merchant_id = $freekassa['fk_project_id'];
        $merchant_secret = $freekassa['fk_secret_word'];
        $sign = md5($merchant_id . ':' . $_REQUEST['AMOUNT'] . ':' . $merchant_secret . ':' . $_REQUEST['MERCHANT_ORDER_ID']);


        if ($sign != $_REQUEST['SIGN']) die('wrong sign');

        $user = User::where('steamid', $request->MERCHANT_ORDER_ID)->first();
        if ($user) {
            $user->balance += $request->AMOUNT;
            $user->save();
        }
    }


}
