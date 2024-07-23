<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CustomerReviews;
use App\Models\Category;
use App\Models\TempPrice;

class WorkSheetFrontEndController extends Controller
{
    public function index(){
       $category = Category::WHERE('status',1)->withcount('worksheet')->get();
       $products = Product::WHERE('status','=',1)->orderBy('id','DESC')->paginate(9);
       $totalWorksheet = Product::WHERE('status','=',1)->count();
       return view('frontend.worksheet',compact('products','totalWorksheet','category')); 
    }

    public function worksheetDetails($id){
        $reviews = CustomerReviews::WHERE('product_id',$id)->where('approval',1)->orderBy('id','DESC')->with('review_user')->paginate(3);
        $product = Product::WHERE('status','=',1)->where('id',$id)->with('product_seo')->first();
        $similarProduct = Product::WHERE('status','=',1)->where('category_id',$product->category_id)->WHERE('id','!=',$product->id)->with('product_seo')->paginate(9);
        $totalReviews =  CustomerReviews::WHERE('product_id',$id)->where('approval',1)->orderBy('id','DESC')->get();
        return view('frontend.worksheet-details',compact('product','similarProduct','reviews','totalReviews')); 
    }

    public function worksheetFilter($id){
        $category = Category::WHERE('status',1)->withcount('worksheet')->get();
        $products = Product::WHERE('status','=',1)->where('category_id',$id)->with('product_seo')->paginate(9);
        $totalWorksheet = Product::WHERE('status','=',1)->where('category_id',$id)->count();
        return view('frontend.worksheet',compact('products','totalWorksheet','category')); 
    }

    public function filterWorksheet(Request $req){

        $category = json_decode($req->category);
        $price = json_decode($req->price);
        $search = $req->search;
        $sortedBy = $req->sorted;

        $products = Product::WHERE('status','=',1);

        // For Category
        if(!empty($category) && is_array($category)){
            $products->WhereIn('category_id',$category);
        }

        // For Price
        if(!empty($price) && is_array($price)){
            $products->where(function($q) use($price){
            foreach ($price as $value) {
                $parts = explode("-", $value);
                $min = $parts[0];
                $max = $parts[1];
                $q->orwhere(function($q) use($min,$max){
                    if($min == $max){
                        $q->Where('discount_price', '>' , $max);
                    }else{
                        $q->whereBetween('discount_price', [$min, $max]);
                    }
                });
            }
           });
        }

        // For Search
        if(!empty($search) && $search != null){
            $products->Where('product_name','like','%'.$search.'%');
        }

        // For Sorting
        if(!empty($sortedBy)){
            if($sortedBy == 0){
                $sort = "id";
                $move ="DESC";
            }else if($sortedBy == 1){
                $sort = "discount_price";
                $move ="ASC";
            }else if($sortedBy == 2){
                $sort = "discount_price";
                $move ="DESC";
            }else{
                $sort = "product_name";
                $move ="ASC";
            }
            $products->orderBy($sort,$move);
        }

        $products = $products->get();
        return response()->json([
            'status'=>1,
            'products'=>$products
        ]);
    }

    public function newProduct(){
        $id = $this->memberObj['id'];
        $tempPrice = TempPrice::where('id',$id)->first();
        if($tempPrice){
            $productId = json_decode($tempPrice->product_id);
            $products = Product::latest()->with('category:id,cat_name', 'materials')->whereIn('id',$productId)->get(); 
            return view('frontend.new-product',compact('products','tempPrice'));
        }
    }


    public function productDetails(){
        $temp_id = $this->memberObj['id'];
        $product_id = $this->memberObj['product_id'];
        $tempPrice = TempPrice::where('id',$temp_id)->first();
        if($tempPrice){
            $product = Product::with('category:id,cat_name', 'materials')->where('id',$product_id)->first(); 
            return view('frontend.product-details',compact('product','tempPrice'));
        }
    }

    // $reviews = CustomerReviews::WHERE('product_id',$id)->where('approval',1)->orderBy('id','DESC')->with('review_user')->paginate(3);
    //     $product = Product::WHERE('status','=',1)->where('id',$id)->with('product_seo')->first();
    //     $similarProduct = Product::WHERE('status','=',1)->where('category_id',$product->category_id)->WHERE('id','!=',$product->id)->with('product_seo')->paginate(9);
    //     $totalReviews =  CustomerReviews::WHERE('product_id',$id)->where('approval',1)->orderBy('id','DESC')->get();
    //     return view('frontend.worksheet-details',compact('product','similarProduct','reviews','totalReviews')); 
    
}
