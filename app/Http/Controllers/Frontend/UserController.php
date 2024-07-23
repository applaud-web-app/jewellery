<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\State;
use App\Models\Order;
use App\Models\OrderChild;
use App\Models\Product;
use App\Models\CustomerReviews;
use Auth;

class UserController extends Controller
{
    public function userProfile(){
        if(Auth::check()){
            $id = Auth::id();
            $states = State::Where('country_id',101)->get();
            $userDetails = User::where('id',$id)->where('status',1)->first();
            return view('frontend.user.profile',compact('userDetails','states'));
        }
        return redirect('login');
    }

    public function updateProfile(Request $req){


        if(Auth::check()){

            $id = Auth::id();
            $req->validate([
                'name'=>'required',
                'email'=>'required',
                'number'=>'required',
                'state'=>'required',
                'city'=>'required',
                'locality'=>'required'
            ]);

            $user = User::where('id',$id)->where('status',1)->first();

            $checkuser = User::WHERE('number',$req->number)->where('id','!=',$id)->count();
            if($checkuser > 0){
                return redirect()->back()->with('error','This Number is Already Registered With Us!!');
            }
    
            $checkuser = User::WHERE('email',$req->email)->where('id','!=',$id)->count();
            if($checkuser > 0){
                return redirect()->back()->with('error','This Email is Already Registered With Us!!');
            }

            if($req->profileImage){
                $image = $req->profileImage;
                $userImage = rand().time().substr(str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,5).'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/user');
                $image->move($destinationPath, $userImage);
                $user->image = $userImage;
            }
            $user->name = $req->name;
            $user->email = $req->email;
            $user->number = $req->number;
            $user->state = $req->state;
            $user->city = $req->city;
            $user->locality = $req->locality;
            $user->u_type = 2;
            $user->save();

            return redirect()->back()->with('success','Profile Updated Successfully!!');
        }

        return redirect('/login');

    }

    public function changePassword(){
        if(Auth::check()){
            $id = Auth::id();
            $userImage  = User::select('image')->Where('id',$id)->where('status',1)->first();
            return view('frontend.user.change-password',compact('userImage'));
        }

        return redirect('/login');
    }

    public function updatepassword(Request $req){
        $req->validate([
            'password'=>'required',
            'retype_password'=>'required | same:password'
        ]);

        if(Auth::check()){
            $id = Auth::id();
            $user  = User::Where('id',$id)->where('status',1)->first();
            $user->password = \Hash::make($req->password);
            $user->save();
            return redirect()->back()->with('success','Password Updated Successfully!!');
        }
        return redirect('/login');
    }

    public function orderHistory(){
        if(Auth::check()){
            $id = Auth::id();
            $orders = OrderChild::where('user_id',$id)->with('product')->with('reviews')->get();
            // dd($orders);
            return view('frontend.user.order-history',compact('orders'));
        }
        return redirect('/login');
    }

    public function forgetPass(){
        if(Auth::check()){
            $id = Auth::id();
            return view('frontend.auth.forget-password');
        }
        return redirect('/login');
    }

    public function orderInvoice($id){
        $order = Order::Where('id',$id)->first();
        $childOrder = OrderChild::Where('order_id',$id)->with('product')->get();
        // dd($childOrder);
        return view('frontend.invoice',compact('order','childOrder'));
    }

    public function giveReview($id){
        if(Auth::check()){
            $userId = Auth::id();
            $order= OrderChild::Where('user_id',$userId)->where('product_id',$id)->count();
            if($order > 0){
                $review = CustomerReviews::where('product_id',$id)->where('user_id',$userId)->first();
                $productname = Product::select('product_name','id')->Where('id',$id)->first();
                return view('frontend.user.give-review',compact('productname','review'));
            }
            return redirect('/order-history');
        }
        return redirect('/login');
    }

    public function submitReview(Request $req){
        $req->validate([
            'pid'=>'required',
            'rating'=>'required',
        ],[
            'pid.required'=>'Product Name Is Required',
            'rating.required'=>'Rating is Required'
        ]);

        if(Auth::check()){
            $userId = Auth::id();
            $reviews = CustomerReviews::Where('user_id',$userId)->where('product_id',$req->pid)->first();
            if($reviews){
                $reviews->product_id = $req->pid;
                $reviews->user_id = $userId;
                $reviews->description = $req->description;
                $reviews->rating = $req->rating;
                $reviews->approval = 0;
                $reviews->save();

                return redirect('/order-history')->with('success','Review Updated Successfully');
            }else{
                $review = new CustomerReviews;
                $review->product_id = $req->pid;
                $review->user_id = $userId;
                $review->description = $req->description;
                $review->rating = $req->rating;
                $review->approval = 0;
                $review->save();

                return redirect('/order-history')->with('success','Review Added Successfully');
            }
        }

        return redirect('/login');
    }
}
