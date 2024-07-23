<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function child_category(){
        return $this->hasMany(Category::class,'s_parent_id','id')->whereIn('status',[1,2]);
    }

    public function worksheet(){
        return $this->hasmany(Product::class,'category_id','id')->where('status',1);
    }
}
