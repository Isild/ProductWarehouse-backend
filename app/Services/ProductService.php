<?php

namespace App\Services;

use Illuminate\Auth\AuthenticationException;
use App\Models\ProductModel;
use App\Exceptions\ModelNotCreatedExcepiton;
use App\Exceptions\ModelNotDeletedExcepiton;
use App\Exceptions\ModelNotUpdatedExcepiton;
use Illuminate\Pagination\LengthAwarePaginator;


class ProductService
{
    private ProductModel $productModel;

    public function __construct(ProductModel $productModel)
    {
        $this->productModel = $productModel;
    }

    public function findAll(array $filters): LengthAwarePaginator
    {
        $query = $this->productModel;

        if(isset($filters['name'])){
            $query->where('name', '=', $filters['name']);
        }
        if(isset($filters['created_at'])){
            $query->where('created_at', 'LIKE', $filters['created_at']);
        }


        if(isset($filters['sort_by']) && is_array($filters['sort_by'])){
            foreach($filters['sort_by'] as $sortBy) {
                $query->orderBy($sortBy ?? 'name', $filters['order_by'] ?? 'asc');
            }
        } else {
            $query->orderBy($filters['sort_by'] ?? 'name', $filters['order_by'] ?? 'asc');

        }

        return $query->paginate($filters['limit'] ?? 50);
    }

    public function create(array $data): ProductModel
    {
        $product = new ProductModel($data);
        $product->save();

        if(!$product) {
            throw new ModelNotCreatedExcepiton();
        }

        return $product;
    }

    public function update(array $data, ProductModel $product): bool
    {
        isset($data['name']) ? $product->name = $data['name'] : null;
        isset($data['description']) ? $product->description = $data['description'] : null;
        isset($data['salary']) ? $product->salary = $data['salary'] : null;

        $product = $product->save();

        if(!$product) {
            throw new ModelNotUpdatedExcepiton();
        }

        return $product;
    }

    public function delete(ProductModel $product): bool
    {
        $product = $product->delete();

        if(!$product) {
            throw new ModelNotDeletedExcepiton();
        }

        return $product;
    }
}
