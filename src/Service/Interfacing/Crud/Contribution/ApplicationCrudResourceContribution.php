<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud\Contribution;

use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceContributionInterface;

final class ApplicationCrudResourceContribution extends AbstractCrudResourceContribution implements CrudResourceContributionInterface
{
    public function provide(): array
    {
        return [
            $this->resource(
                id: 'applicating.application',
                component: 'Applicating',
                label: 'Application',
                resourcePath: 'admin/applications',
                indexRoute: 'applicating_application_index',
                indexFallback: '/admin/applications',
                newRoute: 'applicating_application_new',
                newFallback: '/admin/applications/new',
                showPattern: '/admin/applications/{id}',
                editPattern: '/admin/applications/{id}/edit',
                deletePattern: '/admin/applications/delete/{id}',
                note: 'Administrative application management already exposes a concrete index/new flow in the host app.',
            ),
        ];
    }
}
