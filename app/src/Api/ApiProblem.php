<?php

namespace App\Api;

class ApiProblem
{
    public const TYPE_ERROR = 'Error';

    public function __construct(
        private readonly int    $statusCode,
        private readonly string $type,
        private readonly string $title,
        private                 $extraData = [],
    )
    {
    }

    public function toArray(): array
    {
        return array_merge(
            $this->extraData,
            [
                'status' => $this->statusCode,
                'type' => $this->type,
                'title' => $this->title,
            ]
        );
    }

    public function set(string $name, mixed $value): static
    {
        $this->extraData[$name] = $value;

        return $this;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
