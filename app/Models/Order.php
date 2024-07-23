<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    public function customer(){
        return $this->hasOne(User::class,'id','user_id')->where('status',1);
    }

}
