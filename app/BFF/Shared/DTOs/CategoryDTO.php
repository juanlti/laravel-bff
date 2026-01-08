<?php

namespace App\BFF\Shared\DTOs;

use App\Models\Category;

class CategoryDTO extends DTO
{
    private function __construct(public readonly int $id, public readonly string $name,)
    {

    }

    public static function fromModel(Category $category): self
    {
        return new self(id: $category->id, name: $category->name,);
    }


}
