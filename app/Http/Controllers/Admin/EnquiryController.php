<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enquiry;
// use App\Models\Product;


class EnquiryController extends Controller
{
    public function allEnquiry(){
        $enquiry = Enquiry::WHERE('status',1)->orderBy('id','DESC')->paginate('10');
        return view('admin.enquiry.all-enquiry',compact('enquiry'));
    }

    public function deleteEnquiry(){
        $id = $this->memberObj['id'];
        $enq = Enquiry::where('id',$id)->first();
        $enq->delete();
        return redirect('/admin/all-enquiry')->with('success','Enquiry Removed Successfully...');
    }

    public function searchEnquiry(Request $req){
        $enquiry = Enquiry::WHERE('status',1)->whereBetween('created_at', [$req->from, $req->to])->orderBy('id','DESC')->get();
        return view('admin.enquiry.all-enquiry',compact('enquiry'));
    }
}

