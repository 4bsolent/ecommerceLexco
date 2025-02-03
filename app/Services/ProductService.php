<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Traits\JsonResponse;

class ProductService
{
    use JsonResponse;

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

    public function removeProduct(int $productId) {
        $productToBeRemoved = $this->productRepository->productById($productId);

        $this->productRepository->deleteProduct($productId);

        return $this->successResponse([
            'info' => 'El producto con ID: ' . $productToBeRemoved->id . ' fue eliminado.'
        ], 200);
    }
}
