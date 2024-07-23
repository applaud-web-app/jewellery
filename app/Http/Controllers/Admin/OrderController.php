<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderChild;

class OrderController extends Controller
{
    public function viewAllOrders(Request $request){
        $orders = Order::orderBy('id','DESC')->with('customer');
        if(!empty($request->q)){
            $orders->where('order_id','like','%'.$request->q.'%');   
        }
        $orders = $orders->paginate(20);
        return view('admin.orders.all-orders',compact('orders'));
    }

    public function viewOrderDetails($id){
        $childOrder = OrderChild::Where('order_id',$id)->with('product')->orderBy('id','DESC')->get();
        $order = Order::Where('id',$id)->first();
        return view('admin.orders.order-details',compact('childOrder','order'));
    }


}
