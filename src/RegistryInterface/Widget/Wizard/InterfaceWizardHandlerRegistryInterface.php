<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\RegistryInterface\Widget\Wizard;

use App\Interfacing\HandlerInterface\Widget\Wizard\InterfaceWizardHandlerInterface;

interface InterfaceWizardHandlerRegistryInterface
{
    public function has(string $id): bool;

    public function get(string $id): InterfaceWizardHandlerInterface;

    /** @return list<string> */
    public function idList(): array;
}
