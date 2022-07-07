<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'about',
        'privacy_policy',
        'term_condition',
        'app_type',
    ];
}
