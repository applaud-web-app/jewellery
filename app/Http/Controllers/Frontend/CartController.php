<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;


class CartController extends Controller
{
    public function setcartCookie(Request $req){
        if(Cookie::get('cart')){
            $cookieArr = json_decode(Cookie::get('cart'),true);

            if(in_array($req->input('id'),$cookieArr)){
                // Already Have This Item
            }else{
                array_push($cookieArr,$req->input('id'));
                $response = Cookie::queue('cart', json_encode($cookieArr), 60*24*7);
            }
        }else{
            $value[] = $req->input('id');
            $response = Cookie::queue('cart', json_encode($value), 60*24*7);
        }
        return response()->json([
            'status'=>1,
            'message'=>"Cart Updated Successfully"
        ]);
    }

    public function updatecart(Request $req){
        $value = Cookie::get('cart');
        if($value != null){
            $cart_items = count(json_decode($value,true));
            return response()->json([
                'status'=>1,
                'cart_items'=>$cart_items
            ]);
        }else{
            return response()->json([
                'status'=>0,
                'cart_items'=>0
            ]);
        }
    }

    public function viewcart(){

        $value = Cookie::get('cart');
        if($value != null){
            $cart_items = json_decode($value,true);
            $products = Product::select('id','product_name','discount_price','product_fetaure_img')->WHERE('status','=',1)->whereIn('id',$cart_items)->get();
            return view('frontend.cart',compact('products'));
        }

        return view('frontend.cart');

    }

    public function removeCartItem($id){
        if(Cookie::get('cart')){
            $cookieArr = json_decode(Cookie::get('cart'),true);

            if(in_array($id,$cookieArr)){
                $pos = array_search($id, $cookieArr);
                unset($cookieArr[$pos]);
                Cookie::queue('cart', json_encode($cookieArr), 60*24*7);
            }
        }
        return redirect()->back()->with('success','Cart Updated Successfully!!');
    }
}

