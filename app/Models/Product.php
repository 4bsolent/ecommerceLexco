<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'id_category',
        'name',
        'description',
        'price',
        'stock'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
