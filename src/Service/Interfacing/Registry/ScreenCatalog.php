<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace App\Service\Interfacing\Registry;

    use App\ServiceInterface\Interfacing\Registry\ScreenCatalogInterface;
use App\ServiceInterface\Interfacing\Registry\ScreenDescriptorInterface;

    /**
     *
     */

    /**
     *
     */
    final class ScreenCatalog implements ScreenCatalogInterface
{
    /** @var array<string, ScreenDescriptorInterface> */
    private array $screen = [];

    /**
     * @param \App\ServiceInterface\Interfacing\Registry\ScreenDescriptorInterface $descriptor
     * @return void
     */
    public function add(ScreenDescriptorInterface $descriptor): void
    {
        $this->screen[$descriptor->screenId()] = $descriptor;
    }

    /**
     * @return array|\App\ServiceInterface\Interfacing\Registry\ScreenDescriptorInterface[]
     */
    public function all(): array
    {
        $list = array_values($this->screen);
        usort($list, static function (ScreenDescriptorInterface $a, ScreenDescriptorInterface $b): int {
            return $a->navOrder() <=> $b->navOrder();
        });
        return $list;
    }

    /**
     * @param string $screenId
     * @return \App\ServiceInterface\Interfacing\Registry\ScreenDescriptorInterface
     */
    public function get(string $screenId): ScreenDescriptorInterface
    {
        if (!isset($this->screen[$screenId])) {
            throw new \RuntimeException('Interfacing screen not found: ' . $screenId);
        }
        return $this->screen[$screenId];
    }
}

