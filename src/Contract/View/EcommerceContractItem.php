<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

final readonly class EcommerceContractItem
{
    /**
     * @param list<string> $screenContracts
     * @param list<string> $dataContracts
     * @param list<string> $operationContracts
     * @param list<string> $policyContracts
     * @param list<string> $evidenceContracts
     * @param list<string> $openQuestions
     */
    public function __construct(
        private string $id,
        private string $zone,
        private string $component,
        private string $status,
        private string $contractGrade,
        private int $score,
        private string $primaryUrl,
        private array $screenContracts,
        private array $dataContracts,
        private array $operationContracts,
        private array $policyContracts,
        private array $evidenceContracts,
        private array $openQuestions,
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

    public function contractGrade(): string
    {
        return $this->contractGrade;
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
    public function screenContracts(): array
    {
        return $this->screenContracts;
    }

    /** @return list<string> */
    public function dataContracts(): array
    {
        return $this->dataContracts;
    }

    /** @return list<string> */
    public function operationContracts(): array
    {
        return $this->operationContracts;
    }

    /** @return list<string> */
    public function policyContracts(): array
    {
        return $this->policyContracts;
    }

    /** @return list<string> */
    public function evidenceContracts(): array
    {
        return $this->evidenceContracts;
    }

    /** @return list<string> */
    public function openQuestions(): array
    {
        return $this->openQuestions;
    }

    public function note(): string
    {
        return $this->note;
    }
}
