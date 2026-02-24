<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserController extends Controller
{
    //
    public function index(){
        return view('back-end.user');
    }
    public function list(){
        $users = User::orderBy("id","DESC")->get();
        return response([
           'status' => 200,
           'users' => $users
        ]);
    }
    public function store(Request $request){
            $Validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
            ]);
            if ($Validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $Validator->errors(),
                ],422);
            }
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
                
            ],201);
    }


    public function destroy(Request $request){
        $user = User::find($request->id);
        
        //checking user not found
        if($user == null){
            return response([
               'status' => 404,
               'message' => "User not found with id "+$request->id
            ]);
        }

        $user->delete();
        
        return response([
           'status' => 200,
           'message' => "User deleted successful",
        ]);
    }
}
