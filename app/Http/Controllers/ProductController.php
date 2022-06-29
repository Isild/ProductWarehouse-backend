<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\ProductPostRequest;
use App\Http\Requests\Products\ProductPutRequest;
use App\Http\Requests\Products\ProductIndexRequest;
use App\Http\Requests\Products\ProductShowRequest;
use App\Http\Requests\Products\ProductDeleteRequest;
use App\Services\ProductService;
use App\Models\ProductModel;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(ProductIndexRequest $request)
    {
        $products = $this->productService->findAll($request->validated());

        return response([
            'code' => 200,
            'data' => $products
        ], 200);
    }

    public function show(ProductShowRequest $request, ProductModel $product)
    {
        // $product = $product->load('');

        return response($product, 200);
    }

    public function store(ProductPostRequest $request)
    {
        $product = $this->productService->create($request->validated());

        return response($product, 201);
    }

    public function update(ProductPutRequest $request, ProductModel $product)
    {
        $product = $this->productService->update($request->validated(), $product);

        return response(null, 204);
    }

    public function destroy(ProductDeleteRequest $request, ProductModel $product)
    {
        $this->productService->delete($product);

        return response(null, 204);
    }

}
