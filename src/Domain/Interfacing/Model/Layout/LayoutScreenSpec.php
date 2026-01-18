    <?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace SmartResponsor\Interfacing\Domain\Interfacing\Model\Layout;

    use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutBlockSpecInterface;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface;

final class LayoutScreenSpec implements LayoutScreenSpecInterface
{
    /** @param array<int, LayoutBlockSpecInterface> $block */
    public function __construct(
        private readonly array $block,
    ) {}

    public function block(): array
    {
        return $this->block;
    }
}

