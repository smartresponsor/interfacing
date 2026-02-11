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
final readonly class AsInterfacingAction
{
    /**
     * @param string $screenId
     * @param string $id
     * @param string $title
     * @param int $order
     */
    public function __construct(
        public string $screenId,
        public string $id,
        public string $title,
        public int    $order = 0,
    ) {
    }
}

