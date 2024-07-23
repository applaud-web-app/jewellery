<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateCoupon;
use App\Models\DiscountCoupon;
use Illuminate\Http\Request;
use stdClass,Common;
class DiscountController extends Controller
{
    public function productDiscounts(Request $request){
        $str = !empty($request->str) ?  $request->str : '';
        $couponData = DiscountCoupon::orderBy('status','ASC');
        if(!empty($str)){
            $couponData->where('coupon_code','like','%'.$str.'%');
        }
        $couponData = $couponData->get();
        return view("admin.discount.product-discounts",compact('couponData','str'));
    }

    public function createCoupon(){
        return view('admin.discount.create-coupon');
    }

    public function storeCoupon(ValidateCoupon $request){

        $minOrder = 0;
        if(!empty($request->is_order_value) && $request->min_order > 0){
            $minOrder = $request->min_order;
        }
        $discountObj = new DiscountCoupon();
        $discountObj->coupon_code = $request->coupon_code;
        $discountObj->usage_type = $request->usage_type;
        $discountObj->description = $request->description;
        $discountObj->min_order = $minOrder;
        $discountObj->discount_amount = $request->discount_amount;
        $discountObj->status = 1;
        $discountObj->save();

        return redirect('admin/product-discounts')->with('success','Coupon Added Successfully...');
    }

    public function changeCouponStatus(Request $request){
        $status = $request->status==1 ? 2 : 1;
        $couponId = $this->memberObj['id'];
        DiscountCoupon::where('id',$couponId)->update(['status'=>$status]);
        return response()->json(['s'=>1,'msg'=>'success']);
    }

    public function editCoupon(){
        $id = $this->memberObj['id'];
        $couponData = DiscountCoupon::findorfail($id);
        $inputObjS = new stdClass();
        $inputObjS->params = 'id='.$id;
        $inputObjS->url = url('admin/update-coupon');
        $updateLink = Common::encryptLink($inputObjS);
        return view('admin.discount.edit-coupon',compact('couponData','updateLink'));
    }

    public function updateCoupon(ValidateCoupon $request){
        $minOrder = 0;
        $id = $this->memberObj['id'];
        if(!empty($request->is_order_value) && $request->min_order > 0){
            $minOrder = $request->min_order;
        }
        DiscountCoupon::where('id',$id)->update([
            'coupon_code' => $request->coupon_code,
            'usage_type' => $request->usage_type,
            'description' => $request->description,
            'min_order' => $minOrder,
            'discount_amount' => $request->discount_amount,
            'updated_at'=>date("Y-m-d H:i:s")
        ]);
        return redirect('admin/product-discounts')->with('success','Coupon Updated Successfully...');
    }

    public function uploadTest(Request $request){

        \File::move(public_path('assets/admin/images/pic1.jpg'), storage_path("app/test/pic1.jpg"));
        die('asdf');

        if($request->isMethod('get')){
            $filepath = storage_path("app/test/1698735376vFV8a.png");
            return view('welcome',compact('filepath'));
        }

        if($request->isMethod('post')){
            $image = $request->file('upload_file');
            $categoryImage = time().substr(str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,5).'.'.$image->getClientOriginalExtension();
            $image->storeAs('test',$categoryImage);
        }
    }

    public function previewProductImage(Request $request){
        $image = $request->image;
        $filepath = storage_path("app/product_images/".$image);
        return response()->file($filepath);
    }

}
