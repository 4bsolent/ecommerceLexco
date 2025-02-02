<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository) {
        $this->productRepository = $productRepository;
    }

    public function createProduct($productInfo) {
        $categoryId = $productInfo['categoryId'];
        $name = $productInfo['name'];
        $description = $productInfo['description'];
        $price = $productInfo['price'];
        $stock = $productInfo['stock'];

        return $this->productRepository->newProduct($categoryId, $name, $description, $price, $stock);
    }

    public function getAllProducts () {
        $allProductsRespose = $this->productRepository->allProducts();

        $allproductsFormat = [];

        foreach ($allProductsRespose as $product) {
            $productFormat = [
                'id' => $product['id'],
                'name' => $product['name'],
                'description' => $product['description'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'category' => $product['category']['category']
            ];

            $allproductsFormat[] = $productFormat;
        }

        return $allproductsFormat;
    }
}
