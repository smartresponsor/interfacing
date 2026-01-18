    <?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Screen;

    use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface;

interface ScreenSpecInterface
{
    public function id(): string;

    public function title(): string;

    /** @return array<int, string> */
    public function requireRole(): array;

    public function layout(): LayoutScreenSpecInterface;

    /** @return array<string, mixed> */
    public function defaultState(): array;
}

