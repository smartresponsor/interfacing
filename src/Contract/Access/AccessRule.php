<?php

declare(strict_types=1);

namespace App\Contract\Access;

final readonly class AccessRule
{
    private string $permission;

    public function __construct(
        string $permission,
        private bool $isRequired = true,
    ) {
        $permission = trim($permission);
        if ('' === $permission || strlen($permission) > 190) {
            throw new \InvalidArgumentException('Invalid permission.');
        }

        $this->permission = $permission;
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
