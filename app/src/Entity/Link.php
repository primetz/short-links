<?php

namespace App\Entity;

use App\Repository\LinkRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: LinkRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Link
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[Groups(['read'])]
    private ?string $token = null;

    #[ORM\Column(type: Types::TEXT, length: 65535)]
    #[Groups(['read'])]
    private ?string $url = null;

    #[ORM\Column(type: Types::BIGINT, nullable: false, options: ['default' => 0])]
    #[Groups(['read'])]
    private string $views = '0';

    #[ORM\Column(nullable: true)]
    #[Groups(['read'])]
    private ?\DateTimeImmutable $deletedAt = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    #[ORM\PostLoad]
    #[ORM\PostPersist]
    public function setToken(): static
    {
        $this->token = $this->id->toBase58();

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getViews(): string
    {
        return $this->views;
    }

    public function setViews(string $views): static
    {
        $this->views = $views;

        return $this;
    }

    public function incrementViews(): static
    {
        $this->views++;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function setLifetime(string $lifetime): static
    {
        $this->deletedAt = new \DateTimeImmutable('+' . $lifetime);

        return $this;
    }
}
