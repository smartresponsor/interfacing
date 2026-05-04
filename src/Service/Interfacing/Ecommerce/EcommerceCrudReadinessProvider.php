<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommerceCrudReadinessItem;
use App\Interfacing\Contract\View\EcommerceOperationCard;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceCrudReadinessProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceOperationWorkbenchProviderInterface;

final readonly class EcommerceCrudReadinessProvider implements EcommerceCrudReadinessProviderInterface
{
    public function __construct(private EcommerceOperationWorkbenchProviderInterface $operationWorkbenchProvider)
    {
    }

    public function provide(): array
    {
        static $cache = null;
        if (null !== $cache) {
            return $cache;
        }

        $items = [];

        foreach ($this->operationWorkbenchProvider->provide() as $card) {
            if (!$card instanceof EcommerceOperationCard) {
                continue;
            }

            $items[] = new EcommerceCrudReadinessItem(
                id: $card->id().'.readiness',
                zone: $card->zone(),
                component: $card->component(),
                resourceLabel: $card->label(),
                status: $card->resourceStatus(),
                readinessGrade: $this->readinessGrade($card->resourceStatus()),
                score: $this->score($card->resourceStatus()),
                primaryUrl: $card->primaryUrl(),
                tableChecks: $this->tableChecks($card),
                formChecks: $this->formChecks($card),
                actionChecks: $this->actionChecks($card),
                policyChecks: $this->policyChecks($card),
                note: $card->note(),
            );
        }

        usort(
            $items,
            static fn (EcommerceCrudReadinessItem $left, EcommerceCrudReadinessItem $right): int => [
                self::zoneOrder($left->zone()),
                self::gradeOrder($left->readinessGrade()),
                $left->component(),
                $left->id(),
            ] <=> [
                self::zoneOrder($right->zone()),
                self::gradeOrder($right->readinessGrade()),
                $right->component(),
                $right->id(),
            ],
        );

        return $cache = $items;
    }

    public function groupedByZone(): array
    {
        static $cache = null;
        if (null !== $cache) {
            return $cache;
        }

        $grouped = [];

        foreach ($this->provide() as $item) {
            $grouped[$item->zone()][] = $item;
        }

        return $cache = $grouped;
    }

    public function gradeCounts(): array
    {
        static $cache = null;
        if (null !== $cache) {
            return $cache;
        }

        $counts = ['ready' => 0, 'needs_bridge' => 0, 'planned' => 0, 'total' => 0];

        foreach ($this->provide() as $item) {
            ++$counts['total'];
            ++$counts[$item->readinessGrade()];
        }

        return $cache = $counts;
    }

    private function readinessGrade(string $status): string
    {
        return match ($status) {
            'connected' => 'ready',
            'canonical' => 'needs_bridge',
            default => 'planned',
        };
    }

    private function score(string $status): int
    {
        return match ($status) {
            'connected' => 100,
            'canonical' => 70,
            default => 25,
        };
    }

    /** @return list<string> */
    private function tableChecks(EcommerceOperationCard $card): array
    {
        return match ($card->resourceStatus()) {
            'connected' => [
                'index table is connected to the owning component',
                'row actions use canonical component identifiers',
            ],
            'canonical' => [
                'table shell is visible but still needs the bridge to component-owned records',
                'filters, sort and empty-state proof remain required',
            ],
            default => [
                'table shell is planned only',
                'Interfacing must not invent demo rows for this resource',
            ],
        };
    }

    /** @return list<string> */
    private function formChecks(EcommerceOperationCard $card): array
    {
        return match ($card->resourceStatus()) {
            'connected' => [
                'new/edit/delete frame contract is connected',
                'form identifiers and validation remain component-owned',
            ],
            'canonical' => [
                'form frame exists only as shell and needs the host bridge',
                'field schema and validation rules must be supplied by the component',
            ],
            default => [
                'form frames stay structural only',
                'component schema must be published before a real form appears',
            ],
        };
    }

    /** @return list<string> */
    private function actionChecks(EcommerceOperationCard $card): array
    {
        return match ($card->resourceStatus()) {
            'connected' => [
                'index/new/show/edit/delete routes resolve through host actions',
                'query and command handlers are wired for the resource',
            ],
            'canonical' => [
                'operation workbench is visible but still needs query/command ownership',
                'route transparency must be bridged to component handlers',
            ],
            default => [
                'action contract is only planned',
                'host must not fabricate CRUD execution paths',
            ],
        };
    }

    /** @return list<string> */
    private function policyChecks(EcommerceOperationCard $card): array
    {
        return match ($card->resourceStatus()) {
            'connected' => [
                'authorization and destructive-action policy are proven',
                'audit evidence is current for CRUD operations',
            ],
            'canonical' => [
                'permission names and destructive-action guards still need wiring',
                'audit events remain part of the promotion checklist',
            ],
            default => [
                'policy contract is missing',
                'the resource must stay in planning until ownership is defined',
            ],
        };
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
            'planned' => 10,
            'needs_bridge' => 20,
            'ready' => 30,
            default => 900,
        };
    }
}
