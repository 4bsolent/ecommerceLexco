<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $table = 'phone';
    
    protected $fillable = [
        'id_user',
        'prefix',
        'phone'
    ];
}
