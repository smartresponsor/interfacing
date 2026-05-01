<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud\Contribution;

use App\Interfacing\Contract\View\CrudResourceLinkSetInterface;
use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceContributionInterface;

final class EcosystemCrudResourceContribution extends AbstractCrudResourceContribution implements CrudResourceContributionInterface
{
    public function provide(): array
    {
        return [
            $this->genericResource('accessing.account', 'Accessing', 'Account', 'account', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('accessing.session', 'Accessing', 'Session', 'session', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('accessing.security-event', 'Accessing', 'Security event', 'security-event', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('addressing.address', 'Addressing', 'Address', 'address', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('adjudicating.adjudication', 'Adjudicating', 'Adjudication', 'adjudication', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('analysing.analytics-report', 'Analysing', 'Analytics report', 'analytics-report', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('anchoring.anchor', 'Anchoring', 'Anchor', 'anchor', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('applicating.application', 'Applicating', 'Application', 'application', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('applicating.release', 'Applicating', 'Release', 'release', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('attaching.attachment', 'Attaching', 'Attachment', 'attachment', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('billing.invoice', 'Billing', 'Invoice', 'invoice', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('billing.meter', 'Billing', 'Meter', 'meter', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('cataloging.category', 'Cataloging', 'Category', 'category', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('cataloging.collection', 'Cataloging', 'Collection', 'collection', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('commercializing.offer', 'Commercializing', 'Commercial offer', 'commercial-offer', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('complying.case', 'Complying', 'Compliance case', 'compliance-case', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('consuming.consumption', 'Consuming', 'Consumption', 'consumption', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('discovering.discovery', 'Discovering', 'Discovery', 'discovery', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('documentating.document', 'Documentating', 'Document', 'document', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('evaluating.evaluation', 'Evaluating', 'Evaluation', 'evaluation', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('faceting.facet', 'Faceting', 'Facet', 'facet', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('facting.fact', 'Facting', 'Fact', 'fact', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('governancing.policy', 'Governancing', 'Governance policy', 'governance-policy', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('indexing.record', 'Indexing', 'Index record', 'index-record', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('locating.location', 'Locating', 'Location', 'location', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('messaging.message', 'Messaging', 'Message', 'message', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('messaging.room', 'Messaging', 'Room', 'room', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('messaging.thread', 'Messaging', 'Thread', 'thread', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('messaging.notification', 'Messaging', 'Notification', 'notification', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('messaging.digest', 'Messaging', 'Digest', 'digest', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('ordering.order', 'Ordering', 'Order', 'order', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('ordering.order-item', 'Ordering', 'Order item', 'order-item', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('paying.payment', 'Paying', 'Payment', 'payment', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('projecting.projection', 'Projecting', 'Projection', 'projection', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('retailing.offer', 'Retailing', 'Retail offer', 'retail-offer', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('rolling.rollout', 'Rolling', 'Rollout', 'rollout', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('runtiming.status', 'Runtiming', 'Runtime status', 'runtime-status', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('search.query', 'Search', 'Search query', 'search-query', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('shipping.shipment', 'Shipping', 'Shipment', 'shipment', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('tagging.tag', 'Tagging', 'Tag', 'tag', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('taxating.api', 'Taxating', 'Taxation API', 'taxation-api', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('taxating.rate', 'Taxating', 'Taxation rate', 'taxation-rate', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('taxating.zone', 'Taxating', 'Taxation zone', 'taxation-zone', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('taxating.rate-value', 'Taxating', 'Taxation rate value', 'taxation-rate-value', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('taxating.product-taxation', 'Taxating', 'Product taxation', 'product-taxation', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('taxating.en-use', 'Taxating', 'EN Use', 'taxation-en-use', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('vendoring.vendor', 'Vendoring', 'Vendor', 'vendor', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('vendoring.vendor-transaction', 'Vendoring', 'Vendor transaction', 'vendor-transaction', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('vendoring.vendor-profile', 'Vendoring', 'Vendor profile', 'vendor-profile', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('vendoring.payout', 'Vendoring', 'Payout', 'payout', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
            $this->genericResource('vendoring.payout-account', 'Vendoring', 'Payout account', 'payout-account', 'Canonical Cruding grammar placeholder for known ecosystem resource. It becomes live as soon as the host wires this resourcePath.'),
        ];
    }
}
