<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

final readonly class EcommerceOperationCard
{
    /**
     * @param list<EcommerceScreenEntry> $action
     */
    public function __construct(
        private string $id,
        private string $zone,
        private string $component,
        private string $label,
        private string $resourceStatus,
        private string $indexUrl,
        private string $newUrl,
        private string $showUrl,
        private string $editUrl,
        private string $deleteUrl,
        private string $resourceKind,
        private ?string $note,
        private array $action = [],
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function zone(): string
    {
        return $this->zone;
    }

    public function component(): string
    {
        return $this->component;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function resourceStatus(): string
    {
        return $this->resourceStatus;
    }

    public function indexUrl(): string
    {
        return $this->indexUrl;
    }

    public function newUrl(): string
    {
        return $this->newUrl;
    }

    public function showUrl(): string
    {
        return $this->showUrl;
    }

    public function editUrl(): string
    {
        return $this->editUrl;
    }

    public function deleteUrl(): string
    {
        return $this->deleteUrl;
    }

    public function resourceKind(): string
    {
        return $this->resourceKind;
    }

    public function note(): ?string
    {
        return $this->note;
    }

    /** @return list<EcommerceScreenEntry> */
    public function action(): array
    {
        return $this->action;
    }

    public function primaryUrl(): string
    {
        return $this->indexUrl;
    }

    public function isLive(): bool
    {
        return 'connected' === $this->resourceStatus;
    }
}
