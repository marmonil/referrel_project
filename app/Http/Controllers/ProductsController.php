<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\order;

class ProductsController extends Controller
{
    function products()
    {
        $orders = order::all();
        return view('admin.order.orders', [
            'orders' => $orders,
        ]);
    }
    function order_status(Request $request)
    {
        $after_explode = explode(',', $request->status);
        $order_id = $after_explode[0];
        $status = $after_explode[1];
        order::find($order_id)->update([
            'status' => $status,
        ]);
        return back();
    }
}
