    <?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace SmartResponsor\Interfacing\Service\Interfacing\Registry;

    use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Registry\ScreenCatalogInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Registry\ScreenDescriptorInterface;

final class ScreenCatalog implements ScreenCatalogInterface
{
    /** @var array<string, ScreenDescriptorInterface> */
    private array $screen = [];

    public function add(ScreenDescriptorInterface $descriptor): void
    {
        $this->screen[$descriptor->screenId()] = $descriptor;
    }

    public function all(): array
    {
        $list = array_values($this->screen);
        usort($list, static function (ScreenDescriptorInterface $a, ScreenDescriptorInterface $b): int {
            return $a->navOrder() <=> $b->navOrder();
        });
        return $list;
    }

    public function get(string $screenId): ScreenDescriptorInterface
    {
        if (!isset($this->screen[$screenId])) {
            throw new \RuntimeException('Interfacing screen not found: ' . $screenId);
        }
        return $this->screen[$screenId];
    }
}

