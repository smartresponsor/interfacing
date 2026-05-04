<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Crud;

use App\Interfacing\Contract\Crud\CrudPreviewPage;

/**
 * Provides neutral preview rows for the generic CRUD workbench bridge.
 *
 * Owning components can publish resource-specific preview providers without
 * changing catch-all bridge routes, controllers, or view builders. Providers
 * map component-owned query/read models into Interfacing CRUD preview DTOs.
 */
interface CrudWorkbenchPreviewProviderInterface
{
    public function supports(string $resourcePath): bool;

    public function provide(string $resourcePath): CrudPreviewPage;
}
