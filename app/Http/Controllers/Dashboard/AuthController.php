<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function login(){
        if(Auth::check()){
            if(Auth::user()->role == 1){
                return redirect()->route('dashboard.index');
            }
            return redirect()->route('category.index');
        }
        return view('back-end.login');
    }
public function authenticate (Request $request){
    $validator = Validator::make($request->all(),[
        'email'=>'required|email',
        'password'=>'required'
    ]);

    if($validator->passes()){
        $credentials = $request->only('email','password');
        if(Auth::attempt($credentials)){
            if(Auth::user()->role == 1){
                return redirect()->intended(route('dashboard.index'))->with("success","Login successfully");
            }elseif(Auth::user()->role == 2){
                return redirect()->intended(route('category.index'))->with("success","Login successfully");
            }
            else{
                return redirect()->back()->withInput()->with("error","You don't have permission to access this page");
            }
        } else {
            return redirect()->back()->withInput()->with("error","Invalid email or password");
        }        
    } else {
        return redirect()->back()->withInput()->withErrors($validator)->with("error","Validation error");
    }
}

    public function logout(){
        Auth::logout();
        return redirect()->route('auth.index');
    }


}
