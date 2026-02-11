<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\Domain\Interfacing\Access;

final class AccessRule
{
    public function __construct(
        private readonly string $permission,
        private readonly bool $isRequired = true
    ) {
        $p = trim($this->permission);
        if ($p === '' || strlen($p) > 190) {
            throw new \InvalidArgumentException('Invalid permission.');
        }
        $this->permission = $p;
    }

    public function permission(): string
    {
        return $this->permission;
    }

    public function isRequired(): bool
    {
        return $this->isRequired;
    }
}
