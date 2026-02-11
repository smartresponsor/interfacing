<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\Domain\Interfacing\Model;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\WidgetIdInterface;

/**
 *
 */

/**
 *
 */
final class WidgetId implements WidgetIdInterface
{
    private string $value;

    /**
     * @param string $value
     */
    private function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @param string $value
     * @return self
     */
    public static function fromString(string $value): self
    {
        $value = trim($value);
        if ($value === '') {
            throw new \InvalidArgumentException('WidgetId must not be empty.');
        }
        if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $value)) {
            throw new \InvalidArgumentException('WidgetId must match slug format: lowercase words separated by single hyphen.');
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

    /**
     * @param \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\WidgetIdInterface $other
     * @return bool
     */
    public function equals(WidgetIdInterface $other): bool
    {
        return $this->value === $other->toString();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
