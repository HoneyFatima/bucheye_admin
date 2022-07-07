<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductAttribute extends Model
{
    use HasFactory,SoftDeletes;
    function attributeDetails(){
        return $this->hasMany(ProductAttributeDetail::class,'product_attribute_id','id')->orderBy('order_no');
    }
}
