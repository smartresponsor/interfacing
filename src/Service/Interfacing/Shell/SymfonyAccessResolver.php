<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Service\Interfacing\Shell;

use App\Interfacing\ServiceInterface\Interfacing\Shell\AccessResolverInterface;

/**
 * Deprecated compatibility class for shell capability access checks.
 *
 * New services should use SymfonyCapabilityAccessResolver.
 */
final class SymfonyAccessResolver extends SymfonyCapabilityAccessResolver implements AccessResolverInterface
{
}
