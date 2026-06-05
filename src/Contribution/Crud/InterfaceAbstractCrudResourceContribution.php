<?php

declare(strict_types=1);

namespace App\Interfacing\Contribution\Crud;

use App\Interfacing\Contract\Crud\InterfaceCrudResourceDescriptor;
use App\Interfacing\Contract\Crud\InterfaceCrudResourceDescriptorInterface;

abstract class InterfaceAbstractCrudResourceContribution
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
    ): InterfaceCrudResourceDescriptorInterface {
        return new InterfaceCrudResourceDescriptor(
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
    ): InterfaceCrudResourceDescriptorInterface {
        return $this->resource(
            id: $id,
            component: $component,
            label: $label,
            resourcePath: $resourcePath,
            indexRoute: 'host_crud_index',
            indexFallback: '/'.$resourcePath.'/',
            newRoute: 'host_crud_new',
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
    ): InterfaceCrudResourceDescriptorInterface {
        return $this->resource(
            id: $id,
            component: $component,
            label: $label,
            resourcePath: $resourcePath,
            indexRoute: 'host_crud_index',
            indexFallback: '/'.$resourcePath.'/',
            newRoute: 'host_crud_new',
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
