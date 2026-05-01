<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

final readonly class EcommerceAdminTableRow
{
    public function __construct(
        private string $id,
        private string $zone,
        private string $component,
        private string $resourceLabel,
        private string $status,
        private string $indexUrl,
        private string $newUrl,
        private string $showUrl,
        private string $editUrl,
        private string $deleteUrl,
        private string $identifierPreview,
        private string $emptyStateTitle,
        private string $emptyStateText,
        private ?string $note = null,
    ) {
    }

    public function id(): string { return $this->id; }
    public function zone(): string { return $this->zone; }
    public function component(): string { return $this->component; }
    public function resourceLabel(): string { return $this->resourceLabel; }
    public function status(): string { return $this->status; }
    public function indexUrl(): string { return $this->indexUrl; }
    public function newUrl(): string { return $this->newUrl; }
    public function showUrl(): string { return $this->showUrl; }
    public function editUrl(): string { return $this->editUrl; }
    public function deleteUrl(): string { return $this->deleteUrl; }
    public function identifierPreview(): string { return $this->identifierPreview; }
    public function emptyStateTitle(): string { return $this->emptyStateTitle; }
    public function emptyStateText(): string { return $this->emptyStateText; }
    public function note(): ?string { return $this->note; }
    public function isConnected(): bool { return 'connected' === $this->status; }
}
