<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\State;
use App\Models\City;
use App\Models\DiscountCoupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderChild;
use Auth;
use Session;
use Illuminate\Support\Facades\Cookie;
use ZipArchive;
class CheckoutController extends Controller
{
    public function index(){
        if(Auth::check()){
            $value = Cookie::get('cart');
            if($value != null){
                $cart_items = json_decode($value,true);
                $products = Product::select('id','product_name','discount_price','description')->WHERE('status','=',1)->whereIn('id',$cart_items)->get();
            }
            $id = Auth::id();
            $user_details = User::Where('id',$id)->first();
            $states = State::Where('country_id',101)->get();
            return view('frontend.checkout',compact('user_details','states','products'));
        }
        return redirect('/login')->with('error','Login to procced Checkout!!');
    }

    public function fetchCity(Request $req){
        $city = City::Where('state_id',$req->state)->get();
        return response()->json([
            'status'=>1,
            'citys'=>$city
        ]);   
        
    }

    public function applyCouponCode(Request $req){
        $coupon = DiscountCoupon::Where('coupon_code','=',$req->code)->where('status',1)->first();
        if($coupon != null){
            if($coupon->min_order <= $req->total){
                if($coupon->usage_type == 1){
                    $userId = Auth::id();
                    $order = Order::where('user_id',$userId)->Where('coupon_id',$coupon->id)->count();
                    if($order > 0){
                        return response()->json([
                            'status'=>0,
                            'message'=>'This Coupen is Already Used!!'
                        ]); 
                    }
                }
                return response()->json([
                    'status'=>1,
                    'coupon'=>$coupon
                ]);
            }else{
                return response()->json([
                    'status'=>0,
                    'message'=>'Minimum Order Amount Not Met. Please ensure your order is at least ₹'.$coupon->min_order
                ]);
            }
        }else{
            return response()->json([
                'status'=>0,
                'message'=>'Invalid Coupon Code'
            ]); 
        }
        
    }   

    public function calculatetotalAmount(Request $req){
        $coupon = $req->coupon;
        $value = Cookie::get('cart');
        if($value != null){
            $cart_items = json_decode($value,true);
            $products = Product::WHERE('status','=',1)->whereIn('id',$cart_items)->sum('discount_price');
        }
        $discount_amount = 0;
        if($coupon != null){
            $Usedcoupon = DiscountCoupon::select('discount_amount')->Where('coupon_code',$coupon)->where('status',1)->first();
            $discount_amount = $Usedcoupon->discount_amount;
        }
        $amount = $products-$discount_amount;
        return response()->json([
            'status'=>1,
            'amount'=>$amount
        ]);

    }

    public function get_curl_handle($razorpay_payment_id, $amount, $currency_code){
         
         $url = 'https://api.razorpay.com/v1/payments/' . $razorpay_payment_id . '/capture';
         $key_id = getenv('RAZERPAY_PUBLIC_KEY');
         $key_secret = getenv('RAZERPAY_SECRET_KEY');
         $curl = curl_init();

         curl_setopt_array($curl, [
         CURLOPT_URL => "https://api.razorpay.com/v1/payments/".$razorpay_payment_id,
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => "",
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 30,
         CURLOPT_USERPWD=>$key_id . ':' . $key_secret,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => "GET",
         ]);
 
         return $curl;
     }

    public function storePaymentDetails(Request $req){
        if(!empty($req->razorpay_payment_id) && !empty($req->merchant_order_id)){
            $razorpay_payment_id = $req->razorpay_payment_id;
            $currency_code = $req->currency_code;
            $amount = $req->merchant_total;
            $merchant_order_id = $req->merchant_order_id;
            $success = false;
            $error = '';
            try{
                $ch = $this->get_curl_handle($razorpay_payment_id, $amount, $currency_code);
                $result = curl_exec($ch);
                // dd($result);
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($result === false){
                    $success = false;
                    $error = 'Curl error: ' . curl_error($ch);
                }else{
                    $response_array = json_decode($result, true);
                    if ($http_status === 200 and isset($response_array['error']) === false){
                        $success = true;
                    }else{
                        $success = false;
                        if (!empty($response_array['error']['code'])){
                            $error = $response_array['error']['code'] . ':' . $response_array['error']['description'];
                        }else{
                            $error = 'RAZORPAY_ERROR:Invalid Response <br/>' . $result;
                        }
                    }
                }
                curl_close($ch);
            }catch(\Exception $e){
                // $e->getMessage();die();
                $success = false;
                $error = 'OPENCART_ERROR:Request to Razorpay Failed';
            }
            if ($success === true){
                $userData = [
                    'name'=>$req->name,
                    'email'=>$req->email,
                    'buyer_type'=>$req->buyer_type,
                    'number'=>$req->number,
                    'locality'=>$req->locality,
                    'state'=>$req->state,
                    'city'=>$req->city,
                    'postCode'=>$req->postal_code
                ];
                $user_id = Auth::id();
                $order = new Order;
                $order->order_id = $req->merchant_order_id;   
                $order->payment_token = $req->razorpay_payment_id;          
                $order->user_id = $user_id;   
                $order->coupon_id = $req->coupon_id;   
                $order->coupon_amount = $req->coupon_discount;   
                $order->payment = ($req->total_amount_pay)-($req->coupon_discount);
                $order->payment_type = $req->payment_type;
                $order->payment_status = 1;
                $order->order_status = 1;
                $order->user_details = json_encode($userData);
                $order->save();

                if($order->id){
                    $value = Cookie::get('cart');
                    if($value != null){
                        $cart_items = json_decode($value,true);
                        foreach ($cart_items as $pId) {
                            $orderChild = new OrderChild;
                            $orderChild->order_id = $order->id;
                            $orderChild->product_id = $pId;
                            $orderChild->user_id = $user_id;
                            $orderChild->status = 1;     
                            $orderChild->save();                  
                        }
                    }

                    Cookie::queue(Cookie::forget('cart'));
                    session()->put('orderId', $order->id);
                    return redirect('/payment-sucess')->with('success','Order Placed Successfully!!');
                }else{
                    return redirect('/payment-sucess')->with('error','An error occured.---- Contact site administrator');
                }                
            }else{
                return redirect($req->merchant_furl_id);
            }
        }else{
            echo 'An error occured. Contact site administrator, please!';
        }
       
    }

    public function razorpayFailedPayment(){
        echo '<h3>PAYMENT FAILED <a href="'.url('/').'">GO TO HOMEPAGE</a></h3>';
    }

    public function razorpaySuccessPayment(){
        return view('frontend.payment-success');
    }

    public function downloadDigitalFile(){
        $productId = $this->memberObj['id'];
        $orderId = $this->memberObj['order_id'];
        // check order valid
        $userId = Auth::id();
        $orderData = Order::where(['id'=>$orderId,'user_id'=>$userId])->first();
        if(!$orderData){
            return redirect()->back();
        } 
        $productData = Product::select('product_files')->find($productId);
        $filesArr = json_decode($productData->product_files);

        $zip = new ZipArchive;
        $zipFileName = $orderData->order_id.'.zip';

        $filesArrr = [];
        foreach($filesArr as $v){
            $path = storage_path().'/'.'app'.'/product_images/'.$v;
            if (file_exists($path)) {
                $filesArrr[] =   $path;
            }
        }
        if ($zip->open(public_path($zipFileName), ZipArchive::CREATE) === TRUE) {
            $filesToZip = $filesArrr;
            foreach ($filesToZip as $file) {
                $zip->addFile($file, basename($file));
            }
            $zip->close();
            return response()->download(public_path($zipFileName))->deleteFileAfterSend(true);
        } else {
            return "Failed to create the zip file.";
        }
    }

}
