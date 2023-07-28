<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'image' => 'required',
            'about' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'command' => 'required'
        ]);

        Shop::create($data);

        return to_route('dashboard_main');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $item = Shop::findOrFail($id)->makeVisible(['command'])->toArray();

        return response()->json($item);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shop $shop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shop $shop): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'name' => 'required',
            'image' => 'required',
            'about' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'command' => 'required'
        ]);

        $shop = Shop::find($request->id);

        if (!$shop) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $shop->name = $data['name'];
        $shop->image = $data['image'];
        $shop->about = $data['about'];
        $shop->category = $data['category'];
        $shop->price = $data['price'];
        $shop->command = $data['command'];
        $shop->save();

        return response()->json(['message' => 'Shop updated successfully', 'shop' => $shop]);

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $item = Shop::findOrFail($id);
            $item->delete();
            return response()->json(['message' => 'Item deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Item not found'], 404);
        }
    }

}
