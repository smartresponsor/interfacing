<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\Service\Interfacing\Shell;

use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Shell\AccessResolverInterface;

final class AllowAllAccessResolver implements AccessResolverInterface
{
    public function allow(string $capability, array $context = []): bool
    {
        return true;
    }
}
