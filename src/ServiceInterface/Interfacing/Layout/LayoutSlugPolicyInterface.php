<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\ServiceInterface\Interfacing\Layout;

interface LayoutSlugPolicyInterface
{
    public function assertSlug(string $slug): void;

    public function assertGuardKey(?string $guardKey, string $slug): void;
}
