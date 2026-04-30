<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud;

use App\Interfacing\Contract\Crud\CrudRouteContext;
use App\Interfacing\Contract\Crud\CrudScreenContext;
use Symfony\Component\HttpFoundation\Request;

final readonly class CrudScreenContextResolver
{
    public function resolve(Request $request, CrudRouteContext $routeContext): CrudScreenContext
    {
        $accessMode = (string) $request->attributes->get('_crud_access_mode', $request->query->get('_crud_access_mode', $this->defaultAccessMode($routeContext)));
        $readonly = filter_var($request->attributes->get('_crud_readonly', $request->query->get('_crud_readonly', $this->defaultReadonly($routeContext))), FILTER_VALIDATE_BOOL);
        $mutationAllowed = filter_var($request->attributes->get('_crud_mutation_allowed', $request->query->get('_crud_mutation_allowed', $this->defaultMutationAllowed($routeContext, $readonly))), FILTER_VALIDATE_BOOL);

        return new CrudScreenContext(
            routeContext: $routeContext,
            templateIntent: (string) $request->attributes->get('_crud_template_intent', $request->query->get('_crud_template_intent', $this->defaultTemplateIntent($routeContext))),
            accessMode: $accessMode,
            capabilityLabel: (string) $request->attributes->get('_crud_capability', $request->query->get('_crud_capability', $this->defaultCapabilityLabel($routeContext, $accessMode))),
            ownershipLabel: (string) $request->attributes->get('_crud_ownership', $request->query->get('_crud_ownership', $this->defaultOwnershipLabel($routeContext))),
            readonly: $readonly,
            mutationAllowed: $mutationAllowed,
            urls: [
                'index' => $this->routeUrl($request, $routeContext, 'index'),
                'new' => $this->routeUrl($request, $routeContext, 'new'),
                'show' => $this->routeUrl($request, $routeContext, 'show'),
                'edit' => $this->routeUrl($request, $routeContext, 'edit'),
                'delete' => $this->routeUrl($request, $routeContext, 'delete'),
                'next' => $this->routeUrl($request, $routeContext, 'next'),
            ],
        );
    }

    private function defaultTemplateIntent(CrudRouteContext $routeContext): string
    {
        return match ($routeContext->mode()) {
            'collection' => 'workbench.index',
            'form' => 'workbench.form',
            'destructive' => 'workbench.destructive',
            default => 'workbench.detail',
        };
    }

    private function defaultAccessMode(CrudRouteContext $routeContext): string
    {
        return match (true) {
            'delete' === $routeContext->operation && $routeContext->isPublicSurface() => 'readonly',
            default => 'interactive',
        };
    }

    private function defaultReadonly(CrudRouteContext $routeContext): bool
    {
        return 'show' === $routeContext->operation || ('delete' === $routeContext->operation && $routeContext->isPublicSurface());
    }

    private function defaultMutationAllowed(CrudRouteContext $routeContext, bool $readonly): bool
    {
        if ($readonly) {
            return false;
        }

        return 'show' !== $routeContext->operation;
    }

    private function defaultCapabilityLabel(CrudRouteContext $routeContext, string $accessMode): string
    {
        if ('readonly' === $accessMode) {
            return $routeContext->resourceEntityLabel().' read / inspect capability';
        }

        return match ($routeContext->operation) {
            'index' => $routeContext->resourceCollectionLabel().' browse capability',
            'new' => $routeContext->resourceEntityLabel().' create capability',
            'edit' => $routeContext->resourceEntityLabel().' mutate capability',
            'delete' => $routeContext->resourceEntityLabel().' destructive capability',
            default => $routeContext->resourceEntityLabel().' open capability',
        };
    }

    private function defaultOwnershipLabel(CrudRouteContext $routeContext): string
    {
        return $routeContext->isAdminSurface()
            ? 'Operator-owned administrative workbench context'
            : 'Consumer-owned public request context';
    }

    private function routeUrl(Request $request, CrudRouteContext $routeContext, string $operation): string
    {
        $key = '_crud_url_'.$operation;
        $value = $request->attributes->get($key, $request->query->get($key));

        if (is_string($value) && '' !== trim($value)) {
            return $value;
        }

        $base = '/'.trim($routeContext->resourcePath, '/');
        $identifier = $routeContext->displayIdentifier();

        return match ($operation) {
            'index' => $base.'/',
            'new' => $base.'/new/',
            'show' => null !== $identifier && '' !== $identifier ? $base.'/'.rawurlencode($identifier) : $base.'/',
            'edit' => null !== $identifier && '' !== $identifier ? $base.'/edit/'.rawurlencode($identifier) : $base.'/new/',
            'delete' => null !== $identifier && '' !== $identifier ? $base.'/delete/'.rawurlencode($identifier) : $base.'/',
            'next' => (null !== $identifier && '' !== $identifier ? $base.'/'.rawurlencode($identifier) : $base.'/').'?' . http_build_query(array_filter([
                'selected' => $identifier,
                'step' => 'next',
            ], static fn (mixed $item): bool => null !== $item && '' !== (string) $item)),
            default => $base.'/',
        };
    }
}
