<?php
declare(strict_types=1);

namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Security;

interface PermissionNamerInterface
{
    public function screen(string $screenId): string;

    public function action(string $screenId, string $actionId): string;

    public function normalizeId(string $raw): string;
}
