<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class OrderChild extends Model
{
    use HasFactory;
    protected $table = "order_child";

    public function product(){
        return $this->hasOne(Product::class,'id','product_id')->where('status',1);
    }

    public function reviews(){
        $id = Auth::id();
        return $this->hasOne(CustomerReviews::class,'product_id','product_id')->where('user_id',$id);
    }
}
