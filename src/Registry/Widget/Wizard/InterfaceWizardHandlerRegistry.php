<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Registry\Widget\Wizard;

use App\Interfacing\HandlerInterface\Widget\Wizard\InterfaceWizardHandlerInterface;
use App\Interfacing\RegistryInterface\Widget\Wizard\InterfaceWizardHandlerRegistryInterface;

final class InterfaceWizardHandlerRegistry implements InterfaceWizardHandlerRegistryInterface
{
    /** @var array<string,InterfaceWizardHandlerInterface> */
    private array $map = [];

    /** @param iterable<InterfaceWizardHandlerInterface> $handler */
    public function __construct(iterable $handler)
    {
        foreach ($handler as $h) {
            $this->map[$h->id()] = $h;
        }
    }

    public function has(string $id): bool
    {
        return isset($this->map[$id]);
    }

    public function get(string $id): InterfaceWizardHandlerInterface
    {
        if (!isset($this->map[$id])) {
            throw new \InvalidArgumentException('Unknown wizard handler: '.$id);
        }

        return $this->map[$id];
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
