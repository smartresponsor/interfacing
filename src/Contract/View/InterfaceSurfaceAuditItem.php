<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

final readonly class InterfaceSurfaceAuditItem
{
    public function __construct(
        private string $id,
        private string $area,
        private string $label,
        private string $status,
        private string $url,
        private string $note,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function area(): string
    {
        return $this->area;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function note(): string
    {
        return $this->note;
    }
}
