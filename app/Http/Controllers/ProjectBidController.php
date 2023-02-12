<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectBid;
use App\Models\User;
use App\Models\Product;

class ProjectBidController extends Controller
{
    public function project($id){
        return view("front.project",compact("id"));
    }

    public function submitProject(Request $req){ 
        if(auth()->user()->is_profile_completed == 0){
            return redirect()->back()->with(session()->flash('alert-danger', 'Please complete your profile first.'));
        }
        $this->validate($req,[
            "title" => "required",
            "description" => "required",
            "file" => "required|mimes:zip,rar,7zip,pdf,doc,docx,png,jpg,jpeg,gif,svg,webp",
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
        return redirect()->back()->with(session()->flash('alert-success', 'Project bid submitted successfully.'));
        return redirect()->back();
    }

    public function updateStatus(Request $req){
        $bid = ProjectBid::find($req->id);
        $project = Product::find($bid->product_id);
        if($req->status == "approved"){
            $bid->pending_payment = $project->price_per_work;
        }else{
            $bid->pending_payment = 0;
        }
        $bid->status = $req->status;
        $bid->save();
        return redirect()->back()->with(session()->flash('alert-success', 'Status updated successfully.'));
    }
}
