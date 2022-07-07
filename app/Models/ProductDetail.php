<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    function attribute(){
        return $this->hasOne(ProductAttribute::class,'id','product_attribute_id');
    }
}
