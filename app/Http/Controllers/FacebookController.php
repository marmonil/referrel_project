<?php

namespace App\Http\Controllers;

use App\Models\coustomer_login;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class FacebookController extends Controller
{
    function redirct_provider()
    {
        return Socialite::driver('facebook')->redirect();
    }
    function provider_to_aplication()
    {
        $user = Socialite::driver('facebook')->user();

        if (coustomer_login::where('email', $user->getEmail())->exists()) {
            if (Auth::guard('customerlogin')->attempt(['email' => $user->getEmail(), 'password' => 'abc@123'])) {
                return redirect('/');
            }
        } else {
            coustomer_login::insert([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => bcrypt('abc@123'),
                'created_at' => Carbon::now(),


            ]);
            if (Auth::guard('customerlogin')->attempt(['email' => $user->getEmail(), 'password' => 'abc@123'])) {
                return redirect('/');
            }
        }
    }
}
