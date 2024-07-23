<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use Auth;

class WishlistController extends Controller
{
    public function addWishlist(Request $req){
        $req->validate([
            'pid'=>'required',
        ]);

        if(Auth::check()){
            $user = Auth::id();

            $wishlist = Wishlist::Where('user_id',$user)->where('product_id',$req->pid)->first();
            if($wishlist != null){
                return response()->json([
                    'status'=>2,
                    'message'=>'Already Have This Product',
                ]);
            }else{
                $wishlist = new Wishlist;
                $wishlist->user_id = $user;
                $wishlist->product_id = $req->pid;
                $wishlist->status = 1;
                $wishlist->save();
                return response()->json([
                    'status'=>1,
                    'message'=>'Wishlist Updated Successfully!!'
                ]);
            }
        }else{
            return response()->json([
                'status'=>0,
                'message'=>'Please Login First!!'
            ]);
        }
    }

    public function viewWishlist(){
        if(Auth::check()){
            $user = Auth::id();
            $wishlist = Wishlist::Where('user_id',$user)->with('product')->orderBy('id','DESC')->get();
            return view('frontend.wishlist',compact('wishlist'));
        }
        return redirect('/login')->with('error','Please Login First!!');
    }

    public function removeWishlist($pid){
        if(Auth::check()){
            $user = Auth::id();
            $wishlist = Wishlist::Where('user_id',$user)->where('id',$pid)->delete();
            return redirect()->back()->with('success','Wishlist Updated Successfully!!');
        }
        return redirect('/login')->with('error','Please Login First!!');
    }

    public function updateWishlist(Request $req){
        if(Auth::check()){
            $user = Auth::id();
            $wishlist_items = Wishlist::Where('user_id',$user)->where('status',1)->count();
            return response()->json([
                'status'=>1,
                'wishlist_items'=>$wishlist_items
            ]);
        }else{
            return response()->json([
                'status'=>1,
                'wishlist_items'=>0
            ]);
        }
            
    }
    


}
