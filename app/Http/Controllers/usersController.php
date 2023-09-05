<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class usersController extends Controller
{
    function dashboard()
    {
        return view('layouts.dashboard');
    }



    function users()
    {
        $users = user::all();
        $total_user = user::count();
        return view('admin.users_list.user_list', compact('users', 'total_user'));
    }
    function delete($user_id)
    {
        user::find($user_id)->delete();
        return back()->with('delete', 'user id successfully deleted');
    }
    function profile()
    {
        return view('admin.profile');
    }
    function name_change(Request $request)
    {
        User::find(Auth::id())->update([
            'name' => $request->name,
        ]);
        return back()->with('success', 'name has been updated');
    }
    function password_change(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
            'password_confirmation' => 'required',
        ], [
            'old_password.required' => ' old password de',
            'password.required' => 'password de',
            'password_confirmation.required' => 'abar password de',
            'password.confirmed' => ' new password r confirm password mile nai',
        ]);
        if (Hash::check($request->old_password, Auth::user()->password)) {
            User::find(Auth::id())->update([
                'password' => bcrypt($request->password),

            ]);
            return back()->with('pass_success', 'password has been changed');
        } else {
            return back()->with('wrong', 'thi thak moto puran password de');
        }
    }
    function photo_change(Request $request)
    {
        $profile_photo = $request->profile_photo;
        if (Auth::user()->profile_photo != null) {
            $path = public_path('uploads/user/' . Auth::user()->profile_photo);
            unlink($path);

            $extension = $profile_photo->getClientOriginalExtension();
            $file_name = Auth::id() . '.' . $extension;
            $img = Image::make($profile_photo)->save(public_path('uploads/user/' . $file_name));
            User::find(Auth::id())->update([
                'profile_photo' => $file_name,
            ]);
            return back()->with('photo_success', 'photo has been changed');
        } else {
            $extension = $profile_photo->getClientOriginalExtension();
            $file_name = Auth::id() . '.' . $extension;
            $img = Image::make($profile_photo)->save(public_path('uploads/user/' . $file_name));
            User::find(Auth::id())->update([
                'profile_photo' => $file_name,
            ]);
            return back()->with('photo_success', 'photo has been changed');
        }
    }
}
