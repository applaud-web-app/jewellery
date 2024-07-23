<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enquiry;

class EnquiryFrontEndController extends Controller
{
    public function contactUs(){
        return view('frontend.contact');
    }

    public function submitEnq(Request $req){
        $req->validate([
            'fname'=>'required',
            'lname'=>'required',
            'email'=>'required',
            'number'=>'required',
            'description'=>'required'
        ]);

        $enq = new Enquiry;
        $enq->name= $req->fname.$req->lname;
        $enq->email = $req->email;
        $enq->phone= $req->number;
        $enq->description = $req->description;
        $enq->save();
        return redirect()->back()->with('success','Enquiry Submitted Successfully...');
    }
}
