<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Registry\Widget\Form;

use App\Interfacing\HandlerInterface\Widget\Form\InterfaceFormHandlerInterface;
use App\Interfacing\RegistryInterface\Widget\Form\InterfaceFormHandlerRegistryInterface;

final class InterfaceFormHandlerRegistry implements InterfaceFormHandlerRegistryInterface
{
    /** @var array<string,InterfaceFormHandlerInterface> */
    private array $map = [];

    /** @param iterable<InterfaceFormHandlerInterface> $handler */
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

    public function get(string $id): InterfaceFormHandlerInterface
    {
        if (!isset($this->map[$id])) {
            throw new \InvalidArgumentException('Unknown form handler: '.$id);
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
