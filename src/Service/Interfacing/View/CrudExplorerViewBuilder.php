<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Service\Interfacing\View;

use App\Interfacing\Contract\Crud\CrudOperationGrammarInterface;
use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudOperationGrammarProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceExplorerProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\View\CrudExplorerViewBuilderInterface;
use Symfony\Component\Routing\RouterInterface;

final readonly class CrudExplorerViewBuilder implements CrudExplorerViewBuilderInterface
{
    public function __construct(
        private CrudResourceExplorerProviderInterface $crudResourceExplorerProvider,
        private CrudOperationGrammarProviderInterface $operationGrammarProvider,
        private RouterInterface $router,
    ) {
    }

    /** @return array<string, mixed> */
    public function buildPage(): array
    {
        $resourceSet = $this->sortedResourceSet();
        $grouped = $this->groupByComponent($resourceSet);
        $routeRows = $this->routeExpectationRows($resourceSet);

        return [
            'title' => 'CRUD Explorer',
            'shell' => null,
            'screenId' => 'crud.explorer',
            'resourceSet' => $resourceSet,
            'resourceGroups' => $grouped,
            'componentSummary' => $this->componentSummary($grouped),
            'statusSummary' => $this->statusSummary($resourceSet),
            'routeExpectationSummary' => $this->routeExpectationSummary($routeRows),
            'operationSummary' => $this->operationSummary($resourceSet),
        ];
    }

    /** @return array<string, mixed> */
    public function buildLinksPayload(): array
    {
        $resourceSet = $this->sortedResourceSet();
        $payload = [];

        foreach ($resourceSet as $resource) {
            $payload[] = [
                'id' => $resource->id(),
                'component' => $resource->component(),
                'label' => $resource->label(),
                'resourcePath' => $resource->resourcePath(),
                'status' => $resource->status(),
                'note' => $resource->note(),
                'urls' => [
                    'index' => $resource->indexUrl(),
                    'new' => $resource->newUrl(),
                    'showSample' => $resource->showSampleUrl(),
                    'editSample' => $resource->editSampleUrl(),
                    'deleteSample' => $resource->deleteSampleUrl(),
                ],
                'patterns' => [
                    'show' => $resource->showPattern(),
                    'edit' => $resource->editPattern(),
                    'delete' => $resource->deletePattern(),
                ],
            ];
        }

        return [
            'schema' => 'smart-responsor.interfacing.crud-links.v1',
            'generatedBy' => 'Interfacing CRUD Explorer',
            'routeGrammar' => $this->routeGrammarPayload(),
            'counts' => [
                'resources' => count($payload),
                'components' => count($this->groupByComponent($resourceSet)),
                'statuses' => $this->statusSummary($resourceSet),
            ],
            'resources' => $payload,
        ];
    }

    /** @return array<string, mixed> */
    public function buildRouteExpectationsPayload(): array
    {
        $resourceSet = $this->sortedResourceSet();
        $rows = $this->routeExpectationRows($resourceSet);

        return [
            'schema' => 'smart-responsor.interfacing.crud-route-expectations.v1',
            'generatedBy' => 'Interfacing CRUD Explorer',
            'summary' => $this->routeExpectationSummary($rows),
            'bridgeRoutes' => $this->bridgeRoutePayload(),
            'expectations' => $rows,
        ];
    }

    /** @return array<string, mixed> */
    public function buildOperationsPayload(): array
    {
        $resourceSet = $this->sortedResourceSet();
        $operations = [];

        foreach ($this->bridgeRouteCatalog() as $operation => $definition) {
            $operations[$operation] = [
                'operation' => $operation,
                'label' => $definition->label(),
                'routeName' => $definition->routeName(),
                'grammar' => $definition->grammar(),
                'resources' => [],
            ];
        }

        foreach ($resourceSet as $resource) {
            foreach ($resource->operationUrls() as $action) {
                $operation = $action['operation'];
                if (!isset($operations[$operation])) {
                    continue;
                }

                $operations[$operation]['resources'][] = [
                    'resourceId' => $resource->id(),
                    'component' => $resource->component(),
                    'label' => $resource->label(),
                    'resourcePath' => $resource->resourcePath(),
                    'status' => $resource->status(),
                    'url' => $action['url'],
                    'variant' => $action['variant'],
                    'sampleIdentifier' => $resource->sampleIdentifier(),
                ];
            }
        }

        return [
            'schema' => 'smart-responsor.interfacing.crud-operation-launchpad.v1',
            'generatedBy' => 'Interfacing CRUD Explorer',
            'summary' => $this->operationSummary($resourceSet),
            'operations' => array_values($operations),
        ];
    }

    /** @return array<int, object> */
    private function sortedResourceSet(): array
    {
        $resourceSet = $this->crudResourceExplorerProvider->provide();

        usort(
            $resourceSet,
            static fn ($left, $right): int => [$left->component(), $left->label(), $left->id()] <=> [$right->component(), $right->label(), $right->id()],
        );

        return $resourceSet;
    }

    /**
     * @param array<int, object> $resourceSet
     *
     * @return array<string, list<object>>
     */
    private function groupByComponent(array $resourceSet): array
    {
        $grouped = [];
        foreach ($resourceSet as $resource) {
            $grouped[$resource->component()][] = $resource;
        }

        ksort($grouped);

        return $grouped;
    }

    /**
     * @param array<string, list<object>> $grouped
     *
     * @return list<array{component: string, resources: int, connected: int, canonical: int, planned: int, firstIndexUrl: string}>
     */
    private function componentSummary(array $grouped): array
    {
        $summary = [];
        foreach ($grouped as $component => $resources) {
            $counts = ['connected' => 0, 'canonical' => 0, 'planned' => 0];
            foreach ($resources as $resource) {
                $status = $resource->status();
                if (array_key_exists($status, $counts)) {
                    ++$counts[$status];
                }
            }

            $first = $resources[0] ?? null;
            $summary[] = [
                'component' => $component,
                'resources' => count($resources),
                'connected' => $counts['connected'],
                'canonical' => $counts['canonical'],
                'planned' => $counts['planned'],
                'firstIndexUrl' => null !== $first ? $first->indexUrl() : '#',
            ];
        }

        return $summary;
    }

    /**
     * @param array<int, object> $resourceSet
     *
     * @return list<array{resourceId:string,component:string,resourcePath:string,operation:string,routeName:string,routeExists:bool,routePath:?string,expectedPattern:string,sampleUrl:string,status:string}>
     */
    private function routeExpectationRows(array $resourceSet): array
    {
        $routes = $this->router->getRouteCollection();
        $rows = [];

        foreach ($resourceSet as $resource) {
            foreach ($this->bridgeRouteCatalog() as $operation => $definition) {
                $route = $routes->get($definition->routeName());
                $exists = null !== $route;

                $rows[] = [
                    'resourceId' => $resource->id(),
                    'component' => $resource->component(),
                    'resourcePath' => $resource->resourcePath(),
                    'operation' => $operation,
                    'routeName' => $definition->routeName(),
                    'routeExists' => $exists,
                    'routePath' => $exists ? $route->getPath() : null,
                    'expectedPattern' => $this->expectedPattern($resource, $definition),
                    'sampleUrl' => $this->sampleUrl($resource, $definition),
                    'status' => $exists ? 'route-present' : 'route-missing',
                ];
            }
        }

        return $rows;
    }

    /**
     * @param list<array{status:string}> $rows
     *
     * @return array{expectations:int,routePresent:int,routeMissing:int}
     */
    private function routeExpectationSummary(array $rows): array
    {
        $summary = ['expectations' => count($rows), 'routePresent' => 0, 'routeMissing' => 0];

        foreach ($rows as $row) {
            if ('route-present' === $row['status']) {
                ++$summary['routePresent'];
                continue;
            }

            ++$summary['routeMissing'];
        }

        return $summary;
    }

    /**
     * @return array<string, CrudOperationGrammarInterface>
     */
    private function bridgeRouteCatalog(): array
    {
        return $this->operationGrammarProvider->provide();
    }


    /** @return list<array{operation:string,label:string,routeName:string,grammar:string,variant:string}> */
    private function bridgeRoutePayload(): array
    {
        $payload = [];
        foreach ($this->bridgeRouteCatalog() as $operation => $definition) {
            $payload[] = [
                'operation' => $operation,
                'label' => $definition->label(),
                'routeName' => $definition->routeName(),
                'grammar' => $definition->grammar(),
                'variant' => $definition->variant(),
            ];
        }

        return $payload;
    }

    /** @return array<string, string> */
    private function routeGrammarPayload(): array
    {
        $payload = [];
        foreach ($this->bridgeRouteCatalog() as $operation => $definition) {
            $payload[$operation] = $definition->grammar();
        }

        return $payload;
    }

    private function expectedPattern(object $resource, CrudOperationGrammarInterface $definition): string
    {
        return $definition->expectedPattern($resource->resourcePath());
    }

    private function sampleUrl(object $resource, CrudOperationGrammarInterface $definition): string
    {
        return match ($definition->operation()) {
            'index' => $resource->indexUrl(),
            'new' => $resource->newUrl(),
            'show' => $resource->showSampleUrl(),
            'edit' => $resource->editSampleUrl(),
            'delete' => $resource->deleteSampleUrl(),
            default => $definition->sampleUrl($resource->resourcePath(), $resource->sampleIdentifier()),
        };
    }

    /**
     * @param array<int, object> $resourceSet
     *
     * @return list<array{operation:string,label:string,routeName:string,resources:int,connected:int,canonical:int,planned:int,other:int}>
     */
    private function operationSummary(array $resourceSet): array
    {
        $summary = [];
        foreach ($this->bridgeRouteCatalog() as $operation => $definition) {
            $summary[$operation] = [
                'operation' => $operation,
                'label' => $definition->label(),
                'routeName' => $definition->routeName(),
                'resources' => 0,
                'connected' => 0,
                'canonical' => 0,
                'planned' => 0,
                'other' => 0,
            ];
        }

        foreach ($resourceSet as $resource) {
            foreach ($summary as $operation => $row) {
                ++$summary[$operation]['resources'];
                $status = $resource->status();
                if (array_key_exists($status, $summary[$operation])) {
                    ++$summary[$operation][$status];
                    continue;
                }

                ++$summary[$operation]['other'];
            }
        }

        return array_values($summary);
    }

    /**
     * @param array<int, object> $resourceSet
     *
     * @return array<string, int>
     */
    private function statusSummary(array $resourceSet): array
    {
        $summary = ['connected' => 0, 'canonical' => 0, 'planned' => 0, 'other' => 0];
        foreach ($resourceSet as $resource) {
            $status = $resource->status();
            if (array_key_exists($status, $summary)) {
                ++$summary[$status];
                continue;
            }

            ++$summary['other'];
        }

        return $summary;
    }
}
