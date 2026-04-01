<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\WidgetIdInterface;

/**
 *
 */

/**
 *
 */
interface WidgetRegistryInterface
{
    /**
     * @param \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\WidgetIdInterface $id
     * @return bool
     */
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
