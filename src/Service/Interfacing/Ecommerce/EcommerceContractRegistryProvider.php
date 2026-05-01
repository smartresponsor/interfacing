<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommerceContractItem;
use App\Interfacing\Contract\View\EcommerceEvidenceItem;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceContractRegistryProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceEvidenceRegistryProviderInterface;

final readonly class EcommerceContractRegistryProvider implements EcommerceContractRegistryProviderInterface
{
    public function __construct(private EcommerceEvidenceRegistryProviderInterface $evidenceRegistryProvider)
    {
    }

    public function provide(): array
    {
        $items = [];
        foreach ($this->evidenceRegistryProvider->provide() as $evidence) {
            if (!$evidence instanceof EcommerceEvidenceItem) {
                continue;
            }

            $items[] = new EcommerceContractItem(
                id: $evidence->id().'.contract',
                zone: $evidence->zone(),
                component: $evidence->component(),
                status: $evidence->status(),
                contractGrade: $this->contractGrade($evidence->evidenceGrade()),
                score: $this->score($evidence->evidenceGrade()),
                primaryUrl: $evidence->primaryUrl(),
                screenContracts: $this->screenContracts($evidence),
                dataContracts: $this->dataContracts($evidence),
                operationContracts: $this->operationContracts($evidence),
                policyContracts: $this->policyContracts($evidence),
                evidenceContracts: $this->evidenceContracts($evidence),
                openQuestions: $this->openQuestions($evidence),
                note: $this->note($evidence),
            );
        }

        usort(
            $items,
            static fn (EcommerceContractItem $left, EcommerceContractItem $right): int => [
                self::zoneOrder($left->zone()),
                self::gradeOrder($left->contractGrade()),
                $left->component(),
                $left->id(),
            ] <=> [
                self::zoneOrder($right->zone()),
                self::gradeOrder($right->contractGrade()),
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
        $counts = ['formalized' => 0, 'draft' => 0, 'missing' => 0, 'total' => 0];
        foreach ($this->provide() as $item) {
            ++$counts['total'];
            ++$counts[$item->contractGrade()];
        }

        return $counts;
    }

    private function contractGrade(string $evidenceGrade): string
    {
        return match ($evidenceGrade) {
            'complete' => 'formalized',
            'partial' => 'draft',
            default => 'missing',
        };
    }

    private function score(string $evidenceGrade): int
    {
        return match ($evidenceGrade) {
            'complete' => 100,
            'partial' => 65,
            default => 20,
        };
    }

    /** @return list<string> */
    private function screenContracts(EcommerceEvidenceItem $evidence): array
    {
        return match ($evidence->evidenceGrade()) {
            'complete' => ['screen list is promoted to connected', 'canonical index/new/show/edit/delete screen frames resolve through host routes'],
            'partial' => ['screen list is canonical but still needs runtime owner proof', 'sample identifiers must be replaced by component-owned identifiers'],
            default => ['screen list is planned only', 'Interfacing may show navigation but not own business screen data'],
        };
    }

    /** @return list<string> */
    private function dataContracts(EcommerceEvidenceItem $evidence): array
    {
        return match ($evidence->evidenceGrade()) {
            'complete' => ['component publishes records, identifiers, field schema and empty-state model', 'fixtures/providers are component-owned'],
            'partial' => ['component must publish fixture/provider contract', 'field schema and identifier source remain promotion blockers'],
            default => ['component must define fixture/provider ownership', 'no fake rows may be added inside Interfacing'],
        };
    }

    /** @return list<string> */
    private function operationContracts(EcommerceEvidenceItem $evidence): array
    {
        return match ($evidence->evidenceGrade()) {
            'complete' => ['query contract powers index/show surfaces', 'command contract powers create/update/delete actions'],
            'partial' => ['query contract can be wired first', 'command handlers for save/delete still need owner proof'],
            default => ['query/command service interfaces must be planned by owning component'],
        };
    }

    /** @return list<string> */
    private function policyContracts(EcommerceEvidenceItem $evidence): array
    {
        return match ($evidence->evidenceGrade()) {
            'complete' => ['permission names and destructive-action guards are connected', 'button visibility comes from component policy'],
            'partial' => ['permission naming and visibility policy must be formalized before live edit/delete'],
            default => ['policy contract is missing for protected operations'],
        };
    }

    /** @return list<string> */
    private function evidenceContracts(EcommerceEvidenceItem $evidence): array
    {
        return match ($evidence->evidenceGrade()) {
            'complete' => ['audit events exist for create/update/delete', 'runtime smoke proof is current'],
            'partial' => ['audit event names and bridge smoke proof remain required'],
            default => ['route, data, operation, policy and audit evidence are required before promotion'],
        };
    }

    /** @return list<string> */
    private function openQuestions(EcommerceEvidenceItem $evidence): array
    {
        return match ($evidence->evidenceGrade()) {
            'complete' => ['keep proof current when extending CRUD fields or destructive actions'],
            'partial' => ['which component provider supplies identifiers?', 'which command service owns save/delete?', 'which permission key hides protected actions?'],
            default => ['is the component in scope for host runtime?', 'which route prefix is canonical?', 'which fixtures/provider prove first records?'],
        };
    }

    private function note(EcommerceEvidenceItem $evidence): string
    {
        return sprintf(
            '%s contract registry row derived from %s evidence status. Interfacing owns shell/rendering; %s owns runtime business contracts.',
            $evidence->component(),
            $evidence->evidenceGrade(),
            $evidence->component(),
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
            'formalized' => 30,
            default => 900,
        };
    }
}
