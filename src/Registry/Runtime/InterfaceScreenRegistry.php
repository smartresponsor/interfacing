<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Registry\Runtime;

use App\Interfacing\CatalogInterface\Runtime\InterfaceScreenCatalogInterface;
use App\Interfacing\Contract\ValueObject\InterfaceScreenIdInterface;
use App\Interfacing\ProviderInterface\Runtime\InterfaceScreenProviderInterface;
use App\Interfacing\RegistryInterface\Runtime\InterfaceScreenRegistryInterface;

final class InterfaceScreenRegistry implements InterfaceScreenRegistryInterface, InterfaceScreenCatalogInterface
{
    /**
     * @var array<string,string>
     */
    private array $map = [];

    /**
     * @param iterable<InterfaceScreenProviderInterface> $provider
     */
    public function __construct(iterable $provider)
    {
        foreach ($provider as $p) {
            foreach ($p->map() as $screenId => $component) {
                $sid = trim($screenId);
                $cmp = trim($component);

                if ('' === $sid) {
                    throw new \InvalidArgumentException('ScreenProvider '.$p->id().' produced empty screenId.');
                }
                if ('' === $cmp) {
                    throw new \InvalidArgumentException('ScreenProvider '.$p->id().' produced empty component for '.$sid.'.');
                }
                if (isset($this->map[$sid])) {
                    throw new \InvalidArgumentException('Duplicate screenId mapping: '.$sid.' (provider '.$p->id().')');
                }

                $this->map[$sid] = $cmp;
            }
        }
    }

    public function has(InterfaceScreenIdInterface $id): bool
    {
        return isset($this->map[$id->toString()]);
    }

    public function componentName(InterfaceScreenIdInterface $id): string
    {
        $k = $id->toString();
        if (!isset($this->map[$k])) {
            throw new \InvalidArgumentException('Unknown screen id: '.$k);
        }

        return $this->map[$k];
    }

    /**
     * @return array|string[]
     */
    public function idList(): array
    {
        $id = array_keys($this->map);
        sort($id);

        return $id;
    }
}
