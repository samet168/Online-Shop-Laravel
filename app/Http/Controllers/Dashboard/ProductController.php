<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Products;
use Illuminate\Http\Request;
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
    // public function store(Request $request)
    // {
    //     //
    //     $Validator = Validator::make($request->all(), [
    //         'title'=>'required',
    //         'price'=>'required|numeric',
    //         'qty'=>'required|numeric',
    //     ]);
    //     if($Validator->passes()){

    //         $product = new Products();
    //         $product->name = $request->title;
    //         $product->price = $request->price;
    //         $product->qty = $request->qty;

    //         $product->brand_id = $request->brand;
    //         $product->category_id = $request->category;
    //         // $product->color = $request->color;
    //         $product->save();

    //         return response()->json([
    //             'status' => 200,
    //             'message' => 'Product created successfully'
    //         ]);
    //     }else{
    //         return response()->json([
    //             'status' => 422,
    //             'errors' => $Validator->errors()
    //         ]);
    //     }
    // }

            public function store(Request $request)
    {
        // 1️⃣ Validate input
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'price' => 'required|numeric',
            'qty'  => 'required|numeric',
 // image files
        ]);

        // 2️⃣ If validation fails, return errors
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ]);
        }

        // 3️⃣ Create product
        $product = new Products();
        $product->name = $request->title;
        $product->desc = $request->desc;
        $product->price = $request->price;
        $product->qty  = $request->qty;
        $product->category_id = $request->category;
        $product->brand_id = $request->brand;
        $product->save();

        // 4️⃣ Handle uploaded images
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/products'), $fileName);
            }
        }

        // 5️⃣ Handle colors (many-to-many)
        if ($request->has('color')) {
            $product->colors()->sync($request->color); 
            // assuming you have a pivot table: product_color
        }

        // 6️⃣ Return success response
        return response()->json([
            'status'  => 200,
            'message' => 'Product created successfully',
            'product' => $product
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
    public function show(string $id)
    {
        //
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
