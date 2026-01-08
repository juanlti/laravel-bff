<?php


namespace App\BFF\Shared\Filters\Product;

use Closure;

use Illuminate\Database\Eloquent\Builder;

class ActiveFilter
{
    public function handle(Builder $query, Closure $next): Builder
    {
        if (request()->has('is_active')) {
            // agreando condiciones a la consulta
            //obtener solo los productos que coincidan con el valor de request()->boolean('is_active')
            return $query->where('is_active', request()->boolean('is_active'));
        }
        return $next($query);
    }
}
