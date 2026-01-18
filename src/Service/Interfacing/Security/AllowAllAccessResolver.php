    <?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace SmartResponsor\Interfacing\Service\Interfacing\Security;

    use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Security\AccessResolverInterface;

final class AllowAllAccessResolver implements AccessResolverInterface
{
    public function isAllowed(ScreenSpecInterface $screen): bool
    {
        return true;
    }
}

