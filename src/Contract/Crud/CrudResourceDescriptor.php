<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Crud;

final readonly class CrudResourceDescriptor implements CrudResourceDescriptorInterface
{
    /**
     * @param array<string, string> $routeParameters
     */
    public function __construct(
        private string $id,
        private string $component,
        private string $label,
        private string $resourcePath,
        private string $indexRoute,
        private string $indexFallback,
        private string $newRoute,
        private string $newFallback,
        private string $showPattern,
        private string $editPattern,
        private string $deletePattern,
        private array $routeParameters = [],
        private ?string $note = null,
        private string $status = 'planned',
        private string $sampleIdentifier = 'sample',
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function component(): string
    {
        return $this->component;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function resourcePath(): string
    {
        return $this->resourcePath;
    }

    public function indexRoute(): string
    {
        return $this->indexRoute;
    }

    public function indexFallback(): string
    {
        return $this->indexFallback;
    }

    public function newRoute(): string
    {
        return $this->newRoute;
    }

    public function newFallback(): string
    {
        return $this->newFallback;
    }

    public function showPattern(): string
    {
        return $this->showPattern;
    }

    public function editPattern(): string
    {
        return $this->editPattern;
    }

    public function deletePattern(): string
    {
        return $this->deletePattern;
    }

    public function routeParameters(): array
    {
        return $this->routeParameters;
    }

    public function note(): ?string
    {
        return $this->note;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function sampleIdentifier(): string
    {
        return $this->sampleIdentifier;
    }
}
