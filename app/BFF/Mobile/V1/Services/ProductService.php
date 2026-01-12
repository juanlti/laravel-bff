<?php


namespace App\BFF\Mobile\V1\Services;

use App\BFF\Shared\DTOs\ProductDTO;
use App\BFF\Shared\Services\ProductService as SharedProductService;
use Illuminate\Support\Facades\Cache;


class ProductService
{

    private const CACHE_VERSION_KEY = 'mobile:products:version';

    public function __construct(
        private SharedProductService $sharedProductService
    )
    {

    }

    private function getCacheVersion(): string
    {
        return Cache::get(key: self::CACHE_VERSION_KEY, default: '1');
    }

    public function invalidateProductsCache(): void
    {

        $currentVersion = $this->getCacheVersion();
        Cache::put(key: self::CACHE_VERSION_KEY, value: (int)$currentVersion + 1);
    }

    public function getProduct(int $id): ProductDTO
    {
        //verifico si existe el ProductDTO en memoria cache, caso contrario lo crea y lo guarda en cache
        //si existe cache (informacion previamente cargada), verifico si la version de esa cache es igual a la version actual
        $version = $this->getCacheVersion();


        return Cache::remember(

            key: "mobile:product:v{$version}:product:{$id}",
            ttl: now()->addDay(),
            callback: fn() => $this->sharedProductService->getProduct($id)

        );


    }

    public function getProducts(): array
    {
        //verifico si existe el ProductDTO en memoria cache, caso contrario lo crea y lo guarda en cache
        //si existe cache (informacion previamente cargada), verifico si la version de esa cache es igual a la version actual
        $version = $this->getCacheVersion();


        return Cache::remember(

            key: "mobile:product:v{$version}:list",
            ttl: now()->addHours(value: 6),
            callback: fn() => $this->sharedProductService->getProducts()

        );

    }
}
