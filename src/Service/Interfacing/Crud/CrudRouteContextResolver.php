<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud;

use App\Interfacing\Contract\Crud\CrudRouteContext;
use Symfony\Component\HttpFoundation\Request;

final readonly class CrudRouteContextResolver
{
    public function resolve(Request $request, string $fallbackResourcePath, string $fallbackOperation = 'index', string $fallbackSurface = 'public'): CrudRouteContext
    {
        $resourcePath = (string) $request->attributes->get('resourcePath', $request->query->get('resourcePath', $fallbackResourcePath));
        $operation = (string) $request->attributes->get('_crud_operation', $request->query->get('_crud_operation', $fallbackOperation));
        $surface = (string) $request->attributes->get('_crud_surface', $request->query->get('_crud_surface', $fallbackSurface));

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

        return new CrudRouteContext(
            resourcePath: trim($resourcePath, '/'),
            operation: $operation,
            surface: $surface,
            identifierField: $identifierField,
            identifierValue: is_scalar($identifierValue) ? $identifierValue : null,
        );
    }
}
