<?php

namespace App\Http\Controllers;

use App\Models\coustomer_login;
use App\Models\customerEmailVerify;
use App\Models\Network;
use App\Notifications\customerEmailVerifynotification;
use Illuminate\Http\Request;
use carbon\carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;


class hobicontroller extends Controller
{
    function hobi_register()
    {
        return view('frontend.coustomer_register');
    }


    function coustomer_register_store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:4',
            'email' => 'required|string|email|max:100|unique:coustomer_logins',
            'password' => 'required|min:6|confirmed',
        ]);
        $referrelCode = Str::random(10);
        if (isset($request->referrel_code)) {
            $user_data = coustomer_login::where('referrel_code', $request->referrel_code)->get();
            if (count($user_data) > 0) {
                $user_id = coustomer_login::insertGetId([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'referrel_code' => $referrelCode,
                    'created_at' => carbon::now(),
                ]);
                Network::insert([
                    'referrel_code' => $request->referrel_code,
                    'user_id' => $user_id,
                    'parent_user_id' => $user_data[0]['id'],
                ]);
            } else {
                return back()->with('error', 'Please enter valid referrel code');
            }
        } else {
            coustomer_login::insert([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'referrel_code' => $referrelCode,
                'created_at' => carbon::now(),
            ]);
        }

        $domain = URL::to('/');
        $url = $domain . '/referral_register?ref=' . $referrelCode;
        $data['url'] = $url;
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = $request->password;
        $data['title'] = 'registered'; // Corrected the spelling of 'registered'

        Mail::send('emails.registart_mail', ['data' => $data], function ($message) use ($data) {
            $message->to($data['email'])->subject($data['title']);
        });



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
    function referral_register(Request $request)
    {
        if (isset($request->ref)) {
            $referrel = $request->ref;
            $user_data = coustomer_login::where('referrel_code', $referrel)->get();

            if (count($user_data) > 0) {
                return view('frontend.referrel_register', compact('referrel'));
            } else {
                return view('frontend.404');
            }
        } else {
            redirect('/');
        }
    }
}
