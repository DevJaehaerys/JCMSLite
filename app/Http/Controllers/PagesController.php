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
}