<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                "name" => "required",
                "email" => "required|email|unique:users,email",
                "password" => "required|min:8",
                "confirm_password" => "required|same:password",
            ]);
            if($validator->fails()){
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();

            // Redirect to dashboard/login page after authorization
            if(Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password]))
            {
                return redirect()->route('index');
            }else{
                return redirect()->route('login')->with('error', 'There was something wrong please login from here.');
            }

        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                "email" => "required|email",
                "password" => "required",
            ]);
            if($validator->fails()){
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            if(Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password]))
            {
                return redirect()->route('index');
            }else{
                return redirect()->route('login')->with('error', 'Email or password is incorrect.');
            }
        }catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('index')->with('success', 'You are logged out successfully.');
    }
}
