<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

final readonly class EcommerceScreenEntry
{
    public function __construct(
        private string $id,
        private string $zone,
        private string $component,
        private string $label,
        private string $operation,
        private string $url,
        private string $status,
        private string $kind = 'crud',
        private ?string $note = null,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function zone(): string
    {
        return $this->zone;
    }

    public function component(): string
    {
        return $this->component;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function operation(): string
    {
        return $this->operation;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function kind(): string
    {
        return $this->kind;
    }

    public function note(): ?string
    {
        return $this->note;
    }
}
