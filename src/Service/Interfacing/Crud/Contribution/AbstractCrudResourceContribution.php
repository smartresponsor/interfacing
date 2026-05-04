<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud\Contribution;

use App\Interfacing\Contract\Crud\CrudResourceDescriptor;
use App\Interfacing\Contract\Crud\CrudResourceDescriptorInterface;

abstract class AbstractCrudResourceContribution
{
    /**
     * @param array<string, string> $routeParameters
     */
    protected function resource(
        string $id,
        string $component,
        string $label,
        string $resourcePath,
        string $indexRoute,
        string $indexFallback,
        string $newRoute,
        string $newFallback,
        string $showPattern,
        string $editPattern,
        string $deletePattern,
        ?string $note = null,
        array $routeParameters = [],
        string $status = 'connected',
        string $sampleIdentifier = 'sample',
    ): CrudResourceDescriptorInterface {
        return new CrudResourceDescriptor(
            id: $id,
            component: $component,
            label: $label,
            resourcePath: $resourcePath,
            indexRoute: $indexRoute,
            indexFallback: $indexFallback,
            newRoute: $newRoute,
            newFallback: $newFallback,
            showPattern: $showPattern,
            editPattern: $editPattern,
            deletePattern: $deletePattern,
            routeParameters: $routeParameters,
            note: $note,
            status: $status,
            sampleIdentifier: $sampleIdentifier,
        );
    }

    protected function genericResource(
        string $id,
        string $component,
        string $label,
        string $resourcePath,
        ?string $note = null,
    ): CrudResourceDescriptorInterface {
        return $this->resource(
            id: $id,
            component: $component,
            label: $label,
            resourcePath: $resourcePath,
            indexRoute: 'app_crud_index',
            indexFallback: '/'.$resourcePath.'/',
            newRoute: 'app_crud_new',
            newFallback: '/'.$resourcePath.'/new/',
            showPattern: '/'.$resourcePath.'/{id}',
            editPattern: '/'.$resourcePath.'/edit/{id}',
            deletePattern: '/'.$resourcePath.'/delete/{id}',
            note: $note,
            routeParameters: ['resourcePath' => $resourcePath],
            status: 'planned',
        );
    }

    protected function canonicalResource(
        string $id,
        string $component,
        string $label,
        string $resourcePath,
        ?string $note = null,
    ): CrudResourceDescriptorInterface {
        return $this->resource(
            id: $id,
            component: $component,
            label: $label,
            resourcePath: $resourcePath,
            indexRoute: 'app_crud_index',
            indexFallback: '/'.$resourcePath.'/',
            newRoute: 'app_crud_new',
            newFallback: '/'.$resourcePath.'/new/',
            showPattern: '/'.$resourcePath.'/{id}',
            editPattern: '/'.$resourcePath.'/edit/{id}',
            deletePattern: '/'.$resourcePath.'/delete/{id}',
            note: $note,
            routeParameters: ['resourcePath' => $resourcePath],
            status: 'canonical',
        );
    }
}
