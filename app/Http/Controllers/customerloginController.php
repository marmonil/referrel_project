<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;

class customerloginController extends Controller
{
    function customer_login(Request $request)
    {
        if (Auth::guard('customerlogin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            if (Auth::guard('customerlogin')->user()->email_veried_at == null) {
                Auth::guard('customerlogin')->logout();
                return redirect('hobi/register')->with('email_verify', 'please verify your email');
            }
            return redirect('/');
        } else {
            return redirect()->route('coustomer.register.store');
        }
    }
    function customer_logout()
    {
        Auth::guard('customerlogin')->logout();
        return redirect()->route('hobi.register');
    }
}
