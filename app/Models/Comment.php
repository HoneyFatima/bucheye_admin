<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'blog_id',
        'comment',
        'is_like',
        'total_likes',
    ];
    public function users(){
        return $this->hasOne(User::class,'id','user_id');
    }
    public function blog(){
        return $this->hasOne(Blogs::class,'id','blog_id');
    }
}
