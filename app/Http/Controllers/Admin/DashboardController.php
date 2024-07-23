<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\State;
use Carbon\Carbon;
use Auth;

class DashboardController extends Controller
{
    public function dashboard(){
        $product = Product::Where('status',1)->count();
        $order = Order::count();
        $user = User::Where('u_type',2)->where('status',1)->count();
        $revenue = Order::sum('payment');
        $todayRevenue = Order::whereDay('created_at',now()->day)->sum('payment');
        $currentMonthRevenue = Order::whereMonth('created_at', Carbon::now()->month)->sum('payment');
        return view('admin.dashboard',compact('product','order','user','revenue','currentMonthRevenue','todayRevenue'));
    }

    public function profileView(){
        if(Auth::check()){
            $id = Auth::id();
            $user = User::Where('id',$id)->first();
            $state = State::Where('country_id',101)->get();
            return view('admin.profile.view-profile',compact('user','state'));
        }
        return redirect('/admin/login');
    }

    public function updateProfile(Request $req){
        $req->validate([
            'name'=>'required',
            'email'=>'required',
            'number'=>'required'
        ]);

        $id = Auth::id();
        $user = User::Where('id',$id)->first();
        if($req->profile_image){
            $image = $req->profile_image;
            $userImage = rand().time().substr(str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,5).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/user');
            $image->move($destinationPath, $userImage);
            $user->image = $userImage;
        }
        $user->name = $req->name;
        $user->email = $req->email;
        $user->number = $req->number;
        $user->password = \Hash::make($req->password);
        $user->locality = $req->locality;
        $user->state = $req->state;
        $user->city = $req->city;
        $user->save();

        return redirect()->back()->with('success','Profile Updated Successfully!!');
    }   
    

}
