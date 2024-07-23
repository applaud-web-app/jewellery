<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Blog;
use App\Models\BlogSeo;
use App\Models\BlogCategory;
use stdClass,Common;


class BlogController extends Controller
{
   public function allBlogs(){
    $blogs = Blog::WHERE('status',1)->orderBy('id','DESC')->with('blogcatgeory')->paginate('10');
    return view('admin.blog.all-blog',compact('blogs'));
   }

   public function createBlog(){
    $blogCatgeory = BlogCategory::select('id','name')->WHERE('status',1)->orderBy('id','DESC')->get();
    return view('admin.blog.create-blog',compact('blogCatgeory'));
   }

   public function storeBlog(Request $request){
    $request->validate([
        'blog_title'=>'required',
        'blog_description'=>'required',
        'blog_catgeory'=>'required'
    ]);

    $blog = new Blog;
    if ($request->hasFile('blog_image')) {
        $image = $request->file('blog_image');
        $fl = explode(".",$image->getClientOriginalName());
        $filename = $fl[0];
        $extension = $fl[1];
        $name = $filename.'-'.time().'.'.$extension;
        $destinationPath = public_path('/uploads/blog/');
        $image->move($destinationPath, $name);
        $blog->image = $name;
    }
    $blog->title = $request->blog_title;
    $blog->description = $request->blog_description;
    $blog->blogcategory_id = $request->blog_catgeory;
    $blog->save();

    $id = $blog->id;
    $blogSeo = new BlogSeo;
    $blogSeo->blog_id = $id;
    $blogSeo->meta_title = $request->meta_title;
    $blogSeo->meta_keywords = $request->keyword;
    $blogSeo->meta_description = $request->meta_description;
    $blogSeo->save();

    return redirect('admin/all-blogs')->with('success','Blog Added Successfully...');
   }

   public function uploadbloagimage(Request $request){
        $path = public_path('/uploads/blog/');
        if(!\File::isDirectory($path)){
            \File::makeDirectory($path, 0777, true);
        }
        $location = 'NA';
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $fl = explode(".",$image->getClientOriginalName());
            $filename = $fl[0];
            $extension = $fl[1];
            $name = $filename.'-'.time().'.'.$extension;
            $destinationPath = public_path('/uploads/blog/');
            $image->move($destinationPath, $name);
            $location = asset('/uploads/blog/'.$name);
        }
        return response()->json(['location'=>$location]);
    }

    public function removeBlog(){
        $id = $this->memberObj['id'];
        Blog::where('id',$id)->update(['status'=>0]);
        return redirect('admin/all-blogs')->with('success','Blog Removed Successfully...');
    }

    public function editBlog(){
        $blogCatgeory = BlogCategory::select('id','name')->WHERE('status',1)->orderBy('id','DESC')->get();
        $id = $this->memberObj['id'];
        $blogs = Blog::Where('id',$id)->with('seoDetails')->first();
        $inputObj = new stdClass();
        $inputObj->params= 'id='.$id;
        $inputObj->url = url('admin/update-blog');
        $updateLink = Common::encryptLink($inputObj);   
        // dd($blogs);
        return view('admin.blog.edit-blog',compact('blogs','blogCatgeory','updateLink'));
    }

    public function updateBlog(Request $req){
        $id = $this->memberObj['id'];
        $blog = Blog::Where('id',$id)->with('seoDetails')->first();
        if ($req->hasFile('blog_image')) {
            $image = $req->file('blog_image');
            $fl = explode(".",$image->getClientOriginalName());
            $filename = $fl[0];
            $extension = $fl[1];
            $name = $filename.'-'.time().'.'.$extension;
            $destinationPath = public_path('/uploads/blog/');
            $image->move($destinationPath, $name);
            $blog->image = $name;
        }
        $blog->title = $req->blog_title;
        $blog->description = $req->blog_description;
        $blog->blogcategory_id = $req->blog_catgeory;
        $blog->save();
    
        $ids = $blog->id;
        $blogSeo = BlogSeo::WHERE('id',$req->seo_id)->first();
        $blogSeo->blog_id = $ids;
        $blogSeo->meta_title = $req->meta_title;
        $blogSeo->meta_keywords = $req->keyword;
        $blogSeo->meta_description = $req->meta_description;
        $blogSeo->save();
    
        return redirect('admin/all-blogs')->with('success','Blog Updated Successfully...');
    }

    public function searchBlog(Request $req){
        $blogs = Blog::WHERE('status',1)->Where('title','Like','%'.$req->q.'%')->orderBy('id','DESC')->with('blogcatgeory')->paginate('10');
        return view('admin.blog.all-blog',compact('blogs'));
    }

    public function allBlogCategory(){
        $blogCatgeory = BlogCategory::WHERE('status',1)->orderBy('id','DESC')->withcount('totalBlog')->paginate('10');
        // dd($blogCatgeory);
        return view('admin.blog.all-blog-category',compact('blogCatgeory'));
    }

    public function createBlogCategory(){
        return view('admin.blog.create-blog-category');
    }

    public function storeBlogCategory(Request $request){
        $request->validate([
            'cat_title'=>'required'
        ],[
            'cat_title.required'=>'This Feild is Required!!' 
        ]);

        $checkBlog = BlogCategory::Where('name',$request->cat_title)->first();
        if($checkBlog){
            return redirect()->back()->with('error','This Category Name Already Exists!!');
        }

        $blogCatgeory = new BlogCategory;
        $blogCatgeory->name = $request->cat_title;
        $blogCatgeory->description = $request->cat_description;
        $blogCatgeory->save();
        return redirect('admin/add-blog-category')->with('success','Blog Catgeory Added Successfully...');
    }

    public function removeBlogCategory(Request $req){
        $id = $this->memberObj['id'];
        // dd($id);
        $blogCatgeory = BlogCategory::WHERE('id',$id)->first();
        if(!is_null($blogCatgeory)){
            $blogCatgeory->status = 0;
            $blogCatgeory->save();
            return redirect('admin/all-blog-category')->with('success','Blog Catgeory Removed Successfully...');
        }
        return redirect('admin/all-blog-category')->with('errro','Something Went Wrong...');
    }

    public function editBlogCategory(Request $req){
        $id = $this->memberObj['id'];
        $blogCatgeory = BlogCategory::WHERE('id',$id)->first();
        if(!is_null($blogCatgeory)){
            $inputObj = new stdClass();
            $inputObj->params = 'id='.$id;
            $inputObj->url = url('admin/update-blog-category');
            $updateLink = Common::encryptLink($inputObj);
            return view('admin.blog.edit-blog-catgeory',compact('blogCatgeory','updateLink'));
        }
        return redirect('admin/all-blog-category')->with('errro','Something Went Wrong...');
    }

    public function updateBlogCategory(Request $req){
        $id = $this->memberObj['id'];

        $checkBlog = BlogCategory::Where('name',$request->cat_title)->where('id','!=',$id)->first();
        if($checkBlog){
            return redirect()->back()->with('error','This Category Name Already Exists!!');
        }

        $blogCatgeory = BlogCategory::WHERE('id',$id)->first();
        $blogCatgeory->name = $req->cat_title;
        $blogCatgeory->description = $req->cat_description;
        $blogCatgeory->save();
        return redirect('admin/all-blog-category')->with('success','Blog Catgeory Updated Successfully...');
    }

    public function serachBlogCategory(Request $req){
        $blogCatgeory = BlogCategory::WHERE('status',1)->Where('name','Like','%'.$req->q.'%')->orderBy('id','DESC')->withcount('totalBlog')->paginate('10');
        return view('admin.blog.all-blog-category',compact('blogCatgeory'));
    }



}
