<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\Domain\Interfacing\Access;

/**
 *
 */

/**
 *
 */
final readonly class AccessRule
{
    /**
     * @param string $permission
     * @param bool $isRequired
     */
    public function __construct(
        private string $permission,
        private bool   $isRequired = true
    ) {
        $p = trim($this->permission);
        if ($p === '' || strlen($p) > 190) {
            throw new \InvalidArgumentException('Invalid permission.');
        }
        $this->permission = $p;
    }

    /**
     * @return string
     */
    public function permission(): string
    {
        return $this->permission;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->isRequired;
    }
}
