<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function product_seo(){
        return $this->hasOne(ProductSeo::class);
    }

    public function product_material(){
        return $this->hasMany(ProductMaterial::class,'product_id','id');
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'product_material', 'product_id', 'material_id')
                    ->withPivot('quantity_used'); // Include the pivot column
    }

}
