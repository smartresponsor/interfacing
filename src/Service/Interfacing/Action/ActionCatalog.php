<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\Service\Interfacing\Action;

use SmartResponsor\DomainInterface\Interfacing\Action\ActionEndpointInterface;
use SmartResponsor\DomainInterface\Interfacing\Action\ActionIdInterface;
use SmartResponsor\ServiceInterface\Interfacing\Action\ActionCatalogInterface;
use SmartResponsor\ServiceInterface\Interfacing\Action\ActionProviderInterface;

final class ActionCatalog implements ActionCatalogInterface
{
    /** @var array<string, ActionEndpointInterface> */
    private array $map = [];

    /** @param iterable<ActionProviderInterface> $provider */
    public function __construct(iterable $provider)
    {
        foreach ($provider as $item) {
            foreach ($item->provide() as $endpoint) {
                $key = $endpoint->id()->value();
                if (isset($this->map[$key])) {
                    throw new \RuntimeException('Duplicate action id: ' . $key);
                }
                $this->map[$key] = $endpoint;
            }
        }
    }

    public function all(): array { return array_values($this->map); }
    public function has(ActionIdInterface $id): bool { return isset($this->map[$id->value()]); }

    public function get(ActionIdInterface $id): ActionEndpointInterface
    {
        $key = $id->value();
        if (!isset($this->map[$key])) { throw new \RuntimeException('Unknown action id: ' . $key); }
        return $this->map[$key];
    }
}

