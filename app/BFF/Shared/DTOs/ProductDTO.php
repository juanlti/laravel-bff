<?php

namespace App\BFF\Shared\DTOs;


use App\Models\Product;

class ProductDTO extends DTO
{

    private function __construct(
        public readonly int         $id,
        public readonly string      $name,
        public readonly string      $slug,
        public readonly string      $description,
        public readonly float       $price,
        public readonly int         $stock,
        public readonly CategoryDTO $category,)
    {

    }

    public static function fromModel(Product $product): self
    {
        return new self(
            id: $product->id,
            name: $product->name,
            slug: $product->slug,
            description: $product->description,
            price: $product->price,
            stock: $product->stock,
            category: CategoryDTO::fromModel($product->category),


        );

    }

}
