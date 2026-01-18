<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\Service\Interfacing\Widget\Form;

use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Widget\Form\FormHandlerInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Widget\Form\FormHandlerRegistryInterface;

final class FormHandlerRegistry implements FormHandlerRegistryInterface
{
    /** @var array<string,FormHandlerInterface> */
    private array $map = [];

    /** @param iterable<FormHandlerInterface> $handler */
    public function __construct(iterable $handler)
    {
        foreach ($handler as $h) {
            $this->map[$h->id()] = $h;
        }
    }

    public function has(string $id): bool { return isset($this->map[$id]); }

    public function get(string $id): FormHandlerInterface
    {
        if (!isset($this->map[$id])) {
            throw new \InvalidArgumentException('Unknown form handler: '.$id);
        }
        return $this->map[$id];
    }

    public function idList(): array
    {
        $id = array_keys($this->map);
        sort($id);
        return $id;
    }
}
