<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Crud;

use App\Interfacing\Contract\Crud\InterfaceCrudPreviewPage;

/**
 * Provides neutral preview rows for the generic CRUD workbench handoff.
 *
 * Owning components can publish resource-specific preview providers without
 * changing catch-all handoff routes, controllers, or view builders. Providers
 * map component-owned query/read models into Interfacing CRUD preview DTOs.
 */
interface InterfaceCrudWorkbenchPreviewProviderInterface
{
    public function supports(string $resourcePath): bool;

    public function provide(string $resourcePath): InterfaceCrudPreviewPage;
}
