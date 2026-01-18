    <?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Registry;

    interface ScreenCatalogInterface
{
    /**
     * @return list<ScreenDescriptorInterface>
     */
    public function all(): array;

    public function get(string $screenId): ScreenDescriptorInterface;
}

