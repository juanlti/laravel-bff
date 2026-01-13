<?php

namespace App\BFF\Mobile\V1\Controllers;


use App\BFF\Mobile\V1\Resources\ProductResource;
use App\BFF\Shared\DTOs\ProductDTO;
use App\BFF\Shared\Services\ProductService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController
{
    public function __construct()
    {
    }

    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection(ProductService::getProducts());
    }

    public function show(int $id): ProductResource
    {
        return new ProductResource(ProductService::getProduct($id));
    }
}
