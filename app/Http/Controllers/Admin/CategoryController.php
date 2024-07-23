<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use stdClass,Common;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::select('cat_name','id','status','primary_img','parent_id')->with('child_category:id,primary_img,cat_name,status,s_parent_id')->where('parent_id',0)->withCount('worksheet')->whereIn('status',[1,2]);  
        $searchStr = !empty($request->q) ? $request->q : '';
        if(!empty($request->q)){
            $categories->where(function($q) use ($searchStr){
                $q->where('cat_name','like','%'.$searchStr.'%');
                $q->orWhereHas('child_category', function($query) use($searchStr){
                    $query->where('cat_name','like','%'.$searchStr.'%');
                });
            });
        }
        $categories = $categories->paginate(50);
        $i=1;
        if(!empty($request->page) && $request->page > 1){
            $i = ((int)$request->page - 1) * 100 + 1;
        }
        return view('admin.category.all-categories',compact('categories','i','searchStr'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select('cat_name','id')->where('status',1)->get();
        return view('admin.category.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name'=>'required',
            'meta_title'=>'required',
            'keyword'=>'required',
            'description'=>'required',
        ]);
        $path = public_path('uploads/category_image');
        if(!\File::isDirectory($path)){
            \File::makeDirectory($path, 0777, true);
        }
        $categoryImage = null;
        $featureImage = null;
        if ($request->hasFile('category_image')) {
            $image = $request->file('category_image');
            $categoryImage = time().substr(str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,5).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/category_image');
            $image->move($destinationPath, $categoryImage);
        }
        if ($request->hasFile('feature_img')) {
            $image = $request->file('feature_img');
            $featureImage = "f".time().substr(str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,5).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/category_image');
            $image->move($destinationPath, $featureImage);
        }

        $slug = \Str::slug($request->category_name);
        $categoryCnt = Category::where('slug',$slug)->count();
        if($categoryCnt){
            $slug = $slug.'-'.($categoryCnt + 1);
        }

        // get parent super parent id
        $sparentId = 0;
        if(!empty($request->is_child_category) && $request->parent_id > 0){
            $sparentId = Common::getParentId($request->parent_id);
            if($sparentId < 1 || $sparentId==$request->parent_id){
                $sparentId = 0;
            }
        }
        $category = new Category();
        $category->cat_name = $request->category_name;
        $category->slug = $slug;
        $category->primary_img = $categoryImage;
        $category->parent_id = (!empty($request->is_child_category) && $request->parent_id > 0) ? $request->parent_id : 0;
        $category->meta_title = $request->meta_title;
        $category->meta_keywords = $request->keyword;
        $category->meta_description = $request->description;
        $category->feature_img = $featureImage;
        $category->s_parent_id = $sparentId;
        $category->status = $request->status;
        $category->save();

        \Cache::forget('site-categories');
        \Cache::forget('category-count');
        return redirect('admin/categories')->with('success','New Category Added Successfully...');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function removeCategory(){
        $id = $this->memberObj['id'];
        Category::where('id',$id)->update(['status'=>3]);
        Category::where('parent_id',$id)->update(['status'=>3]);
        \Cache::forget('site-categories');
        \Cache::forget('category-count');
        return redirect('admin/categories')->with('success','Category Removed Successfully...');
    }

    public function editCategory(){
        $id = $this->memberObj['id'];
        $catData = Category::findorfail($id);
        $categories = Category::select('cat_name','id')->where('status',1)->get();
        $inputObj = new stdClass();
        $inputObj->params = 'id='.$id;
        $inputObj->url = url('admin/update-category');
        $updateLink = Common::encryptLink($inputObj);
        return view('admin.category.edit-category',compact('catData','categories','updateLink'));
    }

    public function updateCategory(Request $request){
        $id = $this->memberObj['id'];
        $catData = Category::findorfail($id);

        if ($request->hasFile('category_image')) {
            $image = $request->file('category_image');
            $categoryImage = time().substr(str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,5).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/category_image');
            $image->move($destinationPath, $categoryImage);
            $catData->primary_img = $categoryImage;
        }

        if ($request->hasFile('feature_img')) {
            $image = $request->file('feature_img');
            $featureImage = "f".time().substr(str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,5).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/category_image');
            $image->move($destinationPath, $featureImage);
            $catData->feature_img = $featureImage;
        }

         // get parent super parent id
         $sparentId = 0;
         if(!empty($request->is_child_category) && $request->parent_id > 0){
             $sparentId = Common::getParentId($request->parent_id);
             if($sparentId < 1 || $sparentId==$request->parent_id){
                 $sparentId = 0;
             }
         }

        $catData->cat_name = $request->category_name;
        $catData->parent_id = (!empty($request->is_child_category) && $request->parent_id > 0) ? $request->parent_id : 0;
        $catData->meta_title = $request->meta_title;
        $catData->s_parent_id = $sparentId;
        $catData->meta_keywords = $request->keyword;
        $catData->meta_description = $request->description;
        $catData->status = $request->status;
        $catData->save();
        \Cache::forget('site-categories');
        \Cache::forget('category-count');
        return redirect('admin/categories')->with('success','Category Updated Successfully...');
    }

}
