<?php

namespace App\Dto;

class ApiDto implements ApiDtoInterface
{

    public function __toString(): string
    {
        return json_encode($this);
    }
}
