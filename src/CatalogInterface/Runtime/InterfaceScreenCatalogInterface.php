<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\CatalogInterface\Runtime;

interface InterfaceScreenCatalogInterface
{
    /**
     * @return list<string> screenId list
     */
    public function idList(): array;
}
