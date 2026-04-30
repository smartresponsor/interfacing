<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Crud;

/**
 * Host-fed CRUD screen context that sits above raw route semantics.
 *
 * Interfacing should consume this higher-level context when the host CRUD layer
 * can provide resolved urls, capability state, template intent, and mutation
 * posture. Route-derived fallback values keep the package renderable in local
 * demo mode.
 *
 * @psalm-immutable
 */
final readonly class CrudScreenContext
{
    /**
     * @param array{index:string,new:string,show:string,edit:string,delete:string,next:string} $urls
     */
    public function __construct(
        public CrudRouteContext $routeContext,
        public string $templateIntent,
        public string $accessMode,
        public string $capabilityLabel,
        public string $ownershipLabel,
        public bool $readonly,
        public bool $mutationAllowed,
        public array $urls,
    ) {
    }

    public function isReadonly(): bool
    {
        return $this->readonly;
    }

    public function accessToneLabel(): string
    {
        return match ($this->accessMode) {
            'denied' => 'Access denied / hidden workbench actions',
            'readonly' => 'Readonly surface with mutation lock',
            default => 'Interactive workbench access',
        };
    }

    public function mutationToneLabel(): string
    {
        return $this->mutationAllowed ? 'Mutation-capable surface' : 'Mutation locked by host CRUD context';
    }

    public function templateToneLabel(): string
    {
        return match ($this->templateIntent) {
            'workbench.index' => 'Index workbench template intent',
            'workbench.detail' => 'Detail workbench template intent',
            'workbench.form' => 'Form workbench template intent',
            'workbench.destructive' => 'Destructive workbench template intent',
            default => 'Reusable CRUD workbench intent',
        };
    }
}
