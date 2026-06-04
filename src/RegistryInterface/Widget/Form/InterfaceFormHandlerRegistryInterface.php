<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\RegistryInterface\Widget\Form;

interface InterfaceFormHandlerRegistryInterface
{
    public function has(string $id): bool;

    /**
     * @return \App\Interfacing\HandlerInterface\Widget\Form\InterfaceFormHandlerInterface
     */
    public function get(string $id): InterfaceFormHandlerInterface;

    /** @return list<string> */
    public function idList(): array;
}
