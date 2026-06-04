<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\RegistryInterface\Widget\Wizard;

interface InterfaceWizardHandlerRegistryInterface
{
    public function has(string $id): bool;

    /**
     * @return \App\Interfacing\HandlerInterface\Widget\Wizard\InterfaceWizardHandlerInterface
     */
    public function get(string $id): InterfaceWizardHandlerInterface;

    /** @return list<string> */
    public function idList(): array;
}
