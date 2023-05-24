<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    public function getAllItems()
    {
        $items = Shop::with('user')->get();
        return response()->json($items);
    }

    public function addItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'image' => 'required',
            'about' => 'required',
            'price' => 'required|numeric',
            'command' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $record = new Shop();
        $record->name = $request->input('name');
        $record->image = $request->input('image');
        $record->about = $request->input('about');
        $record->price = $request->input('price');
        $record->command = $request->input('command');
        $record->save();

        return response()->json(['success' => true]);
    }

    public function removeItem($id)
    {
        $item = Shop::findOrFail($id);
        $item->delete();
        return response()->json(['success' => true]);
    }

}
