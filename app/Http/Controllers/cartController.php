<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cart;
use Carbon\Carbon;
use Auth;

class cartController extends Controller
{
    function cart_store(Request $request)
    {
        cart::insert([
            'customer_id' => Auth::guard('customerlogin')->id(),
            'product_id' => $request->product_id,
            'size_id' => $request->size_id,
            'color_id' => $request->color_id,
            'quantity' => $request->quantity,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('cart', 'cart added');
    }
    function cart_delete($cart_Id)
    {
        cart::find($cart_Id)->delete();
        return back();
    }
    function cart_update(Request $request)
    {
        foreach ($request->quantity as $cart_id => $quantity) {
            cart::find($cart_id)->update([
                'quantity' => $quantity,
            ]);
        }
        return back();
    }
}
