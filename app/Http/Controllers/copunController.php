<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\copun;

class copunController extends Controller
{
    function copun()
    {
        $copuns = copun::all();
        return view('admin.copun.index', [
            'copuns' => $copuns,
        ]);
    }
    function copun_store(Request $request)
    {
        copun::insert([
            'copun_name' => $request->copun_name,
            'copun_type' => $request->copun_type,
            'amount' => $request->amount,
            'validity' => $request->validity,
            'created_at' => Carbon::now(),
        ]);
        return back();
    }
    function copun_delete($copun_id)
    {
        copun::find($copun_id)->delete();
        return back();
    }
}
