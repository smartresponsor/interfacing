<?php

declare(strict_types=1);

namespace App\Interfacing\Namer\Security;

use App\Interfacing\Contract\Security\InterfacePermission;
use App\Interfacing\NamerInterface\Security\InterfacePermissionNamerInterface;

final class InterfacePermissionNamer implements InterfacePermissionNamerInterface
{
    public function normalizeId(string $raw): string
    {
        $raw = trim($raw);
        if ('' === $raw) {
            throw new \InvalidArgumentException('Id must not be empty.');
        }

        $raw = strtolower($raw);
        $raw = preg_replace('/[^a-z0-9\-_.]+/i', '-', $raw) ?? $raw;
        $raw = preg_replace('/\-+/', '-', $raw) ?? $raw;
        $raw = trim($raw, '-');

        if ('' === $raw) {
            throw new \InvalidArgumentException('Id normalization produced empty value.');
        }

        return $raw;
    }

    public function screen(string $screenId): string
    {
        return InterfacePermission::PrefixScreen.$this->normalizeId($screenId);
    }

    public function action(string $screenId, string $actionId): string
    {
        return InterfacePermission::PrefixAction.$this->normalizeId($screenId).'.'.$this->normalizeId($actionId);
    }
}
