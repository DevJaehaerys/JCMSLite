<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class WebCartController extends Controller
{
    public function addToCart(Request $request){
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $itemId = $request->itemid;
        $item = Shop::find($itemId);
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $request->validate([
            'itemid' => 'required|numeric',
            'count' => 'required|numeric|min:1'
        ]);
        $itemPrice = $item->price;
        $totalSum = $itemPrice * $request->count;
        $cart = session()->get('cart', []);
        $cartItem = [
            'id' => $itemId,
            'name' => $item->name,
            'category' => $item->category,
            'command' => $item->command,
            'image' => $item->image,
            'quantity' => $request->count,
            'price' => $itemPrice,
            'total' => $totalSum
        ];
        $cart[$itemId] = $cartItem;
        session()->put('cart', $cart);
        return response()->json(['message' => 'Item added to cart successfully']);
    }
    public function getCart(Request $request){
        $cart = session()->get('cart', []);
        $cartItems = [];
        $totalPrice = 0;

        foreach ($cart as $item) {
            $cartItems[] = $item;
            $totalPrice += $item['total'];
        }

        return response()->json([
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice
        ]);
    }
    public function removeFromCart($id){
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return response()->json(['message' => 'Item removed from cart successfully']);
    }
}
