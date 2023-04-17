<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\IpUtils;

class QiwiController extends Controller
{
    public function qiwiRedirect(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $number = $request->Balance;
        if (!is_numeric($number)) {
            return response()->json(['message' => 'Invalid Balance value'], 400);
        }
        $qiwiPayment = config('payments');
        $proc = $qiwiPayment['qiwi_commission'];
        $proc = $number / 100 * $proc;
        $result = $number + $proc;
        $user = Auth::user();
        $url = 'https://oplata.qiwi.com/create?publicKey=' . $qiwiPayment['qiwi_public_key'] .'&amount=' . $result . '&successUrl=' .$qiwiPayment['qiwi_success_url'].'&customFields[steamid]='.$user->steamid.'&customFields[realsum]='.$request->Balance.'';
        return Inertia::location($url);

    }
    protected function checkIpAccess(Request $request)
    {
        $user_ip = $request->ip();
        $allowed_ips = [
            '79.142.16.0/20',
            '195.189.100.0/22',
            '91.232.230.0/24',
            '91.213.51.0/24',
        ];
        foreach ($allowed_ips as $allowed_ip) {
            if (IpUtils::checkIp($user_ip, $allowed_ip)) {
                return true;
            }
        }
        return false;
    }
    protected function checkSignature(Request $request, array $bill)
    {
        $qiwiPayment = config('payments');
        $secret_key = $qiwiPayment['qiwi_secret_key'];
        $invoice_parameters = implode('|', [
            $bill['amount']['currency'],
            $bill['amount']['value'],
            $bill['billId'],
            $bill['siteId'],
            $bill['status']['value'],
        ]);
        $sha256_hash = hash_hmac('sha256', $invoice_parameters, $secret_key);

        return hash_equals($request->header('X-Api-Signature-SHA256'), $sha256_hash);
    }

    protected function handlePayment(array $bill)
    {
        $steamId = $bill['customFields']['steamid'];
        $realsum = $bill['customFields']['realsum'];
        $user = User::where('steamid', $steamId)->first();
        if ($user) {
            $user->balance += $realsum;
            $user->save();
        }
    }

    public function qiwiHandler(Request $request)
    {
        $allowed_ips = [
            '79.142.16.0/20',
            '195.189.100.0/22',
            '91.232.230.0/24',
            '91.213.51.0/24',
        ];
        $user_ip = $request->ip();
        if (!IpUtils::checkIp($user_ip, $allowed_ips)) {
            abort(403, 'Access denied');
        }

        $entity_body = $request->getContent();
        $array_body = json_decode($entity_body, true);
        $bill = $array_body['bill'];
        if (!$this->checkSignature($request, $bill)) {
            abort(404);
        }

        if ($bill['status']['value'] == 'PAID') {
            $this->handlePayment($bill);
        } else {
            abort(404);
        }
    }

}
