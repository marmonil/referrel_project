<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use App\models\category;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Image;

class CategoryController extends Controller
{
    function category()

    {
        $all_categories = category::all();
        $trashed_categories = category::onlyTrashed()->get();

        return view('admin.category.index', [
            'all_categories' => $all_categories,
            'trashed_categories' => $trashed_categories,
        ]);
    }
    function store(CategoryRequest $request)
    {
        $Category_id = category::insertGetId([
            'category_name' => $request->category_name,
            'added-by' => Auth::id(),
            'created_at' => carbon::now(),
        ]);
        $category_image = $request->category_image;
        $extension = $category_image->getClientOriginalExtension();

        $file_name = $Category_id . '.' . $extension;

        Image::make($category_image)->save(public_path('uploads/category/' . $file_name));
        Category::where('id', $Category_id)->update([
            'category_image' => $file_name,
        ]);
        return back()->with('success', 'Category add!');
    }
    function delete($category_id)
    {
        category::find($category_id)->delete();
        return back()->with('delete', 'category successfully deleted');
    }
    function hard_delete($category_id)
    {
        $image = category::onlyTrashed()->find($category_id);
        $delete_from = public_path('uploads/category/' . $image->category_image);
        unlink($delete_from);
        category::onlyTrashed()->find($category_id)->forceDelete();
        return back()->with('hard_delete', 'category successfully deleted');
    }
    function category_restore($category_id)
    {
        category::onlyTrashed()->find($category_id)->restore();
        return back()->with('restrore', 'category successfully restored');
    }
    function category_edit($category_id)
    {
        $category_info = category::find($category_id);


        return view('admin/category/edit', [
            'category_info' => $category_info,
        ]);
    }
    function category_update(Request $request)
    {
        if ($request->category_image == '') {
            category::find($request->category_id)->update([
                'category_name' => $request->category_name,
            ]);
        } else {
            $Image = category::find($request->category_id);
            $delete_from = public_path('uploads/category/' . $Image->category_image);
            unlink($delete_from);
            $category_image = $request->category_image;
            $extension = $category_image->getClientOriginalExtension();
            $file_name = $request->category_id . '.' . $extension;
            Image::make($category_image)->save(public_path('uploads/category/' . $file_name));
            category::find($request->category_id)->update([
                'category_name' => $request->category_name,
                'category_image' => $file_name,
            ]);
            return back()->with('update', 'category updateed successfully');
        }
    }
}
