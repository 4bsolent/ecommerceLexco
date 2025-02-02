<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function newProduct(int $categoryId, string $name, string $description, int $price, int $stock){
        return Product::create([
            'id_category' => $categoryId,
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'stock' => $stock
        ]);
    }
}
