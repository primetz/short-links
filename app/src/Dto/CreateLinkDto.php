<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as CustomAssert;

class CreateLinkDto extends ApiDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Url(message: 'The url {{ value }} is not a valid url')]
        #[CustomAssert\DnsRecord]
        public readonly string $url,

        #[Assert\DateTime(format: 'Y-m-d', message: 'The {{ value }} must be in the format "Y-m-d"')]
        public ?string $deletedAt = null,
    )
    {
    }
}
