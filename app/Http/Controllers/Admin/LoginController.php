<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
class LoginController extends Controller
{
    public function login(){
        return view("admin.auth.login");
    }

    public function adminAuthCheck(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password],1)){
            return redirect()->route('admin.dashboard');
        }
        return redirect('admin/login')->with('error_msg','Invalid login credentials...');
    }

    public function logout(){
        \Session::flush();
        Auth::logout();
        return redirect('/admin/login');
    }
}
