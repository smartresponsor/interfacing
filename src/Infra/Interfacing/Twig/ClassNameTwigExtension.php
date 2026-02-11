<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Infra\Interfacing\Twig;

use App\InfraInterface\Interfacing\Twig\ClassNameTwigExtensionInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class ClassNameTwigExtension extends AbstractExtension implements ClassNameTwigExtensionInterface
{
    public function getFilters(): array
    {
        return [new TwigFilter('class_name', [$this, 'className'])];
    }

    public function className(object $obj): string
    {
        return $obj::class;
    }
}

