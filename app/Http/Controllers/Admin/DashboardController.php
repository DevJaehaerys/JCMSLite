<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function main(){
        $items = Shop::all();
        $user = Auth::user();
        $data = $items->makeVisible(['command'])->toArray();
        return Inertia::render('Dashboard/First', [
            'auth' => $user,
            'items' => $data
        ]);
    }
}
