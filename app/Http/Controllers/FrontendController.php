<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $products = Product::where("deadline",">",date("Y-m-d H:i:s"))->orderBy("id","desc")->paginate(20);
        return view("front.index",compact("products"));
    }

    public function expiredProducts(){
        $products = Product::where("deadline","<",date("Y-m-d H:i:s"))->orderBy("id","desc")->paginate(20);
        return view("front.expired",compact("products"));
    }
}
