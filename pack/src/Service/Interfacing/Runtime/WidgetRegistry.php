<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace App\Service\Interfacing\Runtime;

use App\Domain\Interfacing\Model\WidgetId;
use App\DomainInterface\Interfacing\Model\WidgetIdInterface;
use App\ServiceInterface\Interfacing\Runtime\WidgetRegistryInterface;

final class WidgetRegistry implements WidgetRegistryInterface
{
    /** @var array<string, array{class:string, option:array<string,mixed>}> */
    private array $definitionById = [];

    public function __construct()
    {
        $this->definitionById = [];
    }

    public function register(WidgetIdInterface $id, string $class, array $option = []): void
    {
        $this->definitionById[$id->toString()] = [
            'class' => $class,
            'option' => $option,
        ];
    }

    public function has(WidgetIdInterface $id): bool
    {
        return isset($this->definitionById[$id->toString()]);
    }

    public function get(WidgetIdInterface $id): array
    {
        $key = $id->toString();
        if (!isset($this->definitionById[$key])) {
            throw new \RuntimeException('Unknown widgetId: ' . $key);
        }
        return $this->definitionById[$key];
    }

    public function allId(): array
    {
        return array_map(static fn(string $id) => WidgetId::fromString($id), array_keys($this->definitionById));
    }
}
