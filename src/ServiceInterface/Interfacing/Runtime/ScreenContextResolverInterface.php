<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\ServiceInterface\Interfacing\Runtime;

use App\Contract\View\LayoutScreenSpecInterface;

interface ScreenContextResolverInterface
{
    public function id(): string;

    public function supports(LayoutScreenSpecInterface $spec): bool;

    /**
     * @param array<string,mixed> $context
     *
     * @return array<string,mixed>
     */
    public function resolve(LayoutScreenSpecInterface $spec, array $context): array;
}
