<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\ServiceInterface\Interfacing\Screen;

use App\Interfacing\ServiceInterface\Interfacing\Provider\ScreenProviderInterface as ProviderScreenProviderInterface;

/**
 * @deprecated Transitional screen-bucket alias. Use Provider\ScreenProviderInterface
 *             for screen contribution providers. Screen orchestration contracts
 *             should stay under ServiceInterface\Interfacing\Screen only when they
 *             are not provider contributions.
 */
interface ScreenProviderInterface extends ProviderScreenProviderInterface
{
}
