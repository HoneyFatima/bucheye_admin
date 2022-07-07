<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'short_description',
        'long_description',
        'image',
        'total_likes',
        'status',
    ];
    public function comment(){
        return $this->hasMany(Comment ::class,'blog_id','id');
    }
    public function user_comment(){
        return $this->hasOne(Comment ::class,'blog_id','id');
    }

}
