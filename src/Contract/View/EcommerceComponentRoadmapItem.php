<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

final readonly class EcommerceComponentRoadmapItem
{
    /**
     * @param list<string> $screen
     * @param list<string> $resource
     */
    public function __construct(
        private string $id,
        private string $zone,
        private string $component,
        private string $status,
        private string $primaryUrl,
        private string $ownership,
        private array $screen,
        private array $resource,
        private string $note,
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

    public function status(): string
    {
        return $this->status;
    }

    public function primaryUrl(): string
    {
        return $this->primaryUrl;
    }

    public function ownership(): string
    {
        return $this->ownership;
    }

    /** @return list<string> */
    public function screen(): array
    {
        return $this->screen;
    }

    /** @return list<string> */
    public function resource(): array
    {
        return $this->resource;
    }

    public function note(): string
    {
        return $this->note;
    }
}
