<?php

declare(strict_types=1);

namespace App\Interfacing\Catalog\Action;

use App\Interfacing\CatalogInterface\Action\InterfaceActionCatalogInterface;
use App\Interfacing\Contract\ValueObject\InterfaceActionIdInterface;
use App\Interfacing\EndpointInterface\Action\InterfaceActionEndpointInterface;
use App\Interfacing\ProviderInterface\Action\InterfaceActionProviderInterface;

final class InterfaceActionCatalog implements InterfaceActionCatalogInterface
{
    /** @var array<string, InterfaceActionEndpointInterface> */
    private array $map = [];

    /** @param iterable<InterfaceActionProviderInterface> $provider */
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

    public function has(InterfaceActionIdInterface $id): bool
    {
        return isset($this->map[$id->value()]);
    }

    public function get(InterfaceActionIdInterface $id): InterfaceActionEndpointInterface
    {
        $key = $id->value();
        if (!isset($this->map[$key])) {
            throw new \RuntimeException('Unknown action id: '.$key);
        }

        return $this->map[$key];
    }
}
