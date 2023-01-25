<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
            "deadline" => "required",
        ]);

        $product = new Product();
        $product->title = $req->title;
        $product->price = $req->price;
        $product->desc = $req->desc;
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
        $products = Product::orderBy("id","desc")->paginate(15);

        return view("admin.list-product",compact("products"));
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
        ]);

        $product = Product::find($req->productId);
        $product->title = $req->title;
        $product->price = $req->price;
        $product->desc = $req->desc;
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
}
