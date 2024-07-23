<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $table = 'materials';

    public function product_materials()
    {
        return $this->hasMany(ProductMaterial::class, 'material_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_material', 'material_id', 'product_id')
                    ->withPivot('quantity_used'); // Include the pivot column
    }

}
