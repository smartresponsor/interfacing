<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

final readonly class EcommercePromotionGateItem
{
    /**
     * @param list<string> $requiredEvidence
     * @param list<string> $blockingIssues
     * @param list<string> $nextActions
     */
    public function __construct(
        private string $id,
        private string $zone,
        private string $component,
        private string $currentStatus,
        private string $targetStatus,
        private string $gateStatus,
        private int $score,
        private string $primaryUrl,
        private array $requiredEvidence,
        private array $blockingIssues,
        private array $nextActions,
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

    public function currentStatus(): string
    {
        return $this->currentStatus;
    }

    public function targetStatus(): string
    {
        return $this->targetStatus;
    }

    public function gateStatus(): string
    {
        return $this->gateStatus;
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
    public function requiredEvidence(): array
    {
        return $this->requiredEvidence;
    }

    /** @return list<string> */
    public function blockingIssues(): array
    {
        return $this->blockingIssues;
    }

    /** @return list<string> */
    public function nextActions(): array
    {
        return $this->nextActions;
    }

    public function note(): string
    {
        return $this->note;
    }
}
