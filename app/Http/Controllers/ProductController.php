<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProjectBid;

class ProductController extends Controller
{
    public function createPage()
    {
        return view("admin.create-product");
    }
 
    public function storeProduct(Request $req)
    {
        $this->validate($req,[
            "title" => "required",
            "price" => "required",
            "price_per_work" => "required",
            "deadline" => "required",
            "notes" => "required",
        ]);

        $product = new Product();
        $product->title = $req->title;
        $product->price = $req->price;
        $product->price_per_work = $req->price_per_work;
        $product->desc = $req->desc;
        $product->notes = $req->notes;
        $product->deadline = $req->deadline;
        
        if($req->hasFile("zip"))
        {
            $file = $req->file("zip");
            $new_name = rand()."_".time().".".$file->getClientOriginalExtension();
            $file->move(public_path("uploads/zip/"),$new_name);
            $product->file = $new_name;
        }
        $product->save();
        session()->flash("success","New product created successfully");
        return redirect()->back();
    }

    public function listPage(Request $req)
    {
        $products = Product::where("deadline",">",date("Y-m-d H:i:s"))->orderBy("id","desc")->paginate(15);
        return view("admin.list-product",compact("products"));
    }

    public function projectList($id)
    {
        $products = ProjectBid::where("product_id",$id)->orderBy("id","desc")->paginate(15);
        return view("admin.project-list",compact("products"));
    }

    public function expiredProductList(Request $req)
    {
        $products = Product::where("deadline","<",date("Y-m-d H:i:s"))->orderBy("id","desc")->paginate(15);
        return view("admin.expired-product-list",compact("products"));
    }

    public function editPage($id)
    {
        $product = Product::findOrFail($id);
        return view("admin.edit-product",compact("product"));
    }

    public function update(Request $req)
    {
        $this->validate($req,[
            "productId" => "required|numeric|exists:products,id",
            "title" => "required",
            "price" => "required",
            "deadline" => "required",
            "notes" => "required",
        ]);

        $product = Product::find($req->productId);
        $product->title = $req->title;
        $product->price = $req->price;
        $product->desc = $req->desc;
        $product->notes = $req->notes;
        $product->deadline = $req->deadline;
        
        if($req->hasFile("zip"))
        {
            if($product->file != "")
            {
                if(file_exists(public_path("uploads/zip/$product->file")))
                {
                    unlink(public_path("uploads/zip/$product->file"));
                }
            }

            $file = $req->file("zip");
            $new_name = rand()."_".time().".".$file->getClientOriginalExtension();
            $file->move(public_path("uploads/zip/"),$new_name);
            $product->file = $new_name;
        }
        $product->save();
        session()->flash("success","Product update successfully");
        return redirect()->back();
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);

        if($product->file != "")
        {
            if($product->file != "")
            {
                if(file_exists(public_path("uploads/zip/$product->file")))
                {
                    unlink(public_path("uploads/zip/$product->file"));
                }
            }
        }
        $product->delete();
        session()->flash("success","Product deleted successfully");
        return redirect()->back();
    }

    public function updateProjectStatus(Request $req)
    {
        $this->validate($req,[
            "status" => "required",
        ]);

        $project = ProjectBid::find($req->id);
        $project->status = $req->status;
        $project->save();
        session()->flash("success","Project status updated successfully");
        return redirect()->back();
    }
}
