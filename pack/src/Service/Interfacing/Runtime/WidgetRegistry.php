<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\Service\Interfacing\Runtime;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\WidgetId;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\WidgetIdInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime\WidgetRegistryInterface;

/**
 *
 */

/**
 *
 */
final class WidgetRegistry implements WidgetRegistryInterface
{
    /** @var array<string, array{class:string, option:array<string,mixed>}> */
    private array $definitionById = [];

    public function __construct()
    {
        $this->definitionById = [];
    }

    /**
     * @param \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\WidgetIdInterface $id
     * @param string $class
     * @param array $option
     * @return void
     */
    public function register(WidgetIdInterface $id, string $class, array $option = []): void
    {
        $this->definitionById[$id->toString()] = [
            'class' => $class,
            'option' => $option,
        ];
    }

    /**
     * @param \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\WidgetIdInterface $id
     * @return bool
     */
    public function has(WidgetIdInterface $id): bool
    {
        return isset($this->definitionById[$id->toString()]);
    }

    /**
     * @param \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\WidgetIdInterface $id
     * @return array
     */
    public function get(WidgetIdInterface $id): array
    {
        $key = $id->toString();
        if (!isset($this->definitionById[$key])) {
            throw new \RuntimeException('Unknown widgetId: ' . $key);
        }
        return $this->definitionById[$key];
    }

    /**
     * @return array|\SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\WidgetIdInterface[]
     */
    public function allId(): array
    {
        return array_map(static fn(string $id) => WidgetId::fromString($id), array_keys($this->definitionById));
    }
}
