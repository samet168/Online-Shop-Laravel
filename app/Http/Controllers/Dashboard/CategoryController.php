<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('back-end.category');
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
    public function upload(Request $request)
    {
        $Validatory = Validator::make($request->all(), [
            //  'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image' => 'required' 
        ]);
        if($Validatory->passes()){
            // if ($request->hasFile('image')) {

                $file = $request->file('image');
                $imageName = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/temp'), $imageName);

                return response()->json([
                    'status' => true,
                    'image' => $imageName,
                ]);
            // }

        }else{

            return response()->json([
                'status' => 422,
                'message' => 'No image uploaded',
                'error' => $Validatory->errors()
            ]);
        }

    }

    public function cancel (Request $request){
        if($request->image){
            $tempDir = public_path('uploads/temp/'.$request->image);
            // $tempDir2 = public_path('uploads/category/'.$request->image);
            if(File::exists($tempDir)){
                File::delete($tempDir);
                // File::delete($tempDir2);
                return response()->json([
                    'status' => 200,
                    'message' => 'Image deleted successfully'

                ]);
            }
        }
    }
    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if($Validator->passes()){

            $category = new Category();
            $category->name = $request->name;
            // $category->image = $request->image;
            $category->save();
            return response()->json([
                'status' => true,
                'message' => 'Category created successfully'
            ],201);
        }

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
