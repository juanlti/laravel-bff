<?php

namespace App\BFF\Shared\DTOs;


abstract class DTO
{

    public function toArray(): array
    {
        return get_object_vars($this);
    }


}
