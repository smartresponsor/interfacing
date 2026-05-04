<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\View;

use App\Interfacing\Service\Interfacing\Crud\CrudRouteContextResolver;
use App\Interfacing\Service\Interfacing\Crud\CrudScreenContextResolver;
use App\Interfacing\Service\Interfacing\Crud\CrudWorkbenchFactory;
use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudWorkbenchPreviewProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\View\GenericCrudWorkbenchViewBuilderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Builds the generic CRUD workbench context for the catch-all bridge routes.
 *
 * Preview rows are delegated to a provider contract so owning components can
 * publish resource-specific workbench data without changing bridge routes.
 */
final readonly class GenericCrudWorkbenchViewBuilder implements GenericCrudWorkbenchViewBuilderInterface
{
    public function __construct(
        private CrudRouteContextResolver $routeContextResolver,
        private CrudScreenContextResolver $screenContextResolver,
        private CrudWorkbenchFactory $workbenchFactory,
        private CrudWorkbenchPreviewProviderInterface $previewProvider,
    ) {
    }

    public function build(Request $request): array
    {
        $routeContext = $this->routeContextResolver->resolve($request, 'resource', 'index', 'admin');
        $screenContext = $this->screenContextResolver->resolve($request, $routeContext);
        $ctx = ['tenantId' => 'interfacing-preview'];

        return [
            'screenId' => 'generic-crud-workbench',
            'ctx' => $ctx,
            'workbench' => $this->workbenchFactory->buildCrudPreviewView(
                $this->previewProvider->provide($routeContext->resourcePath),
                $this->filters($request),
                $ctx,
                $routeContext,
                $screenContext,
            ),
        ];
    }

    /** @return array{status:string,createdFrom:string,createdTo:string} */
    private function filters(Request $request): array
    {
        return [
            'status' => (string) $request->query->get('status', ''),
            'createdFrom' => (string) $request->query->get('createdFrom', ''),
            'createdTo' => (string) $request->query->get('createdTo', ''),
        ];
    }
}