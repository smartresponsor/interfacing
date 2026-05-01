<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

final readonly class EcommerceFieldSchemaItem
{
    /**
     * @param list<string> $identifierContracts
     * @param list<string> $tableColumns
     * @param list<string> $formFields
     * @param list<string> $validationRules
     * @param list<string> $relationshipFields
     * @param list<string> $openQuestions
     */
    public function __construct(
        private string $id,
        private string $zone,
        private string $component,
        private string $status,
        private string $schemaGrade,
        private int $score,
        private string $primaryUrl,
        private array $identifierContracts,
        private array $tableColumns,
        private array $formFields,
        private array $validationRules,
        private array $relationshipFields,
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

    public function schemaGrade(): string
    {
        return $this->schemaGrade;
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
    public function identifierContracts(): array
    {
        return $this->identifierContracts;
    }

    /** @return list<string> */
    public function tableColumns(): array
    {
        return $this->tableColumns;
    }

    /** @return list<string> */
    public function formFields(): array
    {
        return $this->formFields;
    }

    /** @return list<string> */
    public function validationRules(): array
    {
        return $this->validationRules;
    }

    /** @return list<string> */
    public function relationshipFields(): array
    {
        return $this->relationshipFields;
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
