<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Crud;

use App\Interfacing\Contract\Crud\InterfaceCrudPreviewPage;
use App\Interfacing\ProviderInterface\Crud\InterfaceCrudWorkbenchPreviewProviderInterface;

/**
 * Selects the first resource-specific CRUD preview provider and falls back to
 * the standalone demo provider when no owning component contributes one.
 */
final readonly class InterfaceCrudWorkbenchPreviewProviderChain implements InterfaceCrudWorkbenchPreviewProviderInterface
{
    /**
     * @param iterable<InterfaceCrudWorkbenchPreviewProviderInterface> $providers
     */
    public function __construct(
        private iterable $providers,
        private InterfaceDefaultCrudWorkbenchPreviewProvider $fallback,
    ) {
    }

    public function supports(string $resourcePath): bool
    {
        foreach ($this->providers as $provider) {
            if ($provider->supports($resourcePath)) {
                return true;
            }
        }

        return $this->fallback->supports($resourcePath);
    }

    public function provide(string $resourcePath): InterfaceCrudPreviewPage
    {
        foreach ($this->providers as $provider) {
            if ($provider->supports($resourcePath)) {
                return $provider->provide($resourcePath);
            }
        }

        return $this->fallback->provide($resourcePath);
    }
}
