<?php

declare(strict_types=1);

namespace App\Interfacing\Builder\View;

use App\Interfacing\BuilderInterface\View\InterfaceGenericCrudWorkbenchViewBuilderInterface;
use App\Interfacing\Factory\Crud\InterfaceCrudWorkbenchFactory;
use App\Interfacing\ProviderInterface\Crud\InterfaceCrudWorkbenchPreviewProviderInterface;
use App\Interfacing\Resolver\Crud\InterfaceCrudRouteContextResolver;
use App\Interfacing\Resolver\Crud\InterfaceCrudScreenContextResolver;
use Symfony\Component\HttpFoundation\Request;

/**
 * Builds the generic CRUD workbench context for the catch-all handoff routes.
 *
 * Preview rows are delegated to a provider contract so owning components can
 * publish resource-specific workbench data without changing handoff routes.
 */
final readonly class InterfaceGenericCrudWorkbenchViewBuilder implements InterfaceGenericCrudWorkbenchViewBuilderInterface
{
    public function __construct(
        private InterfaceCrudRouteContextResolver $routeContextResolver,
        private InterfaceCrudScreenContextResolver $screenContextResolver,
        private InterfaceCrudWorkbenchFactory $workbenchFactory,
        private InterfaceCrudWorkbenchPreviewProviderInterface $previewProvider,
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
