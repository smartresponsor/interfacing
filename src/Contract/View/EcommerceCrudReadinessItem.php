<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

final readonly class EcommerceCrudReadinessItem
{
    /**
     * @param list<string> $tableChecks
     * @param list<string> $formChecks
     * @param list<string> $actionChecks
     * @param list<string> $policyChecks
     */
    public function __construct(
        private string $id,
        private string $zone,
        private string $component,
        private string $resourceLabel,
        private string $status,
        private string $readinessGrade,
        private int $score,
        private string $primaryUrl,
        private array $tableChecks,
        private array $formChecks,
        private array $actionChecks,
        private array $policyChecks,
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

    public function readinessGrade(): string
    {
        return $this->readinessGrade;
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
    public function tableChecks(): array
    {
        return $this->tableChecks;
    }

    /** @return list<string> */
    public function formChecks(): array
    {
        return $this->formChecks;
    }

    /** @return list<string> */
    public function actionChecks(): array
    {
        return $this->actionChecks;
    }

    /** @return list<string> */
    public function policyChecks(): array
    {
        return $this->policyChecks;
    }

    public function note(): ?string
    {
        return $this->note;
    }
}
