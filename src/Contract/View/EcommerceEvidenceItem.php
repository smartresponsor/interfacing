<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

final readonly class EcommerceEvidenceItem
{
    /**
     * @param list<string> $routeEvidence
     * @param list<string> $dataEvidence
     * @param list<string> $operationEvidence
     * @param list<string> $policyEvidence
     * @param list<string> $auditEvidence
     * @param list<string> $missingEvidence
     */
    public function __construct(
        private string $id,
        private string $zone,
        private string $component,
        private string $status,
        private string $evidenceGrade,
        private int $score,
        private string $primaryUrl,
        private array $routeEvidence,
        private array $dataEvidence,
        private array $operationEvidence,
        private array $policyEvidence,
        private array $auditEvidence,
        private array $missingEvidence,
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

    public function evidenceGrade(): string
    {
        return $this->evidenceGrade;
    }

    public function score(): int
    {
        return $this->score;
    }

    public function primaryUrl(): string
    {
        return $this->primaryUrl;
    }

    /** @return list<string> */
    public function routeEvidence(): array
    {
        return $this->routeEvidence;
    }

    /** @return list<string> */
    public function dataEvidence(): array
    {
        return $this->dataEvidence;
    }

    /** @return list<string> */
    public function operationEvidence(): array
    {
        return $this->operationEvidence;
    }

    /** @return list<string> */
    public function policyEvidence(): array
    {
        return $this->policyEvidence;
    }

    /** @return list<string> */
    public function auditEvidence(): array
    {
        return $this->auditEvidence;
    }

    /** @return list<string> */
    public function missingEvidence(): array
    {
        return $this->missingEvidence;
    }

    public function note(): string
    {
        return $this->note;
    }
}
