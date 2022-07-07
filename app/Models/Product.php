<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model
{
    use HasFactory,SoftDeletes;
    function category(){
        return $this->hasOne(Category::class,'id','category_id')->withTrashed();;
    }
    function sub_category(){
        return $this->hasOne(Category::class,'id','category_id')->withTrashed();;
    }
    function sub_sub_category(){
        return $this->hasOne(Category::class,'id','category_id')->withTrashed();;
    }
    function family(){
        return $this->hasOne(ProductFamily::class,'id','family_id')->withTrashed();;
    }
    function product_details(){
        return $this->hasMany(ProductDetail::class,'product_id','id');
    }
    function images(){
        return $this->hasMany(ProductImage::class,'product_id','id');
    }
    function videos(){
        return $this->hasMany(ProductVideo::class,'product_id','id');
    }
    function user(){
        return $this->hasOne(User::class,'id','user_id')->withTrashed();;
    }
    function unit_types(){
        return $this->hasOne(UnitType::class,'id','unit_type')->withTrashed();;
    }
    function ratings(){
        return $this->hasMany(ProductRating::class,'product_id','id');
    }

    function user_rating(){
        return $this->hasOne(ProductRating::class,'product_id','id');
    }

    function order_details(){
        return $this->hasOne(OrderDetails::class,'product_id','id');
    }
}
