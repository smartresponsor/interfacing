<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\PolicyInterface\Layout;

interface InterfaceLayoutSlugPolicyInterface
{
    public function assertSlug(string $slug): void;

    public function assertGuardKey(?string $guardKey, string $slug): void;
}
