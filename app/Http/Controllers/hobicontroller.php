<?php

namespace App\Http\Controllers;

use App\Models\coustomer_login;
use App\Models\customerEmailVerify;
use App\Notifications\customerEmailVerifynotification;
use Illuminate\Http\Request;
use carbon\carbon;
use Illuminate\Support\Facades\Notification;

class hobicontroller extends Controller
{
    function hobi_register()
    {
        return view('frontend.coustomer_register');
    }


    function coustomer_register_store(Request $request)
    {
        coustomer_login::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'referrel_code' => $request->referrel_code,
            'created_at' => carbon::now(),
        ]);
        $customer = coustomer_login::where('email', $request->email)->firstOrfail();
        customerEmailVerify::where('customer_id', $customer->id)->delete();
        $verify_email = customerEmailVerify::create([
            'customer_id' => $customer->id,
            'verify_token' => uniqid(),
            'created_at' => Carbon::now(),
        ]);
        Notification::send($customer, new customerEmailVerifynotification($verify_email));
        return back()->with('register', 'coustomer registered success. we have sent a verify link in your email.please verify email befroe login');
    }
    function verify_email($verify_token)
    {
        $token = customerEmailVerify::where('verify_token', $verify_token)->firstOrFail();
        $customer = coustomer_login::findOrFail($token->customer_id);
        $customer->update([
            'email_veried_at' => Carbon::now(),
        ]);
        $token->delete();
        return redirect('hobi/register/')->with('email_verify', 'email verify success ! ');
    }
}
