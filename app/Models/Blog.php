<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    public function blogcatgeory(){
        return $this->hasOne(BlogCategory::class,'id','blogcategory_id')->where('status',1);
    }

    public function seoDetails(){
        return $this->hasOne(BlogSeo::class,'blog_id','id')->orderBy('id','DESC');
    }
}
