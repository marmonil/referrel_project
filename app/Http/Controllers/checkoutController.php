<?php

namespace App\Http\Controllers;

use App\Mail\customerInvoice;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\order;
use App\Models\billing;
use App\Models\cart;
use App\Models\inventory;
use App\Models\orderProduct;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;


class checkoutController extends Controller
{
    function getCity(Request $request)
    {
        $str = '<option value="">Select a City</option>';
        $cities = City::where('country_id', $request->country_id)->get();
        foreach ($cities as $city) {
            $str = '<option value="' . $city->id . '">' . $city->name . '</option>';
            echo $str;
        }
    }
    function order_store(Request $request)
    {
        if ($request->payment_method == 1) {


            $order_id = order::insertGetId([
                'customer_id' => Auth::guard('customerlogin')->id(),
                'sub_total' => $request->sub_total,
                'discount' => $request->discount_final,
                'delivery' => $request->delivery,
                'total' => $request->sub_total - $request->discount_final + ($request->delivery),
                'created_at' => Carbon::now(),

            ]);
            billing::insert([
                'order_id' => $order_id,
                'customer_id' => Auth::guard('customerlogin')->id(),
                'name' => $request->name,
                'email' => $request->email,
                'phpne' => $request->phone,
                'country_id' => $request->country,
                'city_id' => $request->city,
                'address' => $request->address,
                'company' => $request->company,
                'notes' => $request->notes,
                'created_at' => Carbon::now(),
            ]);



            $carts = cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
            foreach ($carts as $cart) {
                orderProduct::insert([
                    'order_id' => $order_id,
                    'product_id' => $cart->product_id,
                    'customer_id' => Auth::guard('customerlogin')->id(),
                    'price' => $cart->rel_to_product->after_discount,
                    'quantity' => $cart->quantity,
                    'color_id' => $cart->color_id,
                    'size_id' => $cart->size_id,
                    'created_at' => Carbon::now(),
                ]);
                inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quantity', $cart->quantity);
                // cart::find($cart->id)->delete();
            }
            $grand_total = $request->sub_total - $request->discount_final + ($request->delivery);
            Mail::to($request->email)->send(new customerInvoice($order_id));
            $url = "http://bulksmsbd.net/api/smsapi";
            $api_key = "E9sehlkDOaOiiGpbQIEe";
            $senderid = "8809617611040";
            $number = $request->phone;
            $message = "your order has successfuly placed . your order id is $order_id and amount is $grand_total . ";

            $data = [
                "api_key" => $api_key,
                "senderid" => $senderid,
                "number" => $number,
                "message" => $message
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);
            return redirect()->route('order.success')->with('ordersuccess', 'your order has been successfuly placed');
        } elseif ($request->payment_method == 2) {
            $data = $request->all();
            return view('exampleHosted', [
                'data' => $data,
            ]);
        } else {
            $data = $request->all();
            return view('stripe', [
                'data' => $data,
            ]);
        }
    }
    function order_success()
    {
        if (session('ordersuccess')) {
            return view('frontend.ordersuccess');
        } else {
            abort(404);
        }
    }
}
