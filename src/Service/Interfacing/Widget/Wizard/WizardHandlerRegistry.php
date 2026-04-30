<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Service\Interfacing\Widget\Wizard;

use App\Interfacing\ServiceInterface\Interfacing\Widget\Wizard\WizardHandlerInterface;
use App\Interfacing\ServiceInterface\Interfacing\Widget\Wizard\WizardHandlerRegistryInterface;

/**
 *
 */

/**
 *
 */
final class WizardHandlerRegistry implements WizardHandlerRegistryInterface
{
    /** @var array<string,WizardHandlerInterface> */
    private array $map = [];

    /** @param iterable<WizardHandlerInterface> $handler */
    public function __construct(iterable $handler)
    {
        foreach ($handler as $h) {
            $this->map[$h->id()] = $h;
        }
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->map[$id]);
    }

    /**
     * @param string $id
     * @return \App\Interfacing\ServiceInterface\Interfacing\Widget\Wizard\WizardHandlerInterface
     */
    public function get(string $id): WizardHandlerInterface
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
