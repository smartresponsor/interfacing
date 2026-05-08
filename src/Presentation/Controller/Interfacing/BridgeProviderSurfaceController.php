<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

namespace App\Interfacing\Presentation\Controller\Interfacing;

use App\Interfacing\Kernel;
use App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * Bridge-facing provider surface for visible component routes.
 *
 * This controller does not own Cataloging, Cruding, Vendoring, or any other
 * business component. It gives the Bridge/interface layer a stable Interfacing
 * endpoint/template for provider-rendered admin/workbench pages.
 */
final readonly class BridgeProviderSurfaceController
{
    public function __construct(
        private InterfacingRendererInterface $renderer,
        #[Autowire(service: 'profiler')]
        private ?Profiler $profiler,
        #[Autowire(service: 'cache.app.recorder_inner')]
        private CacheInterface $responseCache,
    ) {
    }

    #[Route('/interfacing/bridge/provider/{resourcePath}', name: 'interfacing_bridge_provider_surface', requirements: ['resourcePath' => '[a-z0-9][a-z0-9/_-]{0,160}'], methods: ['GET'])]
    public function show(Request $request, string $resourcePath): Response
    {
        $operation = $request->query->get('operation', 'index');

        return $this->renderProviderSurface($request, $resourcePath, is_string($operation) && '' !== $operation ? $operation : 'index');
    }

    #[Route('/{visiblePath}', name: 'interfacing_bridge_visible_provider_surface', requirements: ['visiblePath' => '(?:catalog|category|product|collection|attribute|crud|cruding|vendor|vendoring)(?:/[a-z0-9][a-z0-9/_-]{0,160})?/?'], methods: ['GET'], priority: 900)]
    public function visible(Request $request, string $visiblePath): Response
    {
        [$resourcePath, $operation] = $this->normalizeVisiblePath($visiblePath);

        return $this->renderProviderSurface($request, $resourcePath, $operation);
    }

    private function renderProviderSurface(Request $request, string $resourcePath, string $operation): Response
    {
        if (null !== $this->profiler) {
            $this->profiler->disable();
        }

        $startedAt = hrtime(true);
        $component = $request->query->get('component', $this->inferComponent($resourcePath));
        $title = $request->query->get('title', $this->humanize($resourcePath));
        $normalizedResourcePath = str_replace('_', '-', trim($resourcePath, '/'));
        $normalizedComponent = is_string($component) && '' !== $component ? $component : $this->inferComponent($normalizedResourcePath);
        $cacheKey = 'interfacing.bridge-provider.html.v2.'.sha1($request->getRequestUri());

        $cacheHit = true;
        $html = $this->responseCache->get($cacheKey, function (ItemInterface $item) use ($normalizedComponent, $normalizedResourcePath, $operation, $title, &$cacheHit): string {
            $cacheHit = false;
            $item->expiresAfter(300);

            return $this->renderer->render('interfacing/bridge/provider_surface.html.twig', [
                'bridgeComponent' => $normalizedComponent,
                'bridgeResource' => $normalizedResourcePath,
                'bridgeOperation' => '' !== $operation ? $operation : 'index',
                'bridgeSurface' => 'admin',
                'bridgeTitle' => is_string($title) && '' !== $title ? $title : $this->humanize($normalizedResourcePath),
                'bridgeRows' => $this->seedRows($normalizedResourcePath, $normalizedComponent),
                'bridgeColumns' => $this->columnsFor($normalizedComponent),
                'bridgeFilters' => $this->filtersFor($normalizedComponent),
                'bridgeFormFields' => $this->formFieldsFor($normalizedComponent),
                'disableProfiler' => true,
            ])->getContent();
        });

        $response = new Response($html);
        $response->headers->set('X-Interfacing-Cache', $cacheHit ? 'hit' : 'miss');
        $response->headers->set('X-Interfacing-Controller-ms', number_format((hrtime(true) - $startedAt) / 1_000_000, 2, '.', ''));
        $response->headers->set('X-Interfacing-KernelBoot-ms', number_format(Kernel::lastBootMs() ?? 0.0, 2, '.', ''));

        return $response;
    }

    /**
     * @return array{0: string, 1: string}
     */
    private function normalizeVisiblePath(string $visiblePath): array
    {
        $segments = array_values(array_filter(explode('/', trim($visiblePath, '/')), static fn (string $segment): bool => '' !== $segment));
        $operation = 'index';

        if ([] === $segments) {
            return ['catalog', $operation];
        }

        $last = end($segments) ?: '';
        if (in_array($last, ['new', 'edit', 'delete'], true)) {
            $operation = $last;
            array_pop($segments);
        }

        return [implode('/', $segments) ?: 'catalog', $operation];
    }

    /**
     * @return list<array<string, string>>
     */
    private function columnsFor(string $component): array
    {
        return match ($component) {
            'cataloging' => [
                ['key' => 'title', 'label' => 'Product title', 'type' => 'text', 'isCode' => false, 'isStatus' => false],
                ['key' => 'sku', 'label' => 'SKU', 'type' => 'text', 'isCode' => true, 'isStatus' => false],
                ['key' => 'category', 'label' => 'Category', 'type' => 'text', 'isCode' => false, 'isStatus' => false],
                ['key' => 'inventory', 'label' => 'Inventory', 'type' => 'text', 'isCode' => false, 'isStatus' => false],
                ['key' => 'status', 'label' => 'Status', 'type' => 'text', 'isCode' => false, 'isStatus' => true],
                ['key' => 'price', 'label' => 'Price', 'type' => 'text', 'isCode' => false, 'isStatus' => false],
            ],
            'vendoring' => [
                ['key' => 'title', 'label' => 'Vendor', 'type' => 'text', 'isCode' => false, 'isStatus' => false],
                ['key' => 'code', 'label' => 'Code', 'type' => 'text', 'isCode' => true, 'isStatus' => false],
                ['key' => 'status', 'label' => 'Status', 'type' => 'text', 'isCode' => false, 'isStatus' => true],
                ['key' => 'channel', 'label' => 'Channel', 'type' => 'text', 'isCode' => false, 'isStatus' => false],
                ['key' => 'sla', 'label' => 'SLA', 'type' => 'text', 'isCode' => false, 'isStatus' => false],
            ],
            default => [
                ['key' => 'title', 'label' => 'Title', 'type' => 'text', 'isCode' => false, 'isStatus' => false],
                ['key' => 'code', 'label' => 'Code', 'type' => 'text', 'isCode' => true, 'isStatus' => false],
                ['key' => 'owner', 'label' => 'Owner', 'type' => 'text', 'isCode' => false, 'isStatus' => false],
                ['key' => 'status', 'label' => 'Status', 'type' => 'text', 'isCode' => false, 'isStatus' => true],
                ['key' => 'locale', 'label' => 'Locale', 'type' => 'text', 'isCode' => false, 'isStatus' => false],
            ],
        };
    }

    /**
     * @return list<array<string, string|null>>
     */
    private function filtersFor(string $component): array
    {
        return [
            ['name' => 'q', 'label' => 'Search', 'type' => 'text', 'value' => null, 'placeholder' => 'Search '.$this->humanize($component), 'options' => []],
            ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'value' => null, 'placeholder' => 'Any status', 'options' => []],
        ];
    }

    /**
     * @return list<array<string, bool|string|null>>
     */
    private function formFieldsFor(string $component): array
    {
        return [
            ['name' => 'title', 'label' => 'cataloging' === $component ? 'Product title' : 'Title', 'type' => 'text', 'value' => null, 'placeholder' => null, 'helpText' => null, 'required' => true, 'validationState' => null, 'errorText' => null, 'options' => []],
            ['name' => 'slug', 'label' => 'Slug', 'type' => 'text', 'value' => null, 'placeholder' => null, 'helpText' => null, 'required' => false, 'validationState' => null, 'errorText' => null, 'options' => []],
            ['name' => 'status', 'label' => 'Status', 'type' => 'text', 'value' => null, 'placeholder' => null, 'helpText' => null, 'required' => false, 'validationState' => null, 'errorText' => null, 'options' => []],
            ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'value' => null, 'placeholder' => null, 'helpText' => null, 'required' => false, 'validationState' => null, 'errorText' => null, 'options' => []],
        ];
    }

    /**
     * @return list<array<string, string>>
     */
    private function seedRows(string $resourcePath, string $component): array
    {
        return match ($component) {
            'cataloging' => [
                ['id' => 'catalog-1', 'title' => 'Canonical product page', 'sku' => 'CAT-UI-001', 'category' => 'Storefront', 'inventory' => '84 in stock', 'status' => 'active', 'price' => '$149.00'],
                ['id' => 'catalog-2', 'title' => 'Bundle landing card', 'sku' => 'CAT-UI-002', 'category' => 'Bundles', 'inventory' => '22 in stock', 'status' => 'draft', 'price' => '$249.00'],
                ['id' => 'catalog-3', 'title' => 'Merchandising collection', 'sku' => 'CAT-UI-003', 'category' => 'Collections', 'inventory' => 'ready', 'status' => 'active', 'price' => '$399.00'],
            ],
            'vendoring' => [
                ['id' => 'vendor-1', 'title' => 'Primary marketplace vendor', 'code' => 'VEN-001', 'status' => 'active', 'channel' => 'marketplace', 'sla' => '99.5%'],
                ['id' => 'vendor-2', 'title' => 'Dropship supplier', 'code' => 'VEN-002', 'status' => 'review', 'channel' => 'supplier', 'sla' => 'pending'],
                ['id' => 'vendor-3', 'title' => 'Fulfillment partner', 'code' => 'VEN-003', 'status' => 'active', 'channel' => 'fulfillment', 'sla' => '98.7%'],
            ],
            default => [
                ['id' => $resourcePath.'-1', 'title' => $this->humanize($resourcePath).' resource', 'code' => strtoupper(str_replace('/', '-', $resourcePath)).'-001', 'owner' => $component, 'status' => 'active', 'locale' => 'en'],
                ['id' => $resourcePath.'-2', 'title' => $this->humanize($resourcePath).' workflow', 'code' => strtoupper(str_replace('/', '-', $resourcePath)).'-002', 'owner' => $component, 'status' => 'draft', 'locale' => 'en'],
            ],
        };
    }

    private function inferComponent(string $resourcePath): string
    {
        $first = strtolower(strtok(str_replace('_', '/', $resourcePath), '/') ?: $resourcePath);

        return match ($first) {
            'catalog', 'category', 'product' => 'cataloging',
            'crud', 'relation', 'object' => 'cruding',
            'vendor', 'merchant' => 'vendoring',
            'order' => 'ordering',
            'payment', 'refund' => 'paying',
            'shipping', 'shipment' => 'shipping',
            'tax' => 'taxating',
            'currency', 'money' => 'currencing',
            'message' => 'messaging',
            'location', 'address' => 'locating',
            'search', 'index' => 'indexing',
            default => 'bridge',
        };
    }

    private function humanize(string $resourcePath): string
    {
        $text = str_replace(['_', '-', '/'], ' ', $resourcePath);
        $text = preg_replace('/\\s+/', ' ', $text) ?: $resourcePath;

        return ucwords(trim($text));
    }
}
