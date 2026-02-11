<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace App\Domain\Interfacing\Attribute;

    use Attribute;

    /**
     *
     */

    /**
     *
     */
    #[Attribute(Attribute::TARGET_CLASS)]
final readonly class AsInterfacingScreen
{
    /**
     * @param string $id
     * @param string $title
     * @param string|null $navGroup
     * @param string|null $navIcon
     * @param int $navOrder
     * @param bool $isVisible
     */
    public function __construct(
        public string  $id,
        public string  $title,
        public ?string $navGroup = null,
        public ?string $navIcon = null,
        public int     $navOrder = 0,
        public bool    $isVisible = true,
    ) {
    }
}

