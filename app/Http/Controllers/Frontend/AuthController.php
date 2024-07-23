<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class AuthController extends Controller
{
    public function login(){
        if(Auth::check()){
            return redirect('/');
        }
        return view('frontend.auth.login');
    }

    public function register(){
        if(Auth::check()){
            return redirect('/');
        }
        return view('frontend.auth.register');
    }

    public function userLogin(Request $request){
        $request->validate([
            'number'=>'required',
            'password'=>'required'
        ]);
        if($request->remember == 1){
            $remember = true;
        }else{
            $remember = false;
        }
        if(Auth::attempt(['number' => $request->number, 'password' => $request->password,'u_type'=>2,'status'=>1],$remember)){
            return redirect('/')->with('success','Successfully Logged In...');
        }
        return redirect()->back()->with('error','Invalid login credentials...');
    }

    public function userRegister(Request $req){
        $req->validate([
            'name'=>'required',
            'email'=>'required',
            'number'=>'required',
            'password'=>'required',
            'confirm_pass'=>'required | same:password'
        ]);   

        $checkuser = User::WHERE('number',$req->number)->count();
        if($checkuser > 0){
            return redirect()->back()->with('error','This Number is Already Registered With Us!!');
        }

        $checkuser = User::WHERE('email',$req->email)->count();
        if($checkuser > 0){
            return redirect()->back()->with('error','This Email is Already Registered With Us!!');
        }
        $data = $req->all();
        return view('frontend.auth.verification-otp',compact('data'));
    }

    public function regCompleted(Request $req){

        $user = new User;
        $user->name = $req->name;
        $user->email = $req->email;
        $user->number = $req->number;
        $user->password = \Hash::make($req->password);
        $user->u_type = 2;
        $user->status = 1;
        $user->save();

        if(Auth::attempt(['number'=>$req->number,'password'=>$req->password,'u_type'=>2,'status'=>1])){
            return response()->json([
                'status'=>1,
                'message'=>'Registeration Completed Successfully...'
            ]);
        }

        return response()->json([
            'status'=>0,
            'message'=>'Something Went Wrong...'
        ]);

    }

    public function userLogout(){
        Auth::logout();
        return redirect('/');
    }

    public function verifyUser(Request $req){
        return view('frontend.auth.verification-otp');
    }


}
