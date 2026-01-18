<?php
declare(strict_types=1);

namespace SmartResponsor\Interfacing\Service\Interfacing\Security;

use SmartResponsor\Interfacing\Domain\Interfacing\Runtime\InterfacingPermission;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Security\PermissionNamerInterface;

final class InterfacingPermissionNamer implements PermissionNamerInterface
{
    public function normalizeId(string $raw): string
    {
        $raw = trim($raw);
        if ($raw === '') {
            throw new \InvalidArgumentException('Id must not be empty.');
        }

        $raw = strtolower($raw);
        $raw = preg_replace('/[^a-z0-9\-_.]+/i', '-', $raw) ?? $raw;
        $raw = preg_replace('/\-+/', '-', $raw) ?? $raw;
        $raw = trim($raw, '-');

        if ($raw === '') {
            throw new \InvalidArgumentException('Id normalization produced empty value.');
        }

        return $raw;
    }

    public function screen(string $screenId): string
    {
        return InterfacingPermission::PrefixScreen . $this->normalizeId($screenId);
    }

    public function action(string $screenId, string $actionId): string
    {
        return InterfacingPermission::PrefixAction . $this->normalizeId($screenId) . '.' . $this->normalizeId($actionId);
    }
}
