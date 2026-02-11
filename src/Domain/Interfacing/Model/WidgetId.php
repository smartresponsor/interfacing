<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Domain\Interfacing\Model;

use App\DomainInterface\Interfacing\Model\WidgetIdInterface;

/**
 *
 */

/**
 *
 */
final class WidgetId implements WidgetIdInterface
{
    /**
     * @param string $value
     */
    private function __construct(private readonly string $value) {}

    /**
     * @param string $value
     * @return self
     */
    public static function fromString(string $value): self
    {
        $value = trim($value);
        if ($value === '') {
            throw new \InvalidArgumentException('WidgetId must be non-empty.');
        }

        return new self($value);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value;
    }
}
