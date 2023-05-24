<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
class CartController extends Controller
{
    public function getAllItems()
    {
        $items = Cart::with('user')->get();
        return response()->json($items);
    }

    public function getUserCart($id)
    {
        $user = User::findOrFail($id);
        $items = Cart::where('user_id', $user->id)->with('user')->get();
        return response()->json($items);
    }

    public function removeItem($id)
    {
        $item = Cart::findOrFail($id);
        $item->delete();
        return response()->json(['success' => true]);
    }

}
