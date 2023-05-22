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
        $items = Shop::all();
        return Inertia::render('Shop', [
            'Items' => $items,
        ]);
    }

    public function index()
    {
        return Inertia::render('Home');
    }
}
