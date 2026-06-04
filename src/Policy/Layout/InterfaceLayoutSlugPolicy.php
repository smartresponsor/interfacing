<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Policy\Layout;

use App\Interfacing\PolicyInterface\Layout\InterfaceLayoutSlugPolicyInterface;

final class InterfaceLayoutSlugPolicy implements InterfaceLayoutSlugPolicyInterface
{
    public function assertSlug(string $slug): void
    {
        $slug = trim($slug);
        if ('' === $slug) {
            throw new \InvalidArgumentException('Slug must be non-empty.');
        }

        if (!preg_match('/^[a-z0-9](?:[a-z0-9\-]{0,47})$/', $slug)) {
            throw new \InvalidArgumentException('Slug format rejected: '.$slug);
        }

        if (str_contains($slug, '--')) {
            throw new \InvalidArgumentException('Slug must not contain double hyphen: '.$slug);
        }
    }

    public function assertGuardKey(?string $guardKey, string $slug): void
    {
        if (null === $guardKey) {
            return;
        }

        $expectedPrefix = 'interfacing.layout.'.$slug.'.';
        if (!str_starts_with($guardKey, $expectedPrefix)) {
            throw new \InvalidArgumentException('GuardKey must start with '.$expectedPrefix.' got '.$guardKey);
        }
    }
}
