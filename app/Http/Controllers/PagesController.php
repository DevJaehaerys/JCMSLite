<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PagesController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $items = Shop::all();
        return Inertia::render('Home', [
            'auth' => $user,
            'shop' => $items,

        ]);
    }
    public function blank()
    {
        $user = auth()->user();
        return Inertia::render('Blank', [
            'auth' => $user,
        ]);
    }
}
