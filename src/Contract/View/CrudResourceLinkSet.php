<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

final readonly class CrudResourceLinkSet implements CrudResourceLinkSetInterface
{
    public function __construct(
        private string $id,
        private string $component,
        private string $label,
        private string $resourcePath,
        private string $indexUrl,
        private string $newUrl,
        private string $showPattern,
        private string $editPattern,
        private string $deletePattern,
        private ?string $note = null,
        private string $status = 'planned',
        private string $sampleIdentifier = 'sample',
        private ?string $showSampleUrl = null,
        private ?string $editSampleUrl = null,
        private ?string $deleteSampleUrl = null,
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

    public function indexUrl(): string
    {
        return $this->indexUrl;
    }

    public function newUrl(): string
    {
        return $this->newUrl;
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

    public function showSampleUrl(): string
    {
        return $this->showSampleUrl ?? $this->materialize($this->showPattern);
    }

    public function editSampleUrl(): string
    {
        return $this->editSampleUrl ?? $this->materialize($this->editPattern);
    }

    public function deleteSampleUrl(): string
    {
        return $this->deleteSampleUrl ?? $this->materialize($this->deletePattern);
    }


    /**
     * @return list<array{operation:string,label:string,url:string,variant:string}>
     */
    public function operationUrls(): array
    {
        return [
            ['operation' => 'index', 'label' => 'Index', 'url' => $this->indexUrl(), 'variant' => 'primary'],
            ['operation' => 'new', 'label' => 'New', 'url' => $this->newUrl(), 'variant' => 'default'],
            ['operation' => 'show', 'label' => 'Show', 'url' => $this->showSampleUrl(), 'variant' => 'default'],
            ['operation' => 'edit', 'label' => 'Edit', 'url' => $this->editSampleUrl(), 'variant' => 'default'],
            ['operation' => 'delete', 'label' => 'Delete', 'url' => $this->deleteSampleUrl(), 'variant' => 'danger'],
        ];
    }

    /**
     * @return list<array{operation:string,label:string,pattern:string}>
     */
    public function operationPatterns(): array
    {
        return [
            ['operation' => 'index', 'label' => 'Index', 'pattern' => '/'.$this->resourcePath.'/'],
            ['operation' => 'new', 'label' => 'New', 'pattern' => '/'.$this->resourcePath.'/new/'],
            ['operation' => 'show', 'label' => 'Show', 'pattern' => $this->showPattern],
            ['operation' => 'edit', 'label' => 'Edit', 'pattern' => $this->editPattern],
            ['operation' => 'delete', 'label' => 'Delete', 'pattern' => $this->deletePattern],
        ];
    }

    private function materialize(string $pattern): string
    {
        return str_replace(['{id}', '{id|slug}'], $this->sampleIdentifier, $pattern);
    }
}
