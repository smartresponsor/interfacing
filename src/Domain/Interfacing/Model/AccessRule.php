<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Domain\Interfacing\Model;

/**
 *
 */

/**
 *
 */
final class AccessRule
{
    /** @var list<string> */
    private array $requireRole;

    /**
     * @param array $requireRole
     */
    private function __construct(array $requireRole)
    {
        $this->requireRole = array_values(array_unique(array_filter($requireRole, static fn($v): bool => is_string($v) && $v !== '')));
    }

    /** @param list<string> $role */
    public static function requireRole(array $role): self
    {
        return new self($role);
    }

    /** @return list<string> */
    public function requireRoleList(): array
    {
        return $this->requireRole;
    }
}
