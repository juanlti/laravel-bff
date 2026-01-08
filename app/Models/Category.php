<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active'
    ];


    // 1 a N
    public function products():HasMany{
        return $this->hasMany(Product::class);
    }
}
