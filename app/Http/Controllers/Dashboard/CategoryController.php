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
            'name' => 'required|unique:categories,name',
        ]);
        if($Validator->passes()){

            $category = new Category();
            $category->name = $request->name;
            // $category->image = $request->image;

            //category image
            if($request->input('category_image')){
                    $tempDir = public_path('uploads/temp/'.$request->input('category_image'));
                    $cateDir = public_path('uploads/category/'.$request->input('category_image'));
                    if(File::exists($tempDir)){
                        File::copy($tempDir, $cateDir);
                        File::delete($tempDir);
                    }
                    $category->image = $request->input('category_image');
            }

            $category->save();

            return response()->json([
                'status' => 200,
                'message' => 'Category created successfully'
            ]);
        }else{
            return response()->json([
                'status' => 422,
                'errors' => $Validator->errors()
            ]);
        }


    }
    public function list(){
        $categories = Category::orderBy("id","DESC")->get();
        return response([
           'status' => 200,
           'categories' => $categories
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
    public function edit(Request $request)
    {
        $category = Category::find($request->id);
        if(!$category){
            return response()->json([
                'status' => 404,
                'message' => 'Category not found'
            ]);
        }
        return response()->json([
            'status' => 200,
            'category' => $category
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request)
{
    $category = Category::find($request->category_id);

    if(!$category){
        return response()->json([
            'status' => 404,
            'message' => "Category not found"
        ]);
    }

    $validator = Validator::make($request->all(),[
        'name' => 'required|unique:categories,name,'.$request->category_id,
    ]);

    if($validator->fails()){
        return response()->json([
            'status' => 422,
            'errors' => $validator->errors(),
        ]);
    }

    $category->name = $request->name;
    $category->status = $request->status;

    $image = $category->image;
    
    //category image
    if($request->filled('category_image')){
        $tempDir = public_path('uploads/temp/'.$request->category_image);
        $cateDir = public_path('uploads/category/'.$request->category_image);

        if(File::exists($tempDir)){
            File::copy($tempDir, $cateDir);//copy new image
            File::delete($tempDir);
        }

        //delete old image
        $oldImage = public_path('uploads/category/'.$category->image);
        if(File::exists($oldImage) && $category->image != null){//if old image exists
            File::delete($oldImage);
        }

        $image = $request->category_image;
    }

    $category->image = $image;
    $category->save();

    return response()->json([
        'status' => 200,
        'message' => "Category updated successfully"
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
public function destroy($id)
{
    $category = Category::find($id);
    if(!$category){
        return response()->json([
            'status' => 404,
            'message' => 'Category not found'
        ]);
    }

    // Delete image
    if($category->image){
        $path = public_path('uploads/category/'.$category->image);
        if(File::exists($path)){
            File::delete($path);
        }
    }

    $category->delete();

    return response()->json([
        'status' => 200,
        'message' => 'Category deleted successfully'
    ]);
}
}
