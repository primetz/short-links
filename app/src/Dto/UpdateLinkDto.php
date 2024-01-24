<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as CustomAssert;

class UpdateLinkDto extends ApiDto
{
    #[Assert\Url(message: 'The url {{ value }} is not a valid url')]
    #[CustomAssert\DnsRecord]
    public ?string $url = null;

    #[Assert\Regex(pattern: '/^\d+ years|months|days|hours$/', message: 'The {{ value }} is not a valid')]
    public ?string $lifetime = null;
}
