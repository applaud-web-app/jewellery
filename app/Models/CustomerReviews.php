<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerReviews extends Model
{
    use HasFactory;
    protected $table = 'customer_reviews';

    public function review_user(){
        return $this->hasOne(User::class,'id','user_id')->where('status',1);
    }

    public function review_product(){
        return $this->hasOne(Product::class,'id','product_id')->where('status',1);
    }
}
