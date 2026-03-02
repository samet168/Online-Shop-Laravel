<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\ProductImage;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('back-end.product');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


public function store(Request $request)
{
    // 1️⃣ Validate input
    $validator = Validator::make($request->all(), [
        'title' => 'required',
        'price' => 'required|numeric',
        'qty'   => 'required|numeric',
        // image files
    ]);

    // 2️⃣ If validation fails, return errors
    if ($validator->fails()) {
        return response()->json([
            'status' => 422,
            'errors' => $validator->errors()
        ]);
    }

    // 3️⃣ Create new product
    $product = new Products();
    $product->name        = $request->title;
    $product->desc        = $request->desc;
    $product->price       = $request->price;
    $product->qty         = $request->qty;
    $product->category_id = $request->category;
    $product->brand_id    = $request->brand;
    $product->color    = implode(",", $request->color);
    $product->user_id     = Auth::user()->id;
    $product->status      = $request->status;
    $product->save();

    // 4️⃣ Handle uploaded images
    if ($request->image_uploads != null) {
        $images = $request->image_uploads;
        $product->image = $images;

        foreach ($images as $img) {
            $image = new ProductImage();
            $image->product_id = $product->id;
            $image->image      = $img;

            if (File::exists(public_path('uploads/temp/' . $img))) {
                File::copy(
                    public_path('uploads/temp/' . $img),
                    public_path('uploads/product/' . $img)
                );
                File::delete(public_path('uploads/temp/' . $img));
            }

            $image->save();
        }
    }

    // 5️⃣ Return success response
    return response()->json([
        'status'  => 200,
        'message' => 'Product created successfully'
    ]);
} 
     public function data(){
        $categories = Category::orderBy("id","DESC")->get();
        $brands = Brand::orderBy("id","DESC")->get();
        $color  = Color::orderBy("id","DESC")->get();

        return response([
            'status' => 200,
            'data' => [
                'categories' => $categories,
                'brands' => $brands,
                'colors' => $color,
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
public function list()
{
    $products = Products::orderBy("id","DESC")
                ->with('Category','Brand','Images') // use proper relation names
                ->get();

    return response()->json([
        'status' => 200,
        'products' => $products
    ]);
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
