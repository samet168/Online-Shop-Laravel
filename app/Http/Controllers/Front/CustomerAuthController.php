<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\Customer\CustomerEmail;
use App\Models\PasswordResetToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CustomerAuthController extends Controller
{
    #the function we used for login form
    public function loginShow(){
        return view('front-end.auth.login');
    }

    #the function we used for login process  after login form submitted
    public function loginProcess(Request $request){
        // Validate the request data
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);
        
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password],$request->filled('remember_me'))){
            return redirect()->route('home.index'); 
        }

        return redirect()->back()->with('error', 'Invalid email or password');
    }


    #the function we used for register form
    public function registerShow(){
        return view('front-end.auth.register');
    }

    #the function we used for register
    public function registerProcess(Request $request){

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|min:9|unique:users,phone',
            'password' => 'required|string',
            'confirm_password' => 'required|same:password',
        ]);

        // Create a new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone'   => $request->phone,
            'role'    => 3
        ]);

        return redirect()->route('customer.login')->with('success', 'Account created successfully!');

    }

    #the function we used show send email
    public function sendEmail(){
        return view('front-end.auth.send-email');
    }

    #the function we used for send email process
    public function sendEmailProcess(Request $request){
        
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $code = mt_rand(100000, 999999);
        $token = hash('sha256', random_bytes(30));
        
        PasswordResetToken::updateOrCreate(
            ['email' => $request->email],
            [
                     'token' => $token,
                     'code' => $code, 
                     'expires_at' => now()->addMinutes(20)
                    ]
        );

        $customer = User::where('email', $request->email)->first();


        $data = [
            'name' => $customer->name,
            'code' => $code,
            'token' => $token,
            'email' => $request->email
        ];
        

        Mail::to($request->email)->send(new CustomerEmail($data));
        

        return redirect()->route('code.verify',[
            'token' => $token
        ])->with('success','send code to email sucessful');
        

    }


    #the function we used for show verify code from email
    public function codeVerify(string $token){
        //verify token
        $tokenData = PasswordResetToken::where('token', $token)->first();

        if($tokenData && $tokenData->expires_at > now()){
            return view('front-end.auth.code-verify',compact('tokenData'));
        }

        return redirect()->route('customer.login')->with('error','Token expired or invalid');
        
    }

    #the function we used for verify code from email
    public function codeVerifyProcess(Request $request){
        //code verify process here
        $request->validate([
            'code' => 'required|numeric',
        ]);

        // Find the token data
        $tokenData = PasswordResetToken::where('token', $request->token)->first();

        if (!$tokenData) {
            return redirect()->back()->withErrors([
                'code' => 'Invalid token provided.',
            ]);
        }

        // Check if the code matches and is not expired
        if ($tokenData->code != $request->code || $tokenData->expires_at <= now()) {
            return redirect()->back()->withErrors([
                'code' => 'The verification code is incorrect or has expired.',
            ]);
        }

    

        //success
        return redirect()->route('reset.password.show',[
            'code' => $tokenData->code,
            'token' => $tokenData->token,   
        ])->with('success', 'Code verified successfully!');


    }

    #the function we used for show form reset password
    public function resetPassword(string $code,string $token){

        //verify token
        $tokenData = PasswordResetToken::where('token', $token)
                    ->where('code',$code)->first();

        if($tokenData && $tokenData->expires_at > now()){
            return view('front-end.auth.new-password',compact('tokenData'));
        }

        return redirect()->route('customer.login')->with('error','Token expired or invalid');

    }

    #the function we used for reset password
    public function resetPasswordProcess(Request $request){

        $request->validate([
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        // Find the token data
        $tokenData = PasswordResetToken::where('token', $request->token)
                    ->where('code',$request->code)->first();

        if (!$tokenData) {
            return redirect()->back()->with('error','Token expired or invalid');
        }


        // Check if the code matches and is not expired
        if ($tokenData->code != $request->code || $tokenData->expires_at <= now()) {
            return redirect()->route('send.email.show')->with('error','Token expired or invalid');
        }


        // Update the user's password
        User::where('email', $tokenData->email)->update([
            'password' => Hash::make($request->password),
        ]);

        // Delete the token
        PasswordResetToken::where('token', $request->token)->delete();


        return redirect()->route('home.index')->with('success', 'Password reset successfully!');
    }


}
