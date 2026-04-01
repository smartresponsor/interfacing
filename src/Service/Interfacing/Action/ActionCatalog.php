<?php

declare(strict_types=1);

namespace App\Service\Interfacing\Action;

use App\Contract\ValueObject\ActionIdInterface;
use App\ServiceInterface\Interfacing\Action\ActionCatalogInterface;
use App\ServiceInterface\Interfacing\Action\ActionEndpointInterface;
use App\ServiceInterface\Interfacing\Action\ActionProviderInterface;

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
                    throw new \RuntimeException('Duplicate action id: '.$key);
                }
                $this->map[$key] = $endpoint;
            }
        }
    }

    public function all(): array
    {
        return array_values($this->map);
    }

    public function has(ActionIdInterface $id): bool
    {
        return isset($this->map[$id->value()]);
    }

    public function get(ActionIdInterface $id): ActionEndpointInterface
    {
        $key = $id->value();
        if (!isset($this->map[$key])) {
            throw new \RuntimeException('Unknown action id: '.$key);
        }

        return $this->map[$key];
    }
}
