<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Products;
use Illuminate\Http\Request;

class SingleProductController extends Controller
{
    //
    public function singleProduct(string $id){
        // eager load relation 'images' (lowercase)
        $product = Products::with(['images', 'category', 'brand'])->find($id);
        $related_products = Products::where('brand_id', $product->brand_id)
                                    ->where('id', '!=', $product->id)
                                    ->where('status', 1)
                                    ->limit(4)
                                    ->with('images')
                                    ->get();
        //convert string to array

        $colorID = explode(',', $product->color);
        $colors = Color::whereIn('id',$colorID)->get();
        
        if (!$product) {
            abort(404, 'Product not found');
        }

        $colorStore = [];
        foreach($colors as $color){
            $colorStore[] = $color;
        }

        return view('front-end.single-product', [
            'product' => $product,
            'images' => $product->images,
            'colors' => $colors,
            'category' => $product->category,
            'brand' => $product->brand,
            'related_products' => $related_products,
        ]);
        // return [
        //     'product' => $product,
        //     'images' => $product->images,
        //     'colors' => $colors,
        //     'category' => $product->category,
        //     'brand' => $product->brand,
        //     'related_product' =>$related_products
        // ];
    }
    
}
