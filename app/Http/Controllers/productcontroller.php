<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\subcategory;
use App\Models\product;
use App\Models\Thumbnails;
use App\Models\color;
use App\Models\size;
use App\Models\inventory;
use App\models\products;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;


use Illuminate\Http\Request;


class productcontroller extends Controller
{
    function add_product()
    {
        $categories = category::all();
        $subcategories = subcategory::all();

        return view('admin.product.index', [
            'categories' => $categories,
            'subcategories' => $subcategories,
        ]);
    }

    function getsubcategory(Request $request)
    {
        $subcategories = subcategory::where('category_id', $request->category_id)->get();
        $Str = '<option value="">--select subcategory --</option>';
        foreach ($subcategories as $subcategory) {
            $Str .= "<option value='$subcategory->id'>$subcategory->subcategory_name</option>";
        }
        echo $Str;
    }
    function product_store(Request $request)
    {
        $name = str_replace(' ', '-', $request->product_name);
        $slug = Str::lower($name) . '-' . random_int(10000, 90000);
        $product_id = product::insertGetId([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'product_name' => $request->product_name,
            'slug' => $slug,
            'product_price' => $request->product_price,
            'discount' => $request->discount,
            'after_discount' => $request->product_price - ($request->product_price * $request->discount / 100),
            'brand' => $request->brand,
            'short_desp' => $request->short_desp,
            'long_desp' => $request->long_desp,
            'created_at' => Carbon::now(),
        ]);
        $preview = $request->preview;
        $extension = $preview->getClientOriginalextension();
        $file_name = Str::lower($name) . '-' . random_int(100, 999) . '.' . $extension;
        Image::make($preview)->resize(680, 680)->save(public_path('uploads/product/preview/' . $file_name));
        product::find($product_id)->update([
            'preview' => $file_name,
        ]);
        $thumbnails = $request->thumbnail;
        foreach ($thumbnails as $thumbnail) {
            $thumbnail_extenssion = $thumbnail->getClientOriginalextension();
            $thumb_file_name =  Str::lower($name) . '-' . random_int(100, 999) . '.' . $thumbnail_extenssion;
            Image::make($thumbnail)->resize(680, 680)->save(public_path('uploads/product/Thumbnail/' . $thumb_file_name));
        }
        Thumbnails::insert([
            'product_id' => $product_id,
            'Thumbnail' => $thumb_file_name,
            'created_at' => Carbon::now(),

        ]);
        return back()->with('success', 'product added');
    }

    function product_list()
    {
        $all_product = product::all();
        return view('admin.product.product_list', [
            'all_product' => $all_product,
        ]);
    }
    function add_color_size()
    {
        $colors = color::all();
        $sizes = size::all();
        return view('admin.product.color_size', [
            'colors' => $colors,
            'sizes' => $sizes,
        ]);
    }
    function add_color(Request $request)
    {
        color::insert([
            'color_name' => $request->color_name,
            'color_code' => $request->color_code,
            'created_at' => Carbon::now(),
        ]);
        return back();
    }
    function add_size(Request $request)
    {
        size::insert([
            'size_name' => $request->size_name,
            'created_at' => Carbon::now(),
        ]);
        return back();
    }




    function inventory($product_id)
    {
        $colors = color::all();
        $sizes = size::all();
        $product_info = product::find($product_id);
        $invantories = inventory::where('product_id', $product_id)->get();
        return view('admin.product.inventory', [
            'product_info' => $product_info,
            'colors' => $colors,
            'sizes' => $sizes,
            'invantories' => $invantories,
        ]);
    }
    function add_inventory(Request $request)
    {
        if (inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->exists()) {
            inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->increment('quantity', $request->quantity);
            return  back();
        } else {
            inventory::insert([
                'product_id' => $request->product_id,
                'color_id' => $request->color_id,
                'size_id' => $request->size_id,
                'quantity' => $request->quantity,
                'created_at' => Carbon::now(),
            ]);
            return back();
        }
    }
}
