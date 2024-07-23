<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Pages;
use App\Models\Faq;

class FrontEndController extends Controller
{
    public function index(){
        $category = Category::WHERE('status',1)->withcount('worksheet')->get();
        $featuredProduct = Product::WHERE('status','=',1)->where('feature_product','=',1)->orderBy('id','DESC')->paginate(7);
        // dd($category);
        return view('frontend.index',compact('category','featuredProduct'));
    }

    public function searchIndex(Request $req){
        $totalWorksheet = Product::WHERE('status','=',1)->count();
        $category = Category::WHERE('status',1)->withcount('worksheet')->get();
        if($req->worksheet && $req->category){
            $products = Product::WHERE('status',1)
            ->where('product_name','Like',"%".$req->worksheet."%")->with('product_seo')
            ->WHERE('category_id',$req->category)
            ->paginate('16');
        }

        if($req->worksheet && !($req->category)){
            $products = Product::WHERE('status',1)
            ->where('product_name','Like',"%".$req->worksheet."%")->with('product_seo')
            ->paginate('16');
        }

        if(!($req->worksheet) && ($req->category)){
            $products = Product::WHERE('status',1)
            ->WHERE('category_id',$req->category)->with('product_seo')
            ->paginate('16');
        }
        
        return view('frontend.worksheet',compact('products','category','totalWorksheet')); 
    }

    public function aboutUs(){
        return view('frontend.about');
    }

    public function dynamicPage($slug){
        $pages = Pages::Where('slug',$slug)->first();
        return view('frontend.dynamicPage',compact('pages'));
    }

    public function faqShow(){
        $faqs = Faq::where('status',1)->orderBy('id','DESC')->get();
        return view('frontend.faq',compact('faqs'));
    }
}
