<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

final readonly class EcommerceComponentObligationItem
{
    /**
     * @param list<string> $requiredScreens
     * @param list<string> $requiredResources
     * @param list<string> $fixtureObligations
     * @param list<string> $contractObligations
     * @param list<string> $runtimeObligations
     * @param list<string> $evidenceObligations
     */
    public function __construct(
        private string $id,
        private string $zone,
        private string $component,
        private string $status,
        private string $riskLevel,
        private string $primaryUrl,
        private array $requiredScreens,
        private array $requiredResources,
        private array $fixtureObligations,
        private array $contractObligations,
        private array $runtimeObligations,
        private array $evidenceObligations,
        private string $boundary,
        private string $note,
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

    public function status(): string
    {
        return $this->status;
    }

    public function riskLevel(): string
    {
        return $this->riskLevel;
    }

    public function primaryUrl(): string
    {
        return $this->primaryUrl;
    }

    /** @return list<string> */
    public function requiredScreens(): array
    {
        return $this->requiredScreens;
    }

    /** @return list<string> */
    public function requiredResources(): array
    {
        return $this->requiredResources;
    }

    /** @return list<string> */
    public function fixtureObligations(): array
    {
        return $this->fixtureObligations;
    }

    /** @return list<string> */
    public function contractObligations(): array
    {
        return $this->contractObligations;
    }

    /** @return list<string> */
    public function runtimeObligations(): array
    {
        return $this->runtimeObligations;
    }

    /** @return list<string> */
    public function evidenceObligations(): array
    {
        return $this->evidenceObligations;
    }

    public function boundary(): string
    {
        return $this->boundary;
    }

    public function note(): string
    {
        return $this->note;
    }
}
