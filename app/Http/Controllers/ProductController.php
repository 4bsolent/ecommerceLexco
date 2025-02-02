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
}
