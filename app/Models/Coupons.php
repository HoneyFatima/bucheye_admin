<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupons extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'user_id',
        'code',
        'min_price',
        'discount_type',
        'discount_value',
        'max_discount',
        'status',
        'expiry_date',
        'description',
        'term_condition'
    ];
    protected $dates = [ 'deleted_at' ];
    function coupon_categories(){
        return $this->hasMany(CouponCategory::class,'coupon_id','id');
    }

}
