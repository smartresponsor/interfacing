<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\ServiceInterface\Interfacing\Security;

    use App\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface;

interface AccessResolverInterface
{
    public function isAllowed(ScreenSpecInterface $screen): bool;
}

