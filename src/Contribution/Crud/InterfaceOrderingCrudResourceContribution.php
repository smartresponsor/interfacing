<?php

declare(strict_types=1);

namespace App\Interfacing\Contribution\Crud;

use App\Interfacing\ContributionInterface\Crud\InterfaceCrudResourceDescriptorContributionInterface;

final class InterfaceOrderingCrudResourceContribution extends InterfaceAbstractCrudResourceContribution implements InterfaceCrudResourceDescriptorContributionInterface
{
    public function provide(): array
    {
        return [
            $this->canonicalResource('ordering.order', 'Ordering', 'Order', 'order', 'Order is the canonical reference for generic business CRUD plus custom workbench overlays.'),
            $this->canonicalResource('ordering.order-item', 'Ordering', 'Order item', 'order-item', 'Shown proactively so you can test nested order-related CRUD flows once wired.'),
        ];
    }
}
