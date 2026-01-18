<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace App\ServiceInterface\Interfacing\Runtime;

use App\DomainInterface\Interfacing\Model\WidgetIdInterface;

interface WidgetRegistryInterface
{
    public function has(WidgetIdInterface $id): bool;

    /**
     * @return array{class:string, option:array<string,mixed>}
     */
    public function get(WidgetIdInterface $id): array;

    /**
     * @return list<WidgetIdInterface>
     */
    public function allId(): array;
}
