<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class subcategoryController extends Controller
{
    function subcetegory()
    {
        $categories = category::all();
        $subcategory = subcategory::all();
        return view('admin.subcategory.index', [
            'categories' => $categories,
            'subcategory' => $subcategory,
        ]);
    }


    function subcetegory_store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'subcategory_name' => 'required',
        ]);
        if (subcategory::where('category_id', $request->category_id)->where('subcategory_name', $request->subcategory_name)->exists()) {
            return back()->with('exist', 'subcategory name already exist in this category');
        } else {
            subcategory::insert([
                'category_id' => $request->category_id,
                'subcategory_name' => $request->subcategory_name,
                'created_at' => carbon::now(),
            ]);
            return back()->with('success', 'Subcategory Added');
        }
    }
    function subcategory_edit($subcategory_id)
    {
        $subcategory_info = subcategory::find($subcategory_id);
        $categories = Category::all();
        return view('admin/subcategory/edit', [
            'categories' => $categories,
            'subcategory_info' => $subcategory_info,
        ]);
    }
    function subcategory_update(Request $request)
    {
        if (subcategory::Where('category_id', $request->subcategory_id)->orWhere('subcategory_name', $request->subcategory_name)->exists()) {
            return back()->with('exist', 'subcategory name already exist in this category');
        } else {
            subcategory::where('id', $request->subcategory_id)->update([
                'category_id' => $request->category_id,
                'subcategory_name' => $request->subcategory_name,
            ]);
            return redirect()->route('subcategory');
        }
    }
    function subcategory_delete($subcategory_id)
    {
        subcategory::find($subcategory_id)->delete();
        return back();
    }
}
