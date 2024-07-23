<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;

    public function totalBlog(){
        return $this->hasmany(Blog::class,'blogcategory_id','id')->where('status',1);
    }
}
