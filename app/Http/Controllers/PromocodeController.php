<?php

namespace App\Http\Controllers;

use App\Models\PromocodeUsage;
use App\Models\Promocode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromocodeController extends Controller
{
    public function promo_check(Request $request)
    {
        $user = Auth::user();
        $code = $request->promocode;
        $userId = $user->id;

        $promocode = Promocode::where('code', $code)->first();
        if ($promocode) {
            $usagesCount = $promocode->usages()->where('user_id', $userId)->count();
            $totalUsages = PromocodeUsage::all()->where('promocode_id', $promocode->id)->count();
            if ($usagesCount < $promocode->per_use && $totalUsages <= $promocode->usages_count) {
                $usage = new PromocodeUsage([
                    'user_id' => $userId
                ]);
                $promocode->usages()->save($usage);
                $user->balance += $promocode->sum;
                $user->save();
                $promocode->usages_count -= 1;
                $promocode->save();
                if ($totalUsages >= $promocode->usages_count +1) {
                    $promocode->delete();
                }

                return response()->json(['message' => 'Promocode successfully used.'], 200);
            } else {
                return response()->json(['error' => 'Promocode already used by the user or maximum usage reached.'], 403);
            }
        }

        return response()->json(['message' => 'Promocode not found.'], 404);
    }


}
