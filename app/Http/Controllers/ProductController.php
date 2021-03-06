<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\ProductPostRequest;
use App\Http\Requests\Products\ProductPutRequest;
use App\Http\Requests\Products\ProductIndexRequest;
use App\Http\Requests\Products\ProductShowRequest;
use App\Http\Requests\Products\ProductDeleteRequest;
use App\Services\ProductService;
use App\Models\ProductModel;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(ProductIndexRequest $request): Response
    {
        $products = $this->productService->findAll($request->validated());

        return response($products, 200);
    }

    public function show(ProductShowRequest $request, ProductModel $product)
    {
        // $product = $product->load('');

        return response($product, 200);
    }

    public function store(ProductPostRequest $request): Response
    {
        $product = $this->productService->create($request->validated());

        return response($product, 201);
    }

    public function update(ProductPutRequest $request, ProductModel $product): Response
    {
        $product = $this->productService->update($request->validated(), $product);

        return response(null, 204);
    }

    public function destroy(ProductDeleteRequest $request, ProductModel $product): Response
    {
        $this->productService->delete($product);

        return response(null, 204);
    }

}
