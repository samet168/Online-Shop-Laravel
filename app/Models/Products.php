<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    public function Images(){
        return $this->hasMany(ProductImage::class,'product_id');
    }

    public function Category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function Brand(){
        return $this->belongsTo(Brand::class,'brand_id','id');
    }
}
