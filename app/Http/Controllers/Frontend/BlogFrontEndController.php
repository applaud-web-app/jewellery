<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;

class BlogFrontEndController extends Controller
{
   public function viewblog(){
   $blogcategory = BlogCategory::Where('status',1)->orderBy('id','DESC')->paginate(5);
   $blogs = Blog::WHERE('status',1)->orderBy('id','DESC')->with('blogcatgeory')->paginate(10);
   //  dd($blogs);
    return view('frontend.blog',compact('blogs','blogcategory'));
   }

   public function viewBlogDetails($id){
    $blog = Blog::WHERE('status',1)->where('id',$id)->with('blogcatgeory')->first();
    $blogs = Blog::WHERE('status',1)->orderBy('id','DESC')->paginate('5');
    return view('frontend.blog-details',compact('blog','blogs'));
   }

   public function categoryBlogs($id){
      $blogcategory = BlogCategory::Where('status',1)->orderBy('id','DESC')->paginate(5);
      $blogs = Blog::WHERE('status',1)->orderBy('id','DESC')->with('blogcatgeory')->where('blogcategory_id',$id)->paginate(10);
    
      return view('frontend.blog',compact('blogs','blogcategory'));
   }

//    public function searchBlog(){
//         $blogs = Blog::WHERE('status',1)->orderBy('id','DESC')->with('blogcatgeory')->paginate('10');
//         return view('frontend.blog',compact('blogs'));
//    }
}
