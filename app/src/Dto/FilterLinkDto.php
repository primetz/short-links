<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class FilterLinkDto extends ApiDto
{
    #[Assert\Type(type: 'bool', message: 'The {{ value }} must be of type {{ type }}')]
    public ?bool $deleted = null;

    #[Assert\Type(type: 'int', message: 'The {{ value }} must be of type {{ type }}')]
    public ?int $views = null;
}
