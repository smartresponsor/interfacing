<?php

declare(strict_types=1);

namespace App\Interfacing\Registry\Style;

use App\Interfacing\ProviderInterface\Style\InterfaceStyleProviderInterface;

final class InterfaceStyleProviderRegistry
{
    /** @var array<string, InterfaceStyleProviderInterface> */
    private array $providers;

    /**
     * @param iterable<InterfaceStyleProviderInterface> $providers
     */
    public function __construct(iterable $providers)
    {
        $indexed = [];

        foreach ($providers as $provider) {
            $indexed[$provider->key()] = $provider;
        }

        $this->providers = $indexed;
    }

    public function get(string $key): InterfaceStyleProviderInterface
    {
        if (isset($this->providers[$key])) {
            return $this->providers[$key];
        }

        if (isset($this->providers['ant_design'])) {
            return $this->providers['ant_design'];
        }

        $provider = reset($this->providers);
        if ($provider instanceof InterfaceStyleProviderInterface) {
            return $provider;
        }

        throw new \LogicException('No Interfacing UI style provider is registered.');
    }

    /**
     * @return list<string>
     */
    public function keys(): array
    {
        return array_keys($this->providers);
    }
}
