<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Stripe;
use Carbon\Carbon;
use App\Models\cart;
use App\Models\City;
use App\Models\order;
use App\Models\billing;
use App\Models\inventory;
use App\Models\orderProduct;
use App\Mail\customerInvoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Library\SslCommerz\SslCommerzNotification;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('stripe');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        $data = session('data');
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create([
            "amount" => $request->total_pay * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Test payment from itsolutionstuff.com."
        ]);
        // $dataJeson  = DB::table('sslorders')
        //     ->where('transaction_id', $request->tran_id)
        //     ->select('data')
        //     ->get();
        // //dd($dataJeson[0]->data);

        // $data = json_decode($dataJeson[0]->data, true);
        // // dd($data);
        // $order_id = order::insertGetId([
        //     'customer_id' => $data['customer_id'],
        //     'sub_total' => $data['sub_total'],
        //     'discount' => $data['discount_final'],
        //     'delivery' => $data['delivery'],
        //     'total' => $data['sub_total'] - $data['discount_final'] + ($data['delivery']),
        //     'created_at' => Carbon::now(),

        // ]);

        // billing::insert([
        //     'order_id' => $order_id,
        //     'customer_id' =>  $data['customer_id'],
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'phpne' => $data['phone'],
        //     'country_id' => $data['country'],
        //     'city_id' => $data['city'],
        //     'address' => $data['address'],
        //     'company' => $data['company'],
        //     'notes' => $data['notes'],
        //     'created_at' => Carbon::now(),
        // ]);



        // $carts = cart::where('customer_id', $data['customer_id'])->get();
        // foreach ($carts as $cart) {
        //     orderProduct::insert([
        //         'order_id' => $order_id,
        //         'product_id' => $cart->product_id,
        //         'customer_id' =>  $data['customer_id'],
        //         'price' => $cart->rel_to_product->after_discount,
        //         'quantity' => $cart->quantity,
        //         'color_id' => $cart->color_id,
        //         'size_id' => $cart->size_id,
        //         'created_at' => Carbon::now(),
        //     ]);
        //     inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quantity', $cart->quantity);
        //     // cart::find($cart->id)->delete();
        // }
        // // dd('ok');
        // $grand_total = $data['sub_total'] - $data['discount_final'] + ($data['delivery']);
        // Mail::to($data['email'])->send(new customerInvoice($order_id));
        // $url = "http://bulksmsbd.net/api/smsapi";
        // $api_key = "E9sehlkDOaOiiGpbQIEe";
        // $senderid = "8809617611040";
        // $number = $data['phone'];
        // $message = "your order has successfuly placed . your order id is $order_id and amount is $grand_total . ";

        // $data = [
        //     "api_key" => $api_key,
        //     "senderid" => $senderid,
        //     "number" => $number,
        //     "message" => $message
        // ];
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // $response = curl_exec($ch);
        // curl_close($ch);
        // return redirect()->route('order.success')->with('ordersuccess', 'your order has been successfuly placed');


        $order_id = order::insertGetId([
            'customer_id' => $data['customer_id'],
            'sub_total' => $data['sub_total'],
            'discount' => $data['discount_final'],
            'delivery' => $data['delivery'],
            'total' => $data['sub_total'] - $data['discount_final'] + ($data['delivery']),
            'created_at' => Carbon::now(),

        ]);
        billing::insert([
            'order_id' => $order_id,
            'customer_id' =>  $data['customer_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phpne' => $data['phone'],
            'country_id' => $data['country'],
            'city_id' => $data['city'],
            'address' => $data['address'],
            'company' => $data['company'],
            'notes' => $data['notes'],
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
        $grand_total = $data['sub_total'] - $data['discount_final'] + ($data['delivery']);
        Mail::to($data['email'])->send(new customerInvoice($order_id));
        $url = "http://bulksmsbd.net/api/smsapi";
        $api_key = "E9sehlkDOaOiiGpbQIEe";
        $senderid = "8809617611040";
        $number = $data['phone'];
        $message = "your order has successfuly placed . your order id is $order_id and amount is $grand_total  doller. ";

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
    }
}
