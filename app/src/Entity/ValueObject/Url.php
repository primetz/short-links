<?php

namespace App\Entity\ValueObject;

use App\Exception\InvalidUrlException;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Embeddable]
#[UniqueEntity('url')]
class Url
{
    #[ORM\Column(length: 255, unique: true)]
    private string $url;

    /**
     * @throws InvalidUrlException
     */
    public function __construct(string $url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidUrlException(
                sprintf('%s - недействительный URL', $url)
            );
        }

        $this->url = rtrim($url, '/');
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function __toString(): string
    {
        return $this->url;
    }
}
