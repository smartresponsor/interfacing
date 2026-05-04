<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Service\Interfacing\Shell;

use App\Interfacing\ServiceInterface\Interfacing\Shell\AccessResolverInterface;

/**
 * Deprecated compatibility class for shell allow-all capability checks.
 *
 * New services should use AllowAllCapabilityAccessResolver.
 */
final class AllowAllAccessResolver extends AllowAllCapabilityAccessResolver implements AccessResolverInterface
{
}
