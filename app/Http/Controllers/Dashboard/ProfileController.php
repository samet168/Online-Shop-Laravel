<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Fluent\Concerns\Has;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::user()->id);
        return view('back-end.profile', [
            'user' => $user
        ]);
    }
    public function changePassword(Request $request) {
        // dd($request->all());
        $Validator = Validator::make($request->all(), [
            'current_pass'=>'required',
            'new_pass'=>'required',
            'c_password'=>'required|same:new_pass',
        ]);
        session()->flash('password');

        if($Validator->passes()){
            $current_pass = $request->current_pass;
            $user = User::find(Auth::user()->id);
            
            if(password_verify($current_pass, $user->password)){
                $user -> password = Hash::check($current_pass, $user->password);
                $user -> save();
                session()->flash('success', 'Password changed successfully.');
                return redirect()->back();
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Current password is incorrect',
                ],200);
            }
           
            return response()->json([
                'status' => true,
                'message' => 'Password changed successfully',
            ],200);
        }else{
            return redirect()->back()->withInput()->withErrors($Validator->errors());
        }

    }
    // public function updateProfile(Request $request) {
    //     $Validator = Validator::make($request->all(), [
    //         'name'=>['required', 'string', 'max:255'],
    //         'email'=>['required', 'string', 'email', 'max:255','unique:users,email,'.Auth::user()->id],
    //         'phone'=>[ 'required', 'string', 'max:20', 'unique:users,phone,'.Auth::user()->id],
    //     ]);
    //     session()->flash('profile');
    //     if($Validator->passes()){
    //         $user = User::find(Auth::user()->id);
    //         $user->name = $request->name;
    //         $user->email = $request->email;
    //         $user->phone = $request->phone; 


    //             if($request->image_name){
    //                 $ImageName = $request->image_name;
    //                 $Image_path = public_path('uploads/temp/'.$ImageName);
    //                 $user_path  = public_path('uploads/user/'.$ImageName);

    //                 if(File::exists($Image_path)){

    //                     File::copy($Image_path, $user_path);
    //                     File::delete($Image_path);
    //                     $user->image = $ImageName;
    //                 }
    //             }
    //         $user->save();
    //         session()->flash('success', 'Profile updated successfully.');
    //         return redirect()->back()->with('success', 'Profile updated successfully.') ;
    //     }else{
    //         return redirect()->back()->withInput()->withErrors($Validator->errors());
    //     }
    // }
    // public function changeProfileImage(Request $request){
       
    //     session()->flash('profile');

    //     if($request->hasFile('image')){
    //         $image = $request->file('image');
    //         $name = time().'.'.$image->getClientOriginalExtension();
    //         $image->move("uploads/temp/", $name);


    //         return response([
    //             'status' => 200,
    //             'image' => $name,
    //             'message' => 'Image uploaded successfully.'
    //         ]);
    //     }else{
    //         return response()->json([
    //             'status' => 500,
    //             'message' => 'Failed to upload image.'
    //         ]);
    //     }

    // }

    // Upload image to temp folder
    public function changeProfileImage(Request $request){
        if($request->hasFile('image')){
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/temp/'), $name);

            return response()->json([
                'status' => 200,
                'image' => $name,
                'message' => 'Image uploaded successfully.'
            ]);
        }else{
            return response()->json([
                'status' => 500,
                'message' => 'Failed to upload image.'
            ]);
        }
    }

    // Update profile
    public function updateProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email'=> 'required|email|unique:users,email,'.Auth::id(),
            'phone'=> 'required|string|max:20|unique:users,phone,'.Auth::id(),
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // Check if image uploaded via AJAX
        if($request->image_name){
            $ImageName = $request->image_name;
            $Image_path = public_path('uploads/temp/'.$ImageName);
            $user_path  = public_path('uploads/user/'.$ImageName);

            if(File::exists($Image_path)){
                File::copy($Image_path, $user_path);
                File::delete($Image_path);
                $user->image = $ImageName;
            }
        }

        $user->save();

        return redirect()->back()->with('success','Profile updated successfully.');
    }
}