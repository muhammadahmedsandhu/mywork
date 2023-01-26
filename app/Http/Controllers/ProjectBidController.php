<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectBid;

class ProjectBidController extends Controller
{
    public function project($id){
        return view("front.project",compact("id"));
    }

    public function submitProject(Request $req){
        $this->validate($req,[
            "title" => "required",
            "description" => "required",
            "file" => "required",
        ]);

        $bid = new ProjectBid();
        $bid->title = $req->title;
        $bid->description = $req->description;
        $bid->product_id = $req->project_id;
        $bid->user_id = auth()->user()->id;

        if($req->hasFile("file"))
        {
            $file = $req->file("file");
            $new_name = rand()."_".time().".".$file->getClientOriginalExtension();
            $file->move(public_path("uploads/zip/"),$new_name);
            $bid->file = $new_name;
        }
        $bid->save();
        session()->flash("success","Your project has been submitted successfully");
        return redirect()->back();
    }
}
