<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $color = Color::orderBy('id','desc')->get();
        return view('back-end.color',compact('color'));
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
        //
        $Validator = Validator::make($request->all(), [
            'name' => 'required|unique:colors,name',
        ]);
        if($Validator->passes()){
            $color = new Color();
            $color->name = $request->name;
            $color->color_code = $request->color;
            $color->status = $request->status;
            $color->save();

            return response()->json([
                'status' => 200,
                'message' => 'Color created successfully'
            ]);
        }else{
            return response()->json([
                'status' => 422,
                'errors' => $Validator->errors()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function list(Request $request){

        //pagination form
        $limit = 5;
        $page  = $request->page;  //2

        $offset = ($page - 1) * $limit;

        if(!empty($request->search)){
            $colors = Color::where('name','like','%'.$request->search.'%')
                            ->orderBy("id","DESC")
                            ->limit($limit)
                            ->offset($offset)
                            ->get();
            $totalRecord = Color::where('name','like','%'.$request->search.'%')->count();
        }else{
            $colors = Color::orderBy("id","DESC")
                            ->limit($limit)
                            ->offset($offset)
                            ->get();
            $totalRecord = Color::count();
        }

        
       
        //totalRecord 
         
        
        $totalPage   = ceil($totalRecord / 5);  // 2.1 => 3

        return response([
            'status' => 200,
            'page' => [
                'totalRecord' => $totalRecord,
                'totalPage'  => $totalPage,
                'currentPage' => $page,
            ],
            'colors' => $colors
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
    public function update(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:colors,name,'.$request->color_id,
        ]);

        if($validator->passes()){
            $color = Color::find($request->color_id);

            //checking color not found
            if($color == null){
                return response([
                   'status' => 404,
                   'message' => "Color not found with id "+$request->color_id
                ]);
            }

            $color->name = $request->name;
            $color->color_code = $request->color;
            $color->status = $request->status;
            $color->save();

            return response([
                'status' => 200,
                'message' => "Color updated successful"
            ]);

        }else{
            return response()->json([
                'status' => 500,
                'error' => $validator->errors(),
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

    }
}
