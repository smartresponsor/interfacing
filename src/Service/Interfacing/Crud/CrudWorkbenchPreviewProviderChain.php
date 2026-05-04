<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud;

use App\Interfacing\Contract\Crud\CrudPreviewPage;
use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudWorkbenchPreviewProviderInterface;

/**
 * Selects the first resource-specific CRUD preview provider and falls back to
 * the standalone demo provider when no owning component contributes one.
 */
final readonly class CrudWorkbenchPreviewProviderChain implements CrudWorkbenchPreviewProviderInterface
{
    /**
     * @param iterable<CrudWorkbenchPreviewProviderInterface> $providers
     */
    public function __construct(
        private iterable $providers,
        private DefaultCrudWorkbenchPreviewProvider $fallback,
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

    public function provide(string $resourcePath): CrudPreviewPage
    {
        foreach ($this->providers as $provider) {
            if ($provider->supports($resourcePath)) {
                return $provider->provide($resourcePath);
            }
        }

        return $this->fallback->provide($resourcePath);
    }
}
