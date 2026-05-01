<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

final readonly class EcommerceComponentSummary
{
    public function __construct(
        private string $component,
        private string $zone,
        private int $total,
        private int $connected,
        private int $canonical,
        private int $planned,
    ) {
    }

    public function component(): string
    {
        return $this->component;
    }

    public function zone(): string
    {
        return $this->zone;
    }

    public function total(): int
    {
        return $this->total;
    }

    public function connected(): int
    {
        return $this->connected;
    }

    public function canonical(): int
    {
        return $this->canonical;
    }

    public function planned(): int
    {
        return $this->planned;
    }

    public function primaryStatus(): string
    {
        if ($this->connected > 0) {
            return 'connected';
        }

        if ($this->canonical > 0) {
            return 'canonical';
        }

        return 'planned';
    }
}
