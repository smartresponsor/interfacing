<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommerceAdminTableRow;
use App\Interfacing\Contract\View\EcommerceCrudFrame;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceAdminTableProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceCrudFrameProviderInterface;

final readonly class EcommerceCrudFrameProvider implements EcommerceCrudFrameProviderInterface
{
    public function __construct(private EcommerceAdminTableProviderInterface $adminTableProvider)
    {
    }

    public function provide(): array
    {
        $frames = [];

        foreach ($this->adminTableProvider->provide() as $row) {
            if (!$row instanceof EcommerceAdminTableRow) {
                continue;
            }

            $frames[] = $this->newFrame($row);
            $frames[] = $this->editFrame($row);
            $frames[] = $this->deleteFrame($row);
        }

        return $frames;
    }

    public function groupedByZone(): array
    {
        $grouped = [];
        foreach ($this->provide() as $frame) {
            $grouped[$frame->zone()][] = $frame;
        }

        return $grouped;
    }

    public function statusCounts(): array
    {
        $counts = ['connected' => 0, 'canonical' => 0, 'planned' => 0, 'total' => 0];

        foreach ($this->provide() as $frame) {
            ++$counts['total'];
            if (array_key_exists($frame->status(), $counts)) {
                ++$counts[$frame->status()];
            }
        }

        return $counts;
    }

    private function newFrame(EcommerceAdminTableRow $row): EcommerceCrudFrame
    {
        return new EcommerceCrudFrame(
            id: $row->id().'.new.frame',
            zone: $row->zone(),
            component: $row->component(),
            resourceLabel: $row->resourceLabel(),
            status: $row->status(),
            mode: 'new',
            title: 'Create '.$row->resourceLabel(),
            primaryUrl: $row->newUrl(),
            secondaryUrl: $row->indexUrl(),
            identifierPreview: 'component-generated',
            contractTitle: 'Create form frame only',
            contractText: sprintf('%s owns defaults, validation, persistence and fixtures. Interfacing renders the create-form shell and navigation contract only.', $row->component()),
            routePattern: '/{resource}/new/',
            note: $row->note(),
        );
    }

    private function editFrame(EcommerceAdminTableRow $row): EcommerceCrudFrame
    {
        return new EcommerceCrudFrame(
            id: $row->id().'.edit.frame',
            zone: $row->zone(),
            component: $row->component(),
            resourceLabel: $row->resourceLabel(),
            status: $row->status(),
            mode: 'edit',
            title: 'Edit '.$row->resourceLabel(),
            primaryUrl: $row->editUrl(),
            secondaryUrl: $row->showUrl(),
            identifierPreview: $row->identifierPreview(),
            contractTitle: 'Edit form frame only',
            contractText: sprintf('%s supplies the record, field model and save handler. Interfacing renders the edit affordance and route transparency only.', $row->component()),
            routePattern: '/{resource}/edit/{id}',
            note: $row->note(),
        );
    }

    private function deleteFrame(EcommerceAdminTableRow $row): EcommerceCrudFrame
    {
        return new EcommerceCrudFrame(
            id: $row->id().'.delete.frame',
            zone: $row->zone(),
            component: $row->component(),
            resourceLabel: $row->resourceLabel(),
            status: $row->status(),
            mode: 'delete',
            title: 'Delete '.$row->resourceLabel(),
            primaryUrl: $row->deleteUrl(),
            secondaryUrl: $row->showUrl(),
            identifierPreview: $row->identifierPreview(),
            contractTitle: 'Delete confirmation frame only',
            contractText: sprintf('%s owns authorization, confirmation token, deletion policy and audit evidence. Interfacing renders the destructive-operation shell only.', $row->component()),
            routePattern: '/{resource}/delete/{id}',
            note: $row->note(),
        );
    }
}
