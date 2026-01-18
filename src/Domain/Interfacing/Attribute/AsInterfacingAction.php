<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace SmartResponsor\Interfacing\Domain\Interfacing\Attribute;

    use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class AsInterfacingAction
{
    public function __construct(
        public readonly string $screenId,
        public readonly string $id,
        public readonly string $title,
        public readonly int $order = 0,
    ) {
    }
}

