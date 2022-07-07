<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable=['user_id'];
    function transactiondetails(){
        return $this->belongsTo(TransactionDetail::class,'id','trans_id');
    }
    function users(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
