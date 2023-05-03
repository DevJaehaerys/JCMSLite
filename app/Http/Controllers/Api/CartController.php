<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
class CartController extends Controller
{
    public function items()
    {
        $items = Cart::with('user')->get();
        return response()->json($items);
    }
    public function add($steamid)
    {
        $user = User::where('steamid', $steamid)->firstOrFail();
        $items = Cart::where('user_id', $user->id)->with('user')->get();
        return response()->json($items);
    }
    public function remove($itemId)
    {
        $item = Cart::findOrFail($itemId);
        $item->delete();
        return response()->json(['success' => true]);
    }

}
