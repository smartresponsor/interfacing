    <?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace SmartResponsor\Interfacing\Domain\Interfacing\Attribute;

    use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class AsInterfacingScreen
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly ?string $navGroup = null,
        public readonly ?string $navIcon = null,
        public readonly int $navOrder = 0,
        public readonly bool $isVisible = true,
    ) {
    }
}

