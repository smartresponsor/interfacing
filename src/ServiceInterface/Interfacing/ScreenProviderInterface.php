<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\Provider\ScreenProviderInterface as ProviderScreenProviderInterface;

/**
 * @deprecated Transitional root-level alias. Use Provider\ScreenProviderInterface for
 *             screen contribution providers; runtime screen maps belong to
 *             Runtime\ScreenProviderInterface.
 */
interface ScreenProviderInterface extends ProviderScreenProviderInterface
{
}
