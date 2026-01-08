<?php

namespace App\BFF\Shared\Filters\Product;

use Closure;

use Illuminate\Database\Eloquent\Builder;


class CategoryFilter
{
    public function handle(Builder $query, Closure $next): Builder
    {
        if (request()->has('category_id')) {
            $query->where('category_id', request('category_id'));
        }
        return $next($query);
    }
}
