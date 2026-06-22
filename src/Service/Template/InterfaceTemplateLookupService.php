<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Template;

use App\Interfacing\Contract\Template\InterfaceLocationPayload;
use App\Interfacing\Contract\Template\InterfaceShellLocation;
use App\Interfacing\Contract\Template\InterfaceTemplateCandidate;
use App\Interfacing\ServiceInterface\Template\InterfaceTemplateLookupServiceInterface;
use Twig\Environment;

/**
 * Looks up neutral Interfacing view templates without knowing producer ownership.
 */
final readonly class InterfaceTemplateLookupService implements InterfaceTemplateLookupServiceInterface
{
    public function __construct(private Environment $twig)
    {
    }

    public function resolve(string $view, string $operation = 'index'): InterfaceTemplateCandidate
    {
        $view = $this->normalizeView($view);
        $operation = $this->normalizeOperation($operation);
        $candidates = [
            $view.'/'.$operation.'.html.twig',
            $view.'/index.html.twig',
        ];

        foreach ($candidates as $candidate) {
            if ($this->twig->getLoader()->exists($candidate)) {
                return new InterfaceTemplateCandidate($view, $candidate, $candidates, true);
            }
        }

        return new InterfaceTemplateCandidate($view, 'data-only', $candidates, false);
    }

    public function payloadForView(string $view, string $operation, string $title, array $metadata = []): InterfaceLocationPayload
    {
        $view = $this->normalizeView($view);
        $operation = $this->normalizeOperation($operation);
        $candidate = $this->resolve($view, $operation);

        return new InterfaceLocationPayload($view, $candidate, [
            InterfaceShellLocation::BODY_HEADER => [[
                'type' => 'heading',
                'label' => $title,
                'description' => 'View payload provided through template lookup and shell locations.',
            ]],
            InterfaceShellLocation::BODY_TOOLBAR => [[
                'type' => 'toolbar',
                'label' => ucfirst($operation).' toolbar',
                'items' => [],
            ]],
            InterfaceShellLocation::RIGHT_CONTEXT => [[
                'type' => 'metadata',
                'label' => 'View',
                'value' => $view,
            ], [
                'type' => 'metadata',
                'label' => 'Template',
                'value' => $candidate->matched ? $candidate->template : 'data-only',
            ]],
        ], $metadata + [
            'view' => $view,
            'operation' => $operation,
            'templateMatched' => $candidate->matched,
        ]);
    }

    private function normalizeView(string $view): string
    {
        $view = strtolower(trim(str_replace('_', '-', $view), '/'));
        $first = strtok(str_replace('_', '/', $view), '/') ?: $view;

        $componentToView = [
            'accessing' => 'access',
            'addressing' => 'address',
            'adjudicating' => 'adjudication',
            'administering' => 'admin',
            'analysing' => 'analysis',
            'anchoring' => 'anchor',
            'app' => 'application',
            'applicating' => 'application',
            'attaching' => 'attachment',
            'automating' => 'automation',
            'boundarying' => 'boundary',
            'bridging' => 'interface',
            'canonization' => 'canon',
            'carting' => 'cart',
            'cataloging' => 'catalog',
            'codexing' => 'codex',
            'commanding' => 'command',
            'commercializing' => 'commercial',
            'commissioning' => 'commission',
            'complying' => 'compliance',
            'configuring' => 'configuration',
            'consuming' => 'consumption',
            'containerizing' => 'container',
            'cruding' => 'crud',
            'currencing' => 'currency',
            'discovering' => 'discovery',
            'documentating' => 'document',
            'evaluating' => 'evaluation',
            'exchanging' => 'exchange-rate',
            'faceting' => 'facet',
            'facting' => 'fact',
            'financing' => 'finance',
            'gating' => 'gate',
            'governancing' => 'governance',
            'indexing' => 'index',
            'interfacing' => 'interface',
            'localizing' => 'locale',
            'locating' => 'location',
            'managing' => 'management',
            'merchandising' => 'merchandise',
            'messaging' => 'message',
            'mobiling' => 'mobile',
            'objecting' => 'object',
            'observabiliting' => 'observability',
            'operating' => 'operation',
            'ordering' => 'order',
            'paging' => 'page',
            'paying' => 'payment',
            'projecting' => 'project',
            'retailing' => 'retail',
            'rolling' => 'rollout',
            'runtiming' => 'runtime',
            'searching' => 'search',
            'shipping' => 'shipment',
            'subscripting' => 'subscription',
            'tagging' => 'tag',
            'taxating' => 'taxation',
            'vendoring' => 'vendor',
        ];

        return match ($first) {
            'category', 'product', 'collection', 'attribute' => 'catalog',
            'payment-intent', 'payment-method', 'refund' => 'payment',
            'money', 'money-format' => 'currency',
            'exchange', 'exchange-rate' => 'exchange-rate',
            'media' => 'attachment',
            'index-record' => 'search',
            'commission-plan' => 'commission',
            default => $componentToView[$first] ?? ('' !== $first ? $first : 'view'),
        };
    }

    private function normalizeOperation(string $operation): string
    {
        $operation = strtolower(trim($operation));

        return '' !== $operation ? $operation : 'index';
    }
}
