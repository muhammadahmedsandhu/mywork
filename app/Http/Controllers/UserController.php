<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProjectBid;

class UserController extends Controller
{
    public function userList()
    {
        $users = User::where("is_admin",0)->orderBy("id","desc")->paginate(15);
        return view("admin.user-list",compact("users"));
    }

    public function blockUser($id){
        $user = User::find($id);
        $user->is_blocked = 1;
        $user->save();
        return redirect()->back()->with(session()->flash('alert-success', 'User blocked successfully.'));
    }

    public function unblockUser($id){
        $user = User::find($id);
        $user->is_blocked = 0;
        $user->save();
        return redirect()->back()->with(session()->flash('alert-success', 'User unblocked successfully.'));
    }

    public function userProjects($id){
        $projects = ProjectBid::where("user_id",$id)->where("status","approved")->orderBy("id","desc")->paginate(15);
        return view("admin.user-projects",compact("projects"));
    }

    public function updatePaymentStatus(Request $req){
        $project = ProjectBid::find($req->id);
        if($req->payment_status == "approved"){
            if($project->cleared_payment > 0){
                return redirect()->back()->with(session()->flash('alert-danger', 'Payment already cleared.'));
            }
            $project->cleared_payment = $project->pending_payment;
            $project->pending_payment = 0;
        }else{
            $project->pending_payment = $project->cleared_payment;
            $project->cleared_payment = 0;
        }
        $project->save();
        return redirect()->back()->with(session()->flash('alert-success', 'Payment status updated successfully.'));
    }
}
