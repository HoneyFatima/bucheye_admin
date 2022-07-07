<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopSellers extends Model
{
    use HasFactory;

    function users(){
        return $this->HasOne(User::class, 'id','vendor_id');
    }
}
