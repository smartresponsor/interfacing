    <?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Provider;

    use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface;

interface ScreenProviderInterface
{
    /** @return array<int, ScreenSpecInterface> */
    public function provide(): array;
}

