<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout;

/**
 *
 */

/**
 *
 */
interface LayoutNavSpecInterface
{
    /**
     * @return array<string, list<array{slug:string,title:string,active:bool}>>
     */
    public function getGroupItem(): array;

    /**
     * @return string
     */
    public function getActiveSlug(): string;
}
