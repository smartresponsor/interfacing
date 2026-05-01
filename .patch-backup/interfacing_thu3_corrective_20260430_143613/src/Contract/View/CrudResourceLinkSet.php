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
}
