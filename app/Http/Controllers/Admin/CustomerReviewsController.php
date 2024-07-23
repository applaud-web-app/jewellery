<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerReviews;

class CustomerReviewsController extends Controller
{
    public function showReviews(){
        $reviews = CustomerReviews::WHERE('approval',1)->orderBy('id','DESC')->with('review_user')->with('review_product')->paginte(20);
        return view('admin.customer-reviews.reviews',compact('reviews'));
    }

    public function deleteReview(Request $req){
        $id = $this->memberObj['id'];
        $review = CustomerReviews::where('id',$id)->first();
        $review->delete();
        return redirect('admin/review')->with('success','Review Deleted Successfully...');
    }
    
    public function filterReviews(){

    }
}
