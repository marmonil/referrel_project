<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\color;
use App\Models\size;
use App\Models\category;
use App\Models\inventory;
use App\Models\Thumbnails;
use App\Models\cart;
use App\Models\copun;
use App\Models\Country;
use App\Models\order;
use App\Models\orderProduct;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Arr;
use Ramsey\Collection\Queue;

class fontendController extends Controller
{
    function welcome()
    {
        $all_products = product::orderBy('created_at', 'DESC')->get();
        $categories = category::all();
        $new_arrivels = product::latest()->take(4)->get();
        $best_selling = orderProduct::groupBy('product_id')
            ->selectRaw('sum(quantity) as sum ,product_id')
            ->orderBy('quantity', 'DESC')
            ->havingRaw('sum>=3')
            ->get();
        // $get_recent = json_decode(cookie::get('recent_view', true));
        // if ($get_recent == null) {
        //     $get_recent = [];
        //     $after_unique = array_unique($get_recent);
        // } else {
        //     $after_unique = array_unique($get_recent);
        //     $all_recent_product = product::find('$after_unique');
        // }
        return view('frontend.index', [
            'all_products' => $all_products,
            'categories' => $categories,
            'new_arrivels' => $new_arrivels,
            'best_selling' => $best_selling,
            // 'all_recent_product' => $all_recent_product,
        ]);
    }
    function product_details($product_slug)

    {
        $product_info = product::where('slug', $product_slug)->get();
        $thumbnails = Thumbnails::where('product_id', $product_info->first()->id)->get();
        $releted_product = product::where('category_id', $product_info->first()->category_id)->where('id', '!=', $product_info->first()->id)->get();
        $available_colors = inventory::where('product_id', $product_info->first()->id)->groupBy('color_id')->selectRaw('sum(color_id) as sum,color_id')->get();
        $reviews = orderProduct::where('product_id', $product_info->first()->id)->whereNotNull('review')->get();
        $total_review = orderProduct::where('product_id', $product_info->first()->id)->whereNotNull('review')->count();
        $total_star = orderProduct::where('product_id', $product_info->first()->id)->whereNotNull('review')->sum('star');
        $product = Product::where('slug', $product_slug)->first();

        // Set the recently viewed product in a cookie
        $recentViewed = Cookie::get('recent_viewed') ? json_decode(Cookie::get('recent_viewed'), true) : [];
        array_unshift($recentViewed, $product->id);
        $recentViewed = array_unique($recentViewed);
        $recentViewed = array_slice($recentViewed, 0, 5); // Limit the number of recently viewed products

        Cookie::queue('recent_viewed', json_encode($recentViewed), 1440); // Cookie will last for 1 day (1440 minutes)

        // $product_id = $product_info->first()->id;
        // $al = cookie::get('recent_view');
        // if (!$al) {
        //     $al = "[]";
        // }
        // $all_info = json_decode($al, true);
        // $all_info = Arr::prepend($all_info, $product_id);
        // $recent_product_id = json_encode($all_info);
        // cookie::queue('recent_view', $recent_product_id, 1000);
        return view('frontend.product_details', [
            'product_info' => $product_info,
            'thumbnails' => $thumbnails,
            'releted_product' => $releted_product,
            'available_colors' => $available_colors,
            'reviews' => $reviews,
            'total_review' => $total_review,
            'total_star' => $total_star,

        ]);
    }
    function contact()
    {
        return view('contact');
    }
    function about()
    {
        return view('about');
    }
    function getSize(Request $request)
    {
        $str = '<option value="">Choose A Option </option>';
        $sizes = inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->get();
        foreach ($sizes as $size) {
            $str .= '<option value="' . $size->size_id . '">' . $size->rel_to_size->size_name . '</option>';
        }
        echo $str;
    }
    function cart(Request $request)
    {
        $copun = $request->copun_name;
        $message = null;
        $copun_type = null; //copun::where('copun_name',  $copun)->first()->copun_type;

        if ($copun == '') {
            $discount = 0;
        } else {
            if (copun::where('copun_name',  $copun)->exists()) {
                if (Carbon::now()->format('Y-m-d') > copun::where('copun_name',  $copun)->first()->validity) {

                    $message = 'Coupon code expired';
                    $discount = 0;
                } else {
                    $discount = copun::where('copun_name',  $copun)->first()->amount;
                    $copun_type = copun::where('copun_name',  $copun)->first()->copun_type;
                }
            } else {
                $discount = 0;
                $message = 'invalid copun';
            }
        }
        $carts = cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.cart', [
            'carts' => $carts,
            'discount' => $discount,
            'message' => $message,
            'copun_type' => $copun_type,
        ]);
    }

    function checkout()
    {
        $countries = Country::all();
        return view('frontend.checkout', [
            'countries' => $countries,
        ]);
    }
    function account()
    {
        $orders = order::where('customer_id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.account', [
            'orders' => $orders,
        ]);
    }
    // function shop(Request $request)
    // {
    //     $data = $request->all();
    //     $all_products = product::where(function ($q) use ($data) {
    //         if (!empty($data['q']) && $data['q'] != '' && $data['q'] != 'undefined') {
    //             $q->where(function ($q) use ($data) {
    //                 $q->where('product_name', 'like', '%' . $data['q'] . '%');
    //                 $q->orWhere('long_desp', 'like', '%' . $data['q'] . '%');
    //             });
    //         }
    //         if (!empty($data['category']) && $data['category'] != '' && $data['category'] != 'undefined') {
    //             $q->where('category_id', $data['category']);
    //         }
    //         if (!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined' || !empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined') {
    //             $q->whereHas('rel_to_inventories', function ($q) use ($data) {
    //                 if (!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined') {
    //                     $q->whereHas('rel_to_color', function ($q) use ($data) {
    //                         $q->where('colors.id', $data['color_id']);
    //                     });
    //                 }
    //                 if (!empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined') {
    //                     $q->whereHas('rel_to_size', function ($q) use ($data) {
    //                         $q->where('sizes.id', $data['size_id']);
    //                     });
    //                 }
    //             });
    //         }
    //     })->get();



    function shop(Request $request)
    {
        $data = $request->all();

        $term = 'created_at';
        $order = 'DESC';
        if (!empty($data['sort']) && $data['sort'] != '' && $data['sort'] != 'undefined') {
            if ($data['sort'] == 1) {
                $term = 'product_name';
                $order = 'ASC';
            } else if ($data['sort'] == 2) {
                $term = 'product_name';
                $order = 'DESC';
            } else if ($data['sort'] == 3) {
                $term = 'after_discount';
                $order = 'DESC';
            } else if ($data['sort'] == 4) {
                $term = 'after_discount';
                $order = 'ASC';
            } else {
                $term = 'created_at';
                $order = 'DESC';
            }
        }

        $all_products = product::where(function ($q) use ($data) {
            if (!empty($data['q']) && $data['q'] != '' && $data['q'] != 'undefined') {
                $q->where(function ($q) use ($data) {
                    $q->where('product_name', 'like', '%' . $data['q'] . '%')
                        ->orWhere('long_desp', 'like', '%' . $data['q'] . '%');
                });
            }

            if (!empty($data['category']) && $data['category'] != '' && $data['category'] != 'undefined') {
                $q->where('category_id', $data['category']);
            }
            if (!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined' || !empty($data['max']) && $data['max'] != '' && $data['max'] != 'undefined') {
                $q->whereBetween('after_discount', [$data['min'], $data['max']]);
            }

            if ((!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined')
                || (!empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined')
            ) {
                $q->whereHas('rel_to_inventories', function ($q) use ($data) {
                    if (!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined') {
                        $q->whereHas('rel_to_color', function ($q) use ($data) {
                            $q->where('colors.id', $data['color_id']);
                        });
                    }

                    if (!empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined') {
                        $q->whereHas('rel_to_size', function ($q) use ($data) {
                            $q->where('sizes.id', $data['size_id']);
                        });
                    }
                });
            }
        })->orderBy($term, $order)->get();



        $categories = category::all();
        $colors = color::all();
        $sizes = size::all();
        return view('frontend.shop', [
            'all_products' => $all_products,
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes,
        ]);
    }
}
