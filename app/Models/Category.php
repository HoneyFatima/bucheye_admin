<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Category extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['name','status','parent_id'];
    function childCategory(){
        return $this->hasOne(Category::class,'id','parent_id');
    }
    function childCategories(){
        return $this->hasMany(Category::class,'id','parent_id');
    }

    function products(){
        return $this->hasMany(CouponCategory::class,'product_id','category_id');
    }
    function child(){
        return $this->hasMany(Category::class,'parent_id','id');
    }

}
