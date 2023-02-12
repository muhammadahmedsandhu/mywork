<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view("front.profile");
    }

    public function saveProfile(Request $request)
    {
        $request->validate([
            "first_name" => "required",
            "last_name" => "required",
            "payment_method" => "required",
            "account_number" => "required",
            "head_line" => "required",
            "image" => "required|image|mimes:jpeg,png,jpg,gif,svg",
            "summary" => "required",
            "account_name" => "required",
        ]);

        $user = auth()->user();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->payment_method = $request->payment_method;
        $user->account_number = $request->account_number;
        $user->account_name = $request->account_name;
        $user->head_line = $request->head_line;
        if ($request->hasFile("image")) {
            $image = $request->file("image");
            $image_name = time() . "." . $image->getClientOriginalExtension();
            $image->move(public_path("images"), $image_name);
            $user->image = $image_name;
        }else{
            $user->image = $user->image;
        }
        $user->summary = $request->summary;
        $user->is_profile_completed = 1;
        $user->save();
        return redirect()->back()->with(session()->flash('alert-success', 'Profile updated successfully.'));
    }

    public function userDashboard()
    {
        return view("front.user-dashboard");
    }
}
 