<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pages;
use stdClass,Common;

class DynamicPagesController extends Controller
{
    public function allPages(){
        $pages = Pages::WHERE('status',1)->orderBy('id','DESC')->paginate(15);
        return view('admin.dynamic_pages.all-pages',compact('pages'));
    }

    public function addPages(Request $req){
        return view('admin.dynamic_pages.create-page');
    }

    public function insertPage(Request $req){
        $req->validate([
            'title'=>'required',
            'description'=>'required',
        ]);

        $checkPage = Pages::Where('title',$req->title)->count();
        if($checkPage > 0){
            return redirect()->back()->with('error','This Page Is Already Exist...');
        }

        $req->slug = ($req->slug ? $req->slug : strtolower(str_replace(' ', '-',$req->title)) );

        $page = new Pages;
        $page->title = $req->title;
        $page->slug = $req->slug;
        $page->description = $req->description;
        $page->save();

        return redirect('/admin/all-pages');
    }

    public function removePage(Request $req){
        $id = $this->memberObj['id'];
        Pages::where('id',$id)->update(['status'=>0]);
        return redirect('admin/all-pages')->with('success','Page Removed Successfully...');
    }

    public function editPage(Request $req){
        $id = $this->memberObj['id'];
        $page = Pages::WHERE('status',1)->WHERE('id',$id)->first();
        $inputObj = new stdClass();
        $inputObj->params= 'id='.$id;
        $inputObj->url = url('admin/update-page');
        $updateLink = Common::encryptLink($inputObj);   
        // dd($blogs);
        return view('admin.dynamic_pages.edit-page',compact('page','updateLink'));
    }

    public function updatePage(Request $req){
        $id = $this->memberObj['id'];

        $req->validate([
            'title'=>'required',
            'description'=>'required',
        ]);

        $checkPage = Pages::Where('title',$req->title)->where('id')->count();
        if($checkPage > 0){
            return redirect()->back()->with('error','This Page Is Already Exist...');
        }

        $pages = Pages::Where('id',$id)->first();
        $req->slug = ($req->slug ? $req->slug : strtolower(str_replace(' ', '-',$req->title)) );

        $pages->title = $req->title;
        $pages->slug = $req->slug;
        $pages->description = $req->description;
        $pages->save();
    
        return redirect('admin/all-pages')->with('success','Page Updated Successfully...');
    }

    public function searchPage(Request $req){
        $searchStr = $req->q;
        $pages = Pages::WHERE('status',1)
        ->where(function($q) use($searchStr){
            $q->Where('title','Like','%'.$searchStr.'%')
            ->orWhere('slug','Like','%'.$searchStr.'%');
        })
        ->orderBy('id','DESC')->paginate('15');
        return view('admin.dynamic_pages.all-pages',compact('pages'));
    }

}
