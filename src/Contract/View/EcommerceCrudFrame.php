<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

final readonly class EcommerceCrudFrame
{
    public function __construct(
        private string $id,
        private string $zone,
        private string $component,
        private string $resourceLabel,
        private string $status,
        private string $mode,
        private string $title,
        private string $primaryUrl,
        private string $secondaryUrl,
        private string $identifierPreview,
        private string $contractTitle,
        private string $contractText,
        private string $routePattern,
        private ?string $note = null,
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

    public function resourceLabel(): string
    {
        return $this->resourceLabel;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function mode(): string
    {
        return $this->mode;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function primaryUrl(): string
    {
        return $this->primaryUrl;
    }

    public function secondaryUrl(): string
    {
        return $this->secondaryUrl;
    }

    public function identifierPreview(): string
    {
        return $this->identifierPreview;
    }

    public function contractTitle(): string
    {
        return $this->contractTitle;
    }

    public function contractText(): string
    {
        return $this->contractText;
    }

    public function routePattern(): string
    {
        return $this->routePattern;
    }

    public function note(): ?string
    {
        return $this->note;
    }

    public function isConnected(): bool
    {
        return 'connected' === $this->status;
    }
}
