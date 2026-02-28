<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    //
public function uploads(Request $request)
{
    // check if file exists
    if ($request->hasFile('image')) {
        $files = $request->file('image');

        // generate unique file name
        $images = [];
        foreach($files as $file){
        $fileName = time() . '_' . $file->getClientOriginalName();
        $images[] = $fileName;
        $file->move(public_path('uploads/temp'), $fileName);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Image uploaded successfully',
            'image' => $images
        ]);
    }

    // no file uploaded
    return response()->json([
        'status' => 400,
        'message' => 'No image uploaded'
    ]);
}
// public function uploads(Request $request)
// {
//     if ($request->hasFile('image')) {
//         $files = $request->file('image');
//         $images = [];

//         // make $files always an array
//         if (!is_array($files)) {
//             $files = [$files];
//         }

//         foreach ($files as $file) {
//             $fileName = time() . '_' . $file->getClientOriginalName();
//             $file->move(public_path('uploads/temp'), $fileName);
//             $images[] = $fileName;
//         }

//         return response()->json([
//             'status' => 200,
//             'message' => 'Image uploaded successfully',
//             'images' => $images
//         ]);
//     }

//     return response()->json([
//         'status' => 400,
//         'message' => 'No image uploaded'
//     ]);
// }
public function cancel(Request $request)
{
    if($request->image){
        $tempDir = public_path('uploads/temp/'.$request->image);
        if(File::exists($tempDir)){
            File::delete($tempDir);
            return response()->json([
                'status' => 200,
                'message' => 'Image deleted successfully'
            ]);
        }
    }


}



}
