<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    //
    public function index(){
        $categories = Category::orderBy('id','desc')->get();
        return view('back-end.brand',compact('categories'));
    }
    
    public function list(Request $request){
        $brands = Brand::orderBy('id','desc')->with('category')->get();
        return response()->json([
            'status' => 200,
            'brands' => $brands
        ]);

    }
    public function store(Request $request){
        $Validator = Validator::make($request->all(), [
            'name' => 'required|unique:brands,name',
        ]);
        if($Validator->passes()){
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->category_id = $request->category;
            $brand->status = $request->status;
            $brand->save();

            return response()->json([
                'status' => 200,
                'message' => 'Brand created successfully'
            ]);
        }else{
            return response()->json([
                'status' => 422,
                'errors' => $Validator->errors()
            ]);
        }
        
    }
    public function update(Request $request){
        $Validator = Validator::make($request->all(), [
            'name' => 'required|unique:brands,name,'.$request->id,
        ]);
        if($Validator->passes()){
            $brand = Brand::find($request->brand_id);
            $brand->name = $request->name;
            $brand->category_id = $request->category;
            $brand->status = $request->status;
            $brand->save();

            return response()->json([
                'status' => 200,
                'message' => 'Brand updated successfully'
            ]);
        }else{
            return response()->json([
                'status' => 422,
                'errors' => $Validator->errors()
            ]);
        }
    }
    public function destroy (Request $request){ {
            $brand = Brand::find($request->id);
            $brand->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Brand deleted successfully'
                
            ]);
        }
        
    }

}
