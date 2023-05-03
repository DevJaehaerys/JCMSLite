<?php
namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ShopController extends Controller
{
    public function getItem(Request $request): \Illuminate\Http\JsonResponse
    {
        $itemid = filter_var($request->input('itemid'), FILTER_VALIDATE_INT);
        if ($itemid === false || $itemid === null) {
            return response()->json(['message' => 'Invalid item id'], 400);
        }
        $item = Shop::find($itemid);
        if(!$item) {
            return response()->json([
                'message' => 'Item not found'
            ], 404);
        }
        return response()->json([
            'id' => $item->id,
            'name' => $item->name,
            'category' => $item->category,
            'price' => $item->price,
            'about' => $item->about,
            'image' => $item->image,
        ]);
    }

    function buyItem(Request $request) {

        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $itemId = $request->itemid;
        $user = Auth::user();
        $item = Shop::find($itemId);
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $request->validate([
            'itemid' => 'required|numeric',
            'count' => 'required|numeric|min:1'
        ]);
        $itemPrice = $item->price;
        if ($user->balance < $itemPrice * $request->count) {
            return response()->json(['message' => 'Not enough balance'], 403);
        }
        $user->balance -= $itemPrice * $request->count;;
        $user->save();
        $cartItem = new Cart();
        $cartItem->name = $item->name;
        $cartItem->category = $item->category;
        $cartItem->command = $item->command;
        $cartItem->image = $item->image;
        $cartItem->user()->associate($user);
        $cartItem->save();

        return response()->json(['message' => 'Item bought successfully']);
    }


}
