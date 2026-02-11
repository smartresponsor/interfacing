<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Domain\Interfacing\Model\Wizard;

/**
 *
 */

/**
 *
 */
final class WizardProgress
{
    /**
     * @param int $index
     * @param int $total
     */
    public function __construct(private int $index, private int $total)
    {
        $this->index = max(0, $this->index);
        $this->total = max(1, $this->total);
        if ($this->index >= $this->total) { $this->index = $this->total - 1; }
    }

    /**
     * @return int
     */
    public function index(): int { return $this->index; }

    /**
     * @return int
     */
    public function total(): int { return $this->total; }

    /**
     * @return bool
     */
    public function isFirst(): bool { return $this->index <= 0; }

    /**
     * @return bool
     */
    public function isLast(): bool { return $this->index >= ($this->total - 1); }

    /**
     * @return float
     */
    public function percent(): float
    {
        if ($this->total <= 1) { return 100.0; }
        return ($this->index / ($this->total - 1)) * 100.0;
    }
}
