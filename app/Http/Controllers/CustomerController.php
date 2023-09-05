<?php

namespace App\Http\Controllers;

use App\Models\orderProduct;
use App\Models\coustomer_login;
use App\Models\customerPasswordReset;
use App\Notifications\customerPassResetNotification;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;



class CustomerController extends Controller
{
    function invoicedownload($order_id)
    {
        $pdf = Pdf::loadView('invoice.customerinvoice', [
            'order_id' => $order_id,
        ]);
        return $pdf->stream('invoice.pdf',);
    }
    function review(Request $request)
    {
        orderProduct::where('customer_id', Auth::guard('customerlogin')->id())->where('product_id', $request->product_id)->update([
            'review' => $request->review,
            'star' => $request->star,
        ]);
        return back();
    }
    function pass_reset_repassq_form()
    {
        return view('frontend.pass_reset_repassq_form');
    }
    function pass_reset_repassq_send(Request $request)
    {
        $customer = coustomer_login::where('email', $request->email)->firstOrfail();
        customerPasswordReset::where('customer_id', $customer->id)->delete();
        $pass_reset = customerPasswordReset::create([
            'customer_id' => $customer->id,
            'reset_token' => uniqid(),
            'created_at' => Carbon::now(),
        ]);
        Notification::send($customer, new customerPassResetNotification($pass_reset));
        return back()->with('pass_reset', 'we have already sent a link in your email.please check your email');
    }
    function pass_reset_form($reset_token)
    {
        return view('passReset.pass_reset_form', [
            'data' => $reset_token,
        ]);
    }
    function customer_pass_reset_update(Request $request)
    {
        $customer_token = customerPasswordReset::where('reset_token', $request->reset_token)->firstOrFail();
        $customer_m = coustomer_login::findOrFail($customer_token->customer_id);
        $customer_m->update([
            'password' => Hash::make($request->password),
        ]);
        $customer_token->delete();
        return redirect('hobi/register')->with('pass_reset', 'password reset successfully done');
    }
}
