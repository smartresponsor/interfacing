<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\ResolverInterface\Runtime;

use App\Interfacing\Contract\View\InterfaceLayoutScreenSpecInterface;

interface InterfaceScreenContextResolverInterface
{
    public function id(): string;

    public function supports(InterfaceLayoutScreenSpecInterface $spec): bool;

    /**
     * @param array<string,mixed> $context
     *
     * @return array<string,mixed>
     */
    public function resolve(InterfaceLayoutScreenSpecInterface $spec, array $context): array;
}
