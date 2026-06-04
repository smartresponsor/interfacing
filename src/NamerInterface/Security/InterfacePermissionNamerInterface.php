<?php

declare(strict_types=1);

namespace App\Interfacing\NamerInterface\Security;

interface InterfacePermissionNamerInterface
{
    public function screen(string $screenId): string;

    public function action(string $screenId, string $actionId): string;

    public function normalizeId(string $raw): string;
}
