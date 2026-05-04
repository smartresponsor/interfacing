<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud\Contribution;

use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceDescriptorContributionInterface;

final class InterfacingCrudResourceContribution extends AbstractCrudResourceContribution implements CrudResourceDescriptorContributionInterface
{
    public function provide(): array
    {
        return [
            $this->canonicalResource('interfacing.screen', 'Interfacing', 'Screen', 'interfacing-screen', 'Interfacing screens are listed as first-class workbench resources for shell QA.'),
            $this->canonicalResource('interfacing.layout', 'Interfacing', 'Layout', 'interfacing-layout', 'Layout contracts and shell composition screens use the same CRUD bridge grammar.'),
            $this->canonicalResource('interfacing.widget', 'Interfacing', 'Widget', 'interfacing-widget', 'Widget specs are exposed so data-grid, form, metric and wizard frames have a visible workbench.'),
            $this->canonicalResource('interfacing.action', 'Interfacing', 'Action', 'interfacing-action', 'Action endpoints can be audited from a route-compatible CRUD shell.'),
            $this->canonicalResource('interfacing.crud-resource', 'Interfacing', 'CRUD resource', 'crud-resource', 'Directory entry for the resource registry that feeds this explorer.'),
        ];
    }
}
