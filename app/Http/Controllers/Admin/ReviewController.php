<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerReviews;
use App\Models\Product;
use Auth;
use Carbon\Carbon;

class ReviewController extends Controller
{
   public function index(){
    $reviews = CustomerReviews::with('review_user')->with('review_product')->orderBy('id','Desc')->paginate(20);
    return view('admin.reviews.all-reviews',compact('reviews'));
   }

   public function create(){
    $products = Product::select('id','product_name')->where('status',1)->get();
    return view('admin.reviews.create-reviews',compact('products'));
   }

   public function store(Request $req){

    $req->validate([
        'product_name'=>'required',
        'rating'=>'required',
        'status'=>'required'
    ]);

    $user_id = Auth::id();
    $review = new CustomerReviews;
    $review->product_id = $req->product_name;
    $review->user_id = $user_id;
    $review->rating = $req->rating;
    $review->approval = $req->status;
    $review->description = $req->description;
    $review->save();

    return redirect('/admin/all-reviews')->with('success','Review Added Successfully!!');

   }

   public function edit($id){
    $products = Product::select('id','product_name')->where('status',1)->get();
    $review = CustomerReviews::Where('id',$id)->first();
    return view('admin.reviews.edit-reviews',compact('review','products'));
   }

   public function update(Request $req){

    $req->validate([
        'product_name'=>'required',
        'rating'=>'required',
        'status'=>'required',
    ]);

    $review = CustomerReviews::Where('id',$req->id)->first();
    $review->product_id = $req->product_name;
    $review->rating = $req->rating;
    $review->approval = $req->status;
    $review->description = $req->description;
    $review->save();

    return redirect('/admin/all-reviews')->with('success','Review Updated Successfully!!');

   }


   public function destroy($id){

    $review = CustomerReviews::Where('id',$id)->first();
    $review->delete();
    return redirect()->back()->with('success','Review Deleted Successfully!!');
    
   }

   public function changeStatus($id){
    $review = CustomerReviews::Where('id',$id)->first();
    if($review->approval == 1){
        $review->approval = 0;
    }else{
        $review->approval = 1;
    }
    $review->save();
    return redirect()->back()->with('success','Review Status Updated Successfully!!');
   }

   public function filterReview(Request $req){

    $search = $req->search;
    $timePeriod = $req->timePeriod;
    $rating = $req->rating;
    $tab = $req->tab;

    $reviews = CustomerReviews::with('review_user')->with('review_product');

    if($timePeriod != null){
        if($timePeriod == 0){
            $date = \Carbon\Carbon::today()->subDays(10);
            $reviews->where('created_at','>=',$date);
        }else if($timePeriod == 1){
            $date = \Carbon\Carbon::today()->subDays(30);
            $reviews->where('created_at','>=',$date);
        }else if($timePeriod == 2){
            $date = \Carbon\Carbon::today()->subDays(60);
            $reviews->where('created_at','>=',$date);
        }else{
            $date = \Carbon\Carbon::today()->subDays(90);
            $reviews->where('created_at','>=',$date);
        }
        
    }

    if(!empty($rating) && $rating != null){
        $reviews->Where('rating',$rating);
    }

    if($tab != null){
        $reviews->Where('approval',$tab);
    }

    if(!empty($search) && $search != null){
        $product = Product::select('id')->Where('product_name','like','%'.$search.'%')->get();
        $arry = $product->toArray();
        $reviews->whereIn('product_id',$arry);
    }
    $reviews  = $reviews->get();

    return response()->json([
        'status'=>1,
        'reviews'=>$reviews
    ]);

   }

   public function bulkAction(Request $req){

    $action = $req->action;
    $ids =  json_decode($req->id);

    if($action == 2){
        if(!empty($ids) && is_array($ids)){
            $reviews = CustomerReviews::whereIn('id', $ids)->delete();
        }
        return response()->json([
            'status'=>1,
            'message'=>'Reviews Deleted Successfully!!'
        ]);
    }else{
        if(!empty($ids) && is_array($ids)){
            $reviews = CustomerReviews::whereIn('id',$ids)->update(['approval'=>$action]);
        }
        return response()->json([
            'status'=>1,
            'message'=>'Reviews Status Updated Successfully!!'
        ]);
    }
   }

}
