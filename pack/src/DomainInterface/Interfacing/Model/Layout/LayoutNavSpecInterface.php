<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace App\DomainInterface\Interfacing\Model\Layout;

interface LayoutNavSpecInterface
{
    /**
     * @return array<string, list<array{slug:string,title:string,active:bool}>>
     */
    public function getGroupItem(): array;

    public function getActiveSlug(): string;
}
