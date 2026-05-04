<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud\Contribution;

use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceDescriptorContributionInterface;

final class ShippingCrudResourceContribution extends AbstractCrudResourceContribution implements CrudResourceDescriptorContributionInterface
{
    public function provide(): array
    {
        return [
            $this->canonicalResource('shipping.shipment', 'Shipping', 'Shipment', 'shipment', 'Shipment is the canonical Shipping CRUD root.'),
            $this->canonicalResource('shipping.package', 'Shipping', 'Package', 'package', 'Package CRUD frames support parcel-level operational review.'),
            $this->canonicalResource('shipping.carrier', 'Shipping', 'Carrier', 'carrier', 'Carrier setup is surfaced for host-side configuration work.'),
            $this->canonicalResource('shipping.label', 'Shipping', 'Label', 'label', 'Label records get the same index/show/edit/delete affordances.'),
            $this->canonicalResource('shipping.tracking-event', 'Shipping', 'Tracking event', 'tracking-event', 'Tracking events are visible as first-class inspection records.'),
        ];
    }
}
