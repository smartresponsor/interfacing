<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud\Contribution;

use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceDescriptorContributionInterface;

final class OrderingCrudResourceContribution extends AbstractCrudResourceContribution implements CrudResourceDescriptorContributionInterface
{
    public function provide(): array
    {
        return [
            $this->canonicalResource('ordering.order', 'Ordering', 'Order', 'order', 'Order is the canonical reference for generic business CRUD plus custom workbench overlays.'),
            $this->canonicalResource('ordering.order-item', 'Ordering', 'Order item', 'order-item', 'Shown proactively so you can test nested order-related CRUD flows once wired.'),
        ];
    }
}
