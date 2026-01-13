<?php

namespace App\BFF\Shared\Services;


use App\BFF\Shared\DTOs\CategoryDTO;
use App\BFF\Shared\DTOs\ProductDTO;
use App\BFF\Shared\Filters\Product\ActiveFilter;
use App\BFF\Shared\Filters\Product\CategoryFilter;
use App\Models\Product;
use Illuminate\Pipeline\Pipeline;

class ProductService
{
    public static function getProduct(int $id): ProductDTO
    {
        $product = Product::with('category')->findOrFail($id);
        return ProductDTO::fromModel($product);
    }

    public static function getProducts()
    {
        return app(abstract: Pipeline::class)
            ->send(Product::query()->with(relations: 'category'))
            ->through([
                CategoryFilter::class,
                ActiveFilter::class,
            ])
            ->thenReturn()
            ->get()
            ->map(fn($product) => ProductDTO::fromModel($product))
            ->toArray();
    }
}

