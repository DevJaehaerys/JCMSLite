<?php

namespace App\Http\Controllers\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function redirectToSteam()
    {
        return Socialite::driver('steam')->redirect();
    }


    public function handleSteamCallback()
    {
        $user = Socialite::driver('steam')->user();
        $finduser = User::where('steamid', $user->id)->first();

        if ($finduser) {
            Auth::login($finduser);
            return redirect()->intended('/');

        } else {
            $newUser = User::create([
                'name' => $user->nickname,
                'avatar' => $user->avatar,
                'steamid' => $user->id,
                'balance' => 0,
                'group' => 'User',
            ]);

            Auth::login($newUser);

            return redirect()->intended('/');

        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->intended('/');
    }
}
