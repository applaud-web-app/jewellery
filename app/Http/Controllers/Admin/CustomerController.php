<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class CustomerController extends Controller
{
    public function index(Request $req){
        $customer = User::where('u_type',2)->orderBy('id','DESC');
        if(!empty($req->q)){
            $customer->where('number','like','%'.$req->q.'%');
            $customer->orwhere('email','like','%'.$req->q.'%');
            $customer->orwhere('name','like','%'.$req->q.'%');
            
        }
        $customer = $customer->paginate(20);
        return view('admin.customer.all-customer',compact('customer'));
    }

    public function edit_customer($id){
        $customer = User::Where('id',$id)->first();
        return view('admin.customer.edit-customer',compact('customer'));
    }

    public function update_customer(Request $req){

        // dd($req->all());
        $req->validate([
            'name'=>'required',
            'email'=>'required',
            'number'=>'required',
            'status'=>'required'
        ]);

        $checkuser = User::WHERE('number',$req->number)->where('id','!=',$req->cid)->count();
        if($checkuser > 0){
            return redirect()->back()->with('error','This Number is Already Registered With Us!!');
        }

        $checkuser = User::WHERE('email',$req->email)->where('id','!=',$req->cid)->count();
        if($checkuser > 0){
            return redirect()->back()->with('error','This Email is Already Registered With Us!!');
        }

        $customer = User::Where('id',$req->cid)->first();
        if($req->profile_image){
            $image = $req->profile_image;
            $userImage = rand().time().substr(str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,5).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/user');
            $image->move($destinationPath, $userImage);
            $customer->image = $userImage;
        }
        $customer->name= $req->name;
        $customer->email= $req->email;
        $customer->number= $req->number;
        $customer->status= $req->status;
        $customer->save();

        return redirect('/admin/customer')->with('success','Customer Profile Updated Successfully!!');
    }

}
