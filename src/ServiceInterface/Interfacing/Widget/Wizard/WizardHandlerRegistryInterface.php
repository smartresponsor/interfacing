<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\ServiceInterface\Interfacing\Widget\Wizard;

/**
 *
 */

/**
 *
 */
interface WizardHandlerRegistryInterface
{
    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool;

    /**
     * @param string $id
     * @return \App\ServiceInterface\Interfacing\Widget\Wizard\WizardHandlerInterface
     */
    public function get(string $id): WizardHandlerInterface;

    /** @return list<string> */
    public function idList(): array;
}
