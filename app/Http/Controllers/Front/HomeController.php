<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function homePage(){

        // Get latest 3 categories
        $categories = Category::limit(3)->get();

        $products    = Products::orderBy('id','DESC')->where('status',1)->with('Images')->limit(9)->get();


        $data['categories'] = $categories;
        $data['products']   = $products;

        // Load home page view with categories and products data
        return view('front-end.index',$data);
        // return response()->json([
        //     'status' => 200,
        //     'data' => $data ,
        //     'product'=> $products
        // ]);

    }


    public function productCategory(string $id){

        
        $products = Products::where('category_id',$id)
                    ->where('status',1)->with('Images')
                    ->paginate(9);

        
        if(!$products){
            return response()->json([
               'status' => 404,
               'message' => 'Category not found'
            ]);
        }

        return view('front-end.shop',[
            'products' => $products
        ]);

    }

    public function viewProduct(Request $request){
        // Fetch product details
        $product = Products::where('id',$request->id)->with('Images')->first();

        // Check if product exists
        if(!$product){
            return response()->json([
                'status' => 404,
                'message' => 'Product not found'
            ]);
        }

        return response()->json([
            'status' => 200,
            'product' => $product,
        ]);
    }
    
}
