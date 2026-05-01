<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommerceContractItem;
use App\Interfacing\Contract\View\EcommerceFieldSchemaItem;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceContractRegistryProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceFieldSchemaRegistryProviderInterface;

final readonly class EcommerceFieldSchemaRegistryProvider implements EcommerceFieldSchemaRegistryProviderInterface
{
    public function __construct(private EcommerceContractRegistryProviderInterface $contractRegistryProvider)
    {
    }

    public function provide(): array
    {
        $items = [];
        foreach ($this->contractRegistryProvider->provide() as $contract) {
            if (!$contract instanceof EcommerceContractItem) {
                continue;
            }

            $items[] = new EcommerceFieldSchemaItem(
                id: $contract->id().'.schema',
                zone: $contract->zone(),
                component: $contract->component(),
                status: $contract->status(),
                schemaGrade: $this->schemaGrade($contract->contractGrade()),
                score: $this->score($contract->contractGrade()),
                primaryUrl: $contract->primaryUrl(),
                identifierContracts: $this->identifierContracts($contract),
                tableColumns: $this->tableColumns($contract),
                formFields: $this->formFields($contract),
                validationRules: $this->validationRules($contract),
                relationshipFields: $this->relationshipFields($contract),
                openQuestions: $this->openQuestions($contract),
                note: $this->note($contract),
            );
        }

        usort(
            $items,
            static fn (EcommerceFieldSchemaItem $left, EcommerceFieldSchemaItem $right): int => [
                self::zoneOrder($left->zone()),
                self::gradeOrder($left->schemaGrade()),
                $left->component(),
                $left->id(),
            ] <=> [
                self::zoneOrder($right->zone()),
                self::gradeOrder($right->schemaGrade()),
                $right->component(),
                $right->id(),
            ],
        );

        return $items;
    }

    public function groupedByZone(): array
    {
        $grouped = [];
        foreach ($this->provide() as $item) {
            $grouped[$item->zone()][] = $item;
        }

        return $grouped;
    }

    public function gradeCounts(): array
    {
        $counts = ['schema_ready' => 0, 'draft' => 0, 'missing' => 0, 'total' => 0];
        foreach ($this->provide() as $item) {
            ++$counts['total'];
            ++$counts[$item->schemaGrade()];
        }

        return $counts;
    }

    private function schemaGrade(string $contractGrade): string
    {
        return match ($contractGrade) {
            'formalized' => 'schema_ready',
            'draft' => 'draft',
            default => 'missing',
        };
    }

    private function score(string $contractGrade): int
    {
        return match ($contractGrade) {
            'formalized' => 100,
            'draft' => 70,
            default => 25,
        };
    }

    /** @return list<string> */
    private function identifierContracts(EcommerceContractItem $contract): array
    {
        return match ($contract->contractGrade()) {
            'formalized' => ['stable id/slug source is component-owned', 'show/edit/delete links use runtime identifiers rather than Interfacing samples'],
            'draft' => ['identifier source must be named before connected promotion', 'sample id remains navigation-only'],
            default => ['component must publish identifier contract', 'Interfacing must not invent stored ids'],
        };
    }

    /** @return list<string> */
    private function tableColumns(EcommerceContractItem $contract): array
    {
        return match ($contract->contractGrade()) {
            'formalized' => ['index table columns are declared by owning component', 'labels, sorting hints and empty states are component-owned'],
            'draft' => ['minimum index columns should be drafted: identifier, title/status, timestamps', 'sorting/search hints remain open'],
            default => ['table column contract is missing', 'Admin Tables can only show resource shells until schema is supplied'],
        };
    }

    /** @return list<string> */
    private function formFields(EcommerceContractItem $contract): array
    {
        return match ($contract->contractGrade()) {
            'formalized' => ['new/edit fields and delete summary fields are declared by component schema', 'field labels and help text do not live in Interfacing'],
            'draft' => ['new/edit field list should be drafted before form frame promotion', 'delete confirmation summary fields remain pending'],
            default => ['new/edit/delete frames stay structural only', 'component must publish field schema before real forms appear'],
        };
    }

    /** @return list<string> */
    private function validationRules(EcommerceContractItem $contract): array
    {
        return match ($contract->contractGrade()) {
            'formalized' => ['validation groups and constraints are component-owned', 'Interfacing renders errors but does not define business validation'],
            'draft' => ['validation boundary must name the component command/form contract', 'field-level error mapping remains promotion blocker'],
            default => ['validation contract is missing for create/update actions'],
        };
    }

    /** @return list<string> */
    private function relationshipFields(EcommerceContractItem $contract): array
    {
        return match ($contract->contractGrade()) {
            'formalized' => ['relations and lookup fields are provided through component query contracts', 'foreign choices are not hardcoded inside Interfacing'],
            'draft' => ['lookup/choice provider contract must be identified for relation fields'],
            default => ['relationship and lookup field contracts are not yet declared'],
        };
    }

    /** @return list<string> */
    private function openQuestions(EcommerceContractItem $contract): array
    {
        return match ($contract->contractGrade()) {
            'formalized' => ['keep schema proof synchronized with component migrations and new CRUD fields'],
            'draft' => ['which DTO/form schema owns table columns?', 'which query supplies relation labels?', 'which validation groups map to new/edit?'],
            default => ['what is the minimal field set?', 'what identifier type is canonical?', 'which component fixture proves first records?'],
        };
    }

    private function note(EcommerceContractItem $contract): string
    {
        return sprintf(
            '%s field schema registry row derived from %s contract grade. Interfacing renders table/form shells; %s owns fields, labels, validation and identifiers.',
            $contract->component(),
            $contract->contractGrade(),
            $contract->component(),
        );
    }

    private static function zoneOrder(string $zone): int
    {
        return match ($zone) {
            'Access' => 10,
            'Catalog and discovery' => 20,
            'Commercial and retail' => 30,
            'Ordering' => 40,
            'Billing and paying' => 50,
            'Tax and governance' => 60,
            'Fulfillment and location' => 70,
            'Messaging' => 80,
            'Documents and attachments' => 90,
            'Platform operations' => 100,
            default => 900,
        };
    }

    private static function gradeOrder(string $grade): int
    {
        return match ($grade) {
            'missing' => 10,
            'draft' => 20,
            'schema_ready' => 30,
            default => 900,
        };
    }
}
