<?php

declare(strict_types=1);

namespace App\Interfacing\Resolver\Crud;

use App\Interfacing\Contract\Crud\InterfaceCrudRouteContext;
use Symfony\Component\HttpFoundation\Request;

final readonly class InterfaceCrudRouteContextResolver
{
    public function resolve(Request $request, string $fallbackResourcePath, string $fallbackOperation = 'index', string $fallbackSurface = 'public'): InterfaceCrudRouteContext
    {
        $resourcePath = (string) $request->attributes->get('resourcePath', $request->query->get('resourcePath', $fallbackResourcePath));
        $operation = (string) $request->attributes->get('_crud_operation', '');
        $surface = (string) $request->attributes->get('_crud_surface', '');
        if ('' === $operation) {
            $operation = $this->inferOperation($request, $fallbackOperation);
        }
        if ('' === $surface) {
            $surface = $this->inferSurface($request, $fallbackSurface);
        }

        $identifierField = null;
        $identifierValue = null;
        if ($request->attributes->has('id')) {
            $identifierField = 'id';
            $identifierValue = $request->attributes->get('id');
        } elseif ($request->attributes->has('slug')) {
            $identifierField = 'slug';
            $identifierValue = $request->attributes->get('slug');
        } elseif ($request->query->has('id')) {
            $identifierField = 'id';
            $identifierValue = $request->query->get('id');
        } elseif ($request->query->has('slug')) {
            $identifierField = 'slug';
            $identifierValue = $request->query->get('slug');
        }

        if (null === $identifierValue) {
            $selected = $request->query->get('selected');
            if (is_scalar($selected) && '' !== (string) $selected) {
                $identifierField = $identifierField ?? 'id';
                $identifierValue = $selected;
            }
        }

        return new InterfaceCrudRouteContext(
            resourcePath: trim($resourcePath, '/'),
            operation: $operation,
            surface: $surface,
            identifierField: $identifierField,
            identifierValue: is_scalar($identifierValue) ? $identifierValue : null,
        );
    }

    private function inferOperation(Request $request, string $fallback): string
    {
        $routeName = (string) $request->attributes->get('_route', '');
        if (str_contains($routeName, 'crud_new')) {
            return 'new';
        }
        if (str_contains($routeName, 'crud_edit')) {
            return 'edit';
        }
        if (str_contains($routeName, 'crud_delete')) {
            return 'delete';
        }
        if (str_contains($routeName, 'crud_show')) {
            return 'show';
        }
        if (str_contains($routeName, 'crud_index')) {
            return 'index';
        }

        $path = '/'.trim($request->getPathInfo(), '/').'/';
        if (str_contains($path, '/new/')) {
            return 'new';
        }
        if (str_contains($path, '/edit/')) {
            return 'edit';
        }
        if (str_contains($path, '/delete/')) {
            return 'delete';
        }
        if ($request->attributes->has('id') || $request->attributes->has('slug')) {
            return 'show';
        }

        return $fallback;
    }

    private function inferSurface(Request $request, string $fallback): string
    {
        $path = '/'.trim($request->getPathInfo(), '/').'/';
        if (str_contains($path, '/interfacing/resource/')) {
            return 'admin';
        }

        return $fallback;
    }
}
