<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Traits\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use JsonResponse;

    private $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    public function create(Request $request) {

        $validator = Validator::make($request->all(), [
            'categoryId' => 'required|numeric|exists:categories,id',
            'name' => 'required|string|max:180',
            'description' => 'required|string|max:255',
            'price' => 'required|integer|min:1000',
            'stock' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            $this->errorResponse($validator->errors(), 422);
        }

        $productInfo = $request->all();
        $createdProduct = $this->productService->createProduct($productInfo);

        return $this->successResponse([
            'idProduct' => $createdProduct->id,
            'name' => $createdProduct->name,
            'stock' => $createdProduct->stock
        ], 201);
    }

    public function showAllProducts() {
        $response = $this->productService->getAllProducts();

        return $this->successResponse($response, 200);
    }

    public function deleteProduct(Request $request) {
        $validator = Validator::make($request->all(), [
            'productId' => 'required|integer|min:1|exists:products,id'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        $productId = $request->productId;

        return $this->productService->removeProduct($productId);
    }

    public function updateProduct(Request $request) {
        $validator = Validator::make($request->all(), [
            'productId' => 'required|numeric|exists:categories,id',
            'categoryId' => 'nullable|numeric|exists:categories,id',
            'name' => 'nullable|string|max:180',
            'description' => 'nullable|string|max:255',
            'price' => 'nullable|integer|min:1000',
            'stock' => 'nullable|integer|min:1'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        return $request->all();
    }
 }
