<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Contract\View;

final class WizardProgress
{
    public function __construct(private int $index, private int $total)
    {
        $this->index = max(0, $this->index);
        $this->total = max(1, $this->total);
        if ($this->index >= $this->total) {
            $this->index = $this->total - 1;
        }
    }

    public function index(): int
    {
        return $this->index;
    }

    public function total(): int
    {
        return $this->total;
    }

    public function isFirst(): bool
    {
        return $this->index <= 0;
    }

    public function isLast(): bool
    {
        return $this->index >= ($this->total - 1);
    }

    public function percent(): float
    {
        if ($this->total <= 1) {
            return 100.0;
        }

        return ($this->index / ($this->total - 1)) * 100.0;
    }
}
