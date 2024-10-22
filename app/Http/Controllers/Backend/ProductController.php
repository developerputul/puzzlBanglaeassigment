<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function AllProduct(){

        $products = Product::latest()->get();
        return view('backend.product.product_all',compact('products'));
    } // End Method

    public function AddProduct(){

        $categories = Category::latest()->get();
        $subcategory = SubCategory::latest()->get();
        return view('backend.product.product_add',compact('categories','subcategory'));
    } // End Method

    public function StoreProduct(Request $request){

        $image = $request->file('product_thambnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $image->move(public_path('/upload/thambnail/'),$name_gen);
        $save_url = 'upload/thambnail/'.$name_gen;

         Product::insert([

            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace(' ','-',$request->product_name)),
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_desc' => $request->short_desc,
            'product_thambnail' => $save_url,
            'created_at' => Carbon::now(), 
        ]);
        $notification = array(
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('all.product')->with($notification);
    } // End Method

    public function EditProduct($id){

        $categories = Category::latest()->get();
        $subcategory = SubCategory::latest()->get();
        $products = Product::findOrFail($id);
        return view('backend.product.product_edit',compact('categories','products','subcategory',));

    } // End Method
}
