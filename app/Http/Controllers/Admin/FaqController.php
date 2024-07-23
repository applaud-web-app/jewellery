<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use stdClass,Common;

class FaqController extends Controller
{
    public function allFaq(){
        $faqs = Faq::where('status',1)->orderBy('id','DESC')->paginate(15);
        return view('admin.faq.all-faq',compact('faqs'));
    }

    public function addFaq(){
        return view('admin.faq.add-faq');
    }

    public function insertFaq(Request $req){
        $req->validate([
            'question'=>'required',
            'answer'=>'required',
        ]);

        $checkPage = Faq::Where('question',$req->question)->count();
        if($checkPage > 0){
            return redirect()->back()->with('error','This Question Is Already Exist...');
        }

        $page = new Faq;
        $page->question = $req->question;
        $page->answer = $req->answer;
        $page->save();

        return redirect('/admin/all-faq')->with('success','FAQ Added Successfully...');
    }

    public function removeFaq(Request $req){
        $id = $this->memberObj['id'];
        Faq::where('id',$id)->update(['status'=>0]);
        return redirect('admin/all-faq')->with('success','FAQ Removed Successfully...');
    }

    public function editFaq(Request $req){
        $id = $this->memberObj['id'];
        $faq = Faq::WHERE('status',1)->WHERE('id',$id)->first();
        $inputObj = new stdClass();
        $inputObj->params= 'id='.$id;
        $inputObj->url = url('admin/update-faq');
        $updateLink = Common::encryptLink($inputObj);   
        // dd($blogs);
        return view('admin.faq.edit-faq',compact('faq','updateLink'));
    }

    public function updateFaq(Request $req){
        $id = $this->memberObj['id'];

        $req->validate([
            'question'=>'required',
            'answer'=>'required',
        ]);

        $checkPage = Faq::Where('question',$req->question)->where('id')->count();
        if($checkPage > 0){
            return redirect()->back()->with('error','This Question Is Already Exist...');
        }

        $faq = Faq::Where('id',$id)->first();
        $faq->question = $req->question;
        $faq->answer = $req->answer;
        $faq->save();
        return redirect('admin/all-faq')->with('success','FAQ Updated Successfully...');
    }

    public function searchFaq(Request $req){
        $faqs = Faq::WHERE('status',1)->Where('question','Like','%'.$req->q.'%')->orderBy('id','DESC')->paginate('15');
        return view('admin.faq.all-faq',compact('faqs'));
    }
}
