<?php

namespace App\Entity\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Embeddable]
#[UniqueEntity('token')]
class Token
{
    #[ORM\Column(length: 50, unique: true)]
    private string $token;

    public function __construct()
    {
        $this->token = base_convert(rand(1, 10000000), 10, 36);
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function __toString(): string
    {
        return $this->token;
    }
}
