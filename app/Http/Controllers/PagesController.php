<?php

namespace App\Http\Controllers;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PagesController extends Controller
{
    public function shop()
    {

        $user = auth()->user();
        $items = Shop::all();
        return Inertia::render('Shop', [
            'auth' => $user,
            'Items' => $items,
        ]);
    }

    public function index()
    {

        $user = auth()->user();
        return Inertia::render('Home', [
            'auth' => $user,
        ]);
    }
    public function blank()
    {
        $user = auth()->user();
        return Inertia::render('Blank', [
            'auth' => $user,
        ]);
    }
    public function banlist()
    {

        $bans = DB::table('enhancedbansystem')
            ->select('steamid', 'name', 'expire', 'reason', 'source')
            ->get();

        $mergedData = [];

        foreach ($bans as $ban) {
            $leader = DB::table('playerranksdb')
                ->select('avatar')
                ->where('UserID', $ban->steamid)
                ->first();

            $admin = DB::table('playerranksdb')
                ->select('name', 'avatar')
                ->where('UserID', $ban->source)
                ->first();

            $mergedData[] = [
                'steamid' => $ban->steamid,
                'name' => $ban->name,
                'expire' => $ban->expire,
                'reason' => $ban->reason,
                'source' => $ban->source,
                'avatar' => $leader ? $leader->avatar : null,
                'admin_name' => $admin ? $admin->name : 'Server Console',
                'admin_avatar' => $admin ? $admin->avatar : 'https://lite.jaehaerys.dev/img/items/wolfmeat.cooked.png',
            ];
        }

        $user = auth()->user();
        return Inertia::render('Banlist', [
            'auth' => $user,
            'banlist' => $mergedData
        ]);
    }
    public function leaders(Request $request)
    {
        $user = auth()->user();
        return Inertia::render('Leaderboard', [
            'auth' => $user,
        ]);
    }

    public function servers()
    {
        $user = auth()->user();
        return Inertia::render('Servers', [
            'auth' => $user,
        ]);
    }
}
