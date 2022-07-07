<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyAttribute extends Model
{
    use HasFactory;
    function family(){
        return $this->hasOne(ProductFamily::class,'id','product_family_id');
    }
    function attribute(){
        return $this->hasOne(ProductAttribute::class,'id','product_attribute_id');
    }
    function manyAttribute(){
        return $this->hasMany(ProductAttribute::class,'id','product_attribute_id');
    }
}
