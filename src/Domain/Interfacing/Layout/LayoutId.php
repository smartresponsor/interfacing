<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Domain\Interfacing\Layout;

use App\DomainInterface\Interfacing\Layout\LayoutIdInterface;

/**
 *
 */

/**
 *
 */
final readonly class LayoutId implements LayoutIdInterface
{
    /**
     * @param string $value
     */
    public function __construct(private string $value)
    {
        $this->assert($value);
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return void
     */
    private function assert(string $value): void
    {
        if ($value === '') {
            throw new \InvalidArgumentException('LayoutId must not be empty.');
        }
        if (!preg_match('/^[a-z0-9][a-z0-9_\-\.]*$/', $value)) {
            throw new \InvalidArgumentException('LayoutId must be url-safe.');
        }
    }
}

