<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Shell;

use App\Interfacing\Contract\ValueObject\InterfaceShellSlot;
use App\Interfacing\Contract\View\InterfaceShellFooterGroup;
use App\Interfacing\Contract\View\InterfaceShellFooterLink;
use App\Interfacing\Contract\View\InterfaceShellNavGroup;
use App\Interfacing\Contract\View\InterfaceShellNavItem;
use App\Interfacing\ProviderInterface\Crud\InterfaceCrudResourceExplorerProviderInterface;
use App\Interfacing\ProviderInterface\Shell\InterfaceShellChromeProviderInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

final class InterfaceShellChromeProvider implements InterfaceShellChromeProviderInterface
{
    /**
     * @var array<string, bool>
     */
    private array $routeExistsCache = [];

    /**
     * @var array<string, string>
     */
    private array $generatedUrlCache = [];

    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly RouterInterface $router,
        private readonly InterfaceCrudResourceExplorerProviderInterface $crudResourceExplorerProvider,
        #[Autowire(service: 'cache.app.recorder_inner')]
        private readonly CacheInterface $cache,
    ) {
    }

    /**
     * @param bool $includeResourceSummaries    include known CRUD resources and related summaries
     * @param bool $includeApplicationDashboard include the heavy application dashboard payload
     */
    public function provide(?string $activeId = null, bool $includeResourceSummaries = false, bool $includeApplicationDashboard = false): array
    {
        $request = $this->requestStack->getCurrentRequest();
        $query = null !== $request ? (string) $request->query->get('q', '') : '';

        $staticChrome = $this->cache->get('interfacing.shell.chrome.static.v67', function (ItemInterface $item): array {
            $item->expiresAfter(3600);

            return [
                'topLink' => $this->topLink(),
                'footerGroup' => $this->footerGroup(),
                'quickMenuGroup' => $this->quickMenuGroup(),
                'rightPanelGroup' => $this->rightPanelGroup(),
                'rightPanelEnabled' => true,
                'slotMap' => InterfaceShellSlot::labelMap(),
            ];
        });

        $shell = $staticChrome + [
            'activeId' => $activeId,
            'query' => $query,
            'navigation' => $this->navigationPayload(),
            'search' => [
                'provider' => 'antd-pro',
                'secondaryProvider' => 'primereact',
                'control' => 'search-input-group',
                'fallbackClass' => 'interfacing-provider-input-group',
                'submitMethod' => 'get',
                'submitAction' => '/search/result',
                'queryName' => 'q',
                'value' => $query,
                'placeholder' => 'Search products, categories, orders, screens...',
                'ownerComponent' => 'searching',
            ],
        ];

        if ($includeResourceSummaries) {
            $shell['knownCrudResources'] = $this->knownCrudResources();
        }

        if ($includeApplicationDashboard) {
            $shell['applicationDashboard'] = $this->applicationDashboard();
        }

        return $shell;
    }

    /**
     * @return array<string, mixed>
     */
    private function navigationPayload(): array
    {
        /*
         * Interfacing must compile standalone without a hard Navigation component dependency.
         * Neighbor components may still pass navigation data through the shell/location payload contract.
         */
        return [];
    }

    /** @return list<InterfaceShellNavItem> */
    private function topLink(): array
    {
        return [
            new InterfaceShellNavItem('workspace', 'Workspace', $this->safeUrl('interfacing_index', '/interfacing'), 'workspace', null, 10),
            new InterfaceShellNavItem('provider.catalog', 'Provider Catalog', '/catalog/', 'workspace', null, 11),
            new InterfaceShellNavItem('provider.vendor', 'Provider Vendors', '/vendor/', 'workspace', null, 12),
            new InterfaceShellNavItem('applications.dashboard', 'Applications', $this->safeUrl('interfacing_application_dashboard', '/interfacing/applications'), 'workspace', null, 15),
            new InterfaceShellNavItem('notifications', 'Notifications', $this->screenUrl('message.notifications.inbox'), 'workspace', null, 20),
            new InterfaceShellNavItem('admin.launchpad', 'Launchpad', $this->safeUrl('interfacing_admin_launchpad', '/interfacing/launchpad'), 'workspace', null, 28),
            new InterfaceShellNavItem('crud.explorer', 'CRUD Explorer', $this->safeUrl('interfacing_crud_explorer', '/interfacing/crud/explorer'), 'workspace', null, 30),
            new InterfaceShellNavItem('screen.directory', 'Screens', $this->safeUrl('interfacing_screen_directory', '/interfacing/screens'), 'workspace', null, 35),
            new InterfaceShellNavItem('shell.screens', 'Screen Catalog', $this->safeUrl('interfacing_shell_screen_catalog', '/interfacing/shell/screens'), 'workspace', null, 36),
            new InterfaceShellNavItem('shell.layout.preview', 'Layout Preview', $this->safeUrl('interfacing_shell_layout_preview', '/interfacing/shell/layout-preview'), 'workspace', null, 365),
            new InterfaceShellNavItem('operation.workbench', 'Operations', $this->safeUrl('interfacing_operation_workbench', '/interfacing/operations'), 'workspace', null, 37),
            new InterfaceShellNavItem('admin.tables', 'Tables', $this->safeUrl('interfacing_admin_tables', '/interfacing/tables'), 'workspace', null, 38),
            new InterfaceShellNavItem('crud.frames', 'Forms', $this->safeUrl('interfacing_crud_frames', '/interfacing/forms'), 'workspace', null, 385),
            new InterfaceShellNavItem('crud.affordances', 'Affordances', $this->safeUrl('interfacing_crud_affordances', '/interfacing/affordances'), 'workspace', null, 386),
            new InterfaceShellNavItem('crud.readiness', 'Readiness', $this->safeUrl('interfacing_crud_readiness', '/interfacing/readiness'), 'workspace', null, 387),
            new InterfaceShellNavItem('component.obligations', 'Obligations', $this->safeUrl('interfacing_component_obligations', '/interfacing/obligations'), 'workspace', null, 388),
            new InterfaceShellNavItem('runtime.handoff', 'Runtime handoff', $this->safeUrl('interfacing_runtime_handoff', '/interfacing/runtime-handoff'), 'workspace', null, 389),
            new InterfaceShellNavItem('promotion.gates', 'Promotion gates', $this->safeUrl('interfacing_promotion_gates', '/interfacing/promotions'), 'workspace', null, 390),
            new InterfaceShellNavItem('evidence.registry', 'Evidence', $this->safeUrl('interfacing_evidence_registry', '/interfacing/evidence'), 'workspace', null, 391),
            new InterfaceShellNavItem('contract.registry', 'Contracts', $this->safeUrl('interfacing_contract_registry', '/interfacing/contracts'), 'workspace', null, 392),
            new InterfaceShellNavItem('field.schema.registry', 'Schemas', $this->safeUrl('interfacing_field_schema_registry', '/interfacing/schemas'), 'workspace', null, 393),
            new InterfaceShellNavItem('surface.audit', 'Surface Audit', $this->safeUrl('interfacing_surface_audit', '/interfacing/surface'), 'workspace', null, 39),
            new InterfaceShellNavItem('shell.diagnostics', 'Shell Guard', $this->safeUrl('interfacing_shell_diagnostics', '/interfacing/shell/diagnostics'), 'workspace', null, 395),
            new InterfaceShellNavItem('shell.navigation', 'Shell Map', $this->safeUrl('interfacing_shell_navigation', '/interfacing/shell/navigation'), 'workspace', null, 396),
            new InterfaceShellNavItem('component.roadmap', 'Connected surfaces', $this->safeUrl('interfacing_component_roadmap', '/interfacing/components'), 'workspace', null, 40),
            new InterfaceShellNavItem('ecommerce.matrix', 'E-commerce Matrix', '/interfacing#ecommerce-screen-matrix', 'workspace', null, 42),
            new InterfaceShellNavItem('help', 'Help', '#help', 'workspace', null, 50),
            new InterfaceShellNavItem('account', 'Account', '#account', 'workspace', null, 60),
        ];
    }

    /** @return list<InterfaceShellFooterGroup> */
    private function footerGroup(): array
    {
        return [
            new InterfaceShellFooterGroup('commerce-core', 'Commerce core', [
                new InterfaceShellFooterLink('Catalog', '/catalog/'),
                new InterfaceShellFooterLink('Search index', '/index-record/'),
                new InterfaceShellFooterLink('Cart', '/cart/'),
                new InterfaceShellFooterLink('Orders', $this->safeUrl('interfacing_order_summary', '/interfacing/order/summary')),
                new InterfaceShellFooterLink('Payments', '/payment/'),
                new InterfaceShellFooterLink('Shipping', '/shipment/'),
                new InterfaceShellFooterLink('Taxation', '/taxation-api/'),
            ]),
            new InterfaceShellFooterGroup('commerce-finance', 'Commerce finance', [
                new InterfaceShellFooterLink('Currencies', '/currency/'),
                new InterfaceShellFooterLink('Money formats', '/money-format/'),
                new InterfaceShellFooterLink('Exchange rates', '/exchange-rate/'),
                new InterfaceShellFooterLink('Exchange quotes', '/exchange-quote/'),
                new InterfaceShellFooterLink('Subscriptions', '/subscription/'),
                new InterfaceShellFooterLink('Subscription plans', '/subscription-plan/'),
                new InterfaceShellFooterLink('Commission plans', '/commission-plan/'),
                new InterfaceShellFooterLink('Commission payouts', '/commission-payout/'),
            ]),
            new InterfaceShellFooterGroup('customer-account', 'Customer account', [
                new InterfaceShellFooterLink('Vendor index', '/vendor/'),
                new InterfaceShellFooterLink('My security', '/security/'),
                new InterfaceShellFooterLink('My cart', '/cart/'),
                new InterfaceShellFooterLink('My orders', '/manage/orders'),
                new InterfaceShellFooterLink('My subscription', '/subscription/'),
                new InterfaceShellFooterLink('Notifications', $this->screenUrl('message.notifications.inbox')),
            ]),
            new InterfaceShellFooterGroup('application-indexes', 'Application indexes', [
                new InterfaceShellFooterLink('Applications', $this->safeUrl('interfacing_application_dashboard', '/interfacing/applications')),
                new InterfaceShellFooterLink('Components', $this->safeUrl('interfacing_component_roadmap', '/interfacing/components')),
                new InterfaceShellFooterLink('CRUD Explorer', $this->safeUrl('interfacing_crud_explorer', '/interfacing/crud/explorer')),
                new InterfaceShellFooterLink('Screen Directory', $this->safeUrl('interfacing_screen_directory', '/interfacing/screens')),
                new InterfaceShellFooterLink('Screen Catalog', $this->safeUrl('interfacing_shell_screen_catalog', '/interfacing/shell/screens')),
                new InterfaceShellFooterLink('Operations', $this->safeUrl('interfacing_operation_workbench', '/interfacing/operations')),
            ]),
            new InterfaceShellFooterGroup('system-links', 'System links', [
                new InterfaceShellFooterLink('Locale selector', $this->screenUrl('localizing.locale.selector')),
                new InterfaceShellFooterLink('Shell Guard', $this->safeUrl('interfacing_shell_diagnostics', '/interfacing/shell/diagnostics')),
                new InterfaceShellFooterLink('Shell Map', $this->safeUrl('interfacing_shell_navigation', '/interfacing/shell/navigation')),
                new InterfaceShellFooterLink('Layout Preview', $this->safeUrl('interfacing_shell_layout_preview', '/interfacing/shell/layout-preview')),
                new InterfaceShellFooterLink('Contracts', $this->safeUrl('interfacing_contract_registry', '/interfacing/contracts')),
                new InterfaceShellFooterLink('Schemas', $this->safeUrl('interfacing_field_schema_registry', '/interfacing/schemas')),
            ]),
            new InterfaceShellFooterGroup('support-policy', 'Support & policy', [
                new InterfaceShellFooterLink('Help', '#help'),
                new InterfaceShellFooterLink('Support', '#support'),
                new InterfaceShellFooterLink('Privacy', '#privacy'),
                new InterfaceShellFooterLink('Terms', '#terms'),
                new InterfaceShellFooterLink('Security policy', '#security'),
                new InterfaceShellFooterLink('Status', '#status'),
            ]),
        ];
    }

    /** @return list<InterfaceShellNavGroup> */
    private function quickMenuGroup(): array
    {
        return [
            new InterfaceShellNavGroup('account-quick', 'My account', [
                new InterfaceShellNavItem('quick.profile', 'Vendor index', '/vendor/', 'account-quick', null, 10),
                new InterfaceShellNavItem('quick.security', 'My security', '/security/', 'account-quick', null, 20),
                new InterfaceShellNavItem('quick.notifications', 'Notifications', $this->screenUrl('message.notifications.inbox'), 'account-quick', null, 30),
                new InterfaceShellNavItem('quick.locale', 'Locale selector', $this->screenUrl('localizing.locale.selector'), 'account-quick', null, 40),
                new InterfaceShellNavItem('quick.switch-account', 'Switch account', $this->safeUrl('accessing_switch_account', '/switch-account'), 'account-quick', null, 50),
                new InterfaceShellNavItem('quick.sign-out', 'Sign out', $this->safeUrl('accessing_sign_out', '/interfacing/access/sign-out'), 'account-quick', null, 60),
            ]),
            new InterfaceShellNavGroup('commerce-quick', 'My commerce', [
                new InterfaceShellNavItem('quick.cart', 'My cart', '/cart/', 'commerce-quick', null, 10),
                new InterfaceShellNavItem('quick.orders', 'My orders', '/manage/orders', 'commerce-quick', null, 20),
                new InterfaceShellNavItem('quick.subscription', 'My subscription', '/subscription/', 'commerce-quick', null, 30),
                new InterfaceShellNavItem('quick.payments', 'Payments', '/payment/', 'commerce-quick', null, 40),
            ]),
            new InterfaceShellNavGroup('system-quick', 'System shortcuts', [
                new InterfaceShellNavItem('quick.applications', 'Applications', $this->safeUrl('interfacing_application_dashboard', '/interfacing/applications'), 'system-quick', null, 10),
                new InterfaceShellNavItem('quick.components', 'Components', $this->safeUrl('interfacing_component_roadmap', '/interfacing/components'), 'system-quick', null, 20),
                new InterfaceShellNavItem('quick.crud', 'CRUD Explorer', $this->safeUrl('interfacing_crud_explorer', '/interfacing/crud/explorer'), 'system-quick', null, 30),
                new InterfaceShellNavItem('quick.shell', 'Shell Map', $this->safeUrl('interfacing_shell_navigation', '/interfacing/shell/navigation'), 'system-quick', null, 40),
            ]),
        ];
    }

    /** @return list<InterfaceShellNavItem> */
    private function crudSectionItems(): array
    {
        $items = [
            new InterfaceShellNavItem('crud.explorer', 'CRUD explorer', $this->safeUrl('interfacing_crud_explorer', '/interfacing/crud/explorer'), 'crud', null, 10),
        ];

        $order = 20;
        foreach ($this->crudResourceExplorerProvider->provide() as $resource) {
            $items[] = new InterfaceShellNavItem(
                id: 'crud.resource.'.$resource->id(),
                title: $resource->component().' · '.$resource->label(),
                url: $resource->indexUrl(),
                group: 'crud',
                icon: null,
                order: $order,
            );
            $order += 10;
        }

        return $items;
    }

    private function detectActiveSection(?string $activeId, string $path): string
    {
        $needle = $activeId ?? '';
        $normalizedPath = '/' === $path ? '/' : rtrim($path, '/');

        if (str_starts_with($needle, 'message.') || str_starts_with($needle, 'messaging.') || '/interfacing/showcase/message' === $normalizedPath || str_starts_with($normalizedPath, '/interfacing/showcase/message/')) {
            return 'messaging';
        }
        if ('/catalog' === $normalizedPath || str_starts_with($normalizedPath, '/catalog/')) {
            return 'catalog';
        }
        if ('/interfacing/showcase/product' === $normalizedPath || str_starts_with($normalizedPath, '/interfacing/showcase/product') || '/interfacing/showcase/catalog/product' === $normalizedPath || str_starts_with($normalizedPath, '/interfacing/showcase/catalog/product')) {
            return 'product';
        }
        if ('/interfacing/showcase/project' === $normalizedPath || str_starts_with($normalizedPath, '/interfacing/showcase/project')) {
            return 'project';
        }
        if (str_contains($path, '/manage/orders') || '/manage/orders' === $normalizedPath || str_contains($needle, 'order')) {
            return 'orders';
        }
        if (str_contains($path, '/billing/') || str_contains($needle, 'billing')) {
            return 'billing';
        }
        if ($this->isCommerceFinancePath($path, $needle)) {
            return 'commerce-finance';
        }
        if (str_contains($path, '/access') || str_contains($needle, 'access') || str_contains($path, '/profile') || str_contains($path, '/security')) {
            return 'access';
        }

        return 'workspace';
    }

    private function isCommerceFinancePath(string $path, string $needle): bool
    {
        foreach ([
            'currency',
            'currency-metadata',
            'currency-minor-unit',
            'money-format',
            'money-normalization',
            'exchange-rate',
            'exchange-pair',
            'exchange-quote',
            'conversion-rule',
            'rate-provider',
            'subscription',
            'subscription-plan',
            'subscription-price',
            'subscription-entitlement',
            'subscription-event',
            'billing-cycle',
            'commission-plan',
            'commission-rule',
            'commission-agreement',
            'commission-accrual',
            'commission-payout',
            'commission-statement',
            'currencing',
            'exchanging',
            'subscripting',
            'commissioning',
        ] as $token) {
            if (str_contains($path, '/'.$token) || str_contains($needle, $token)) {
                return true;
            }
        }

        return false;
    }

    private function screenUrl(string $screenId): string
    {
        return $this->safeUrl('interfacing_screen', '/interfacing/'.$screenId, ['id' => $screenId]);
    }

    /**
     * @return list<InterfaceShellNavGroup>
     */
    private function rightPanelGroup(): array
    {
        return [
            new InterfaceShellNavGroup('application-dashboard', 'Application dashboard', [
                new InterfaceShellNavItem('applications.dashboard', 'Applications UI', $this->safeUrl('interfacing_application_dashboard', '/interfacing/applications'), 'applications', null, 10),
                new InterfaceShellNavItem('applications.dashboard.json', 'Applications JSON', $this->safeUrl('interfacing_application_dashboard_json', '/interfacing/applications.json'), 'applications', null, 20),
            ]),
            new InterfaceShellNavGroup('crud-exports', 'CRUD exports', [
                new InterfaceShellNavItem('crud.links.json', 'Links JSON', $this->safeUrl('interfacing_crud_explorer_links', '/interfacing/crud/explorer/links.json'), 'crud', null, 10),
                new InterfaceShellNavItem('crud.route.expectations', 'Route expectations', $this->safeUrl('interfacing_crud_explorer_route_expectations', '/interfacing/crud/explorer/route-expectations.json'), 'crud', null, 20),
                new InterfaceShellNavItem('crud.operations.json', 'Operations JSON', $this->safeUrl('interfacing_crud_explorer_operations', '/interfacing/crud/explorer/operations.json'), 'crud', null, 30),
                new InterfaceShellNavItem('crud.screens.json', 'Screens JSON', $this->safeUrl('interfacing_crud_explorer_screens', '/interfacing/crud/explorer/screens.json'), 'crud', null, 40),
            ]),
            new InterfaceShellNavGroup('shell-guard', 'Shell guard', [
                new InterfaceShellNavItem('shell.diagnostics', 'Panel diagnostics', $this->safeUrl('interfacing_shell_diagnostics', '/interfacing/shell/diagnostics'), 'shell', null, 10),
                new InterfaceShellNavItem('shell.diagnostics.json', 'Diagnostics JSON', $this->safeUrl('interfacing_shell_diagnostics_json', '/interfacing/shell/diagnostics.json'), 'shell', null, 20),
                new InterfaceShellNavItem('shell.navigation', 'Navigation map', $this->safeUrl('interfacing_shell_navigation', '/interfacing/shell/navigation'), 'shell', null, 30),
                new InterfaceShellNavItem('shell.navigation.json', 'Navigation JSON', $this->safeUrl('interfacing_shell_navigation_json', '/interfacing/shell/navigation.json'), 'shell', null, 40),
                new InterfaceShellNavItem('shell.screens', 'Screen catalog', $this->safeUrl('interfacing_shell_screen_catalog', '/interfacing/shell/screens'), 'shell', null, 50),
                new InterfaceShellNavItem('shell.screens.json', 'Screen catalog JSON', $this->safeUrl('interfacing_shell_screen_catalog_json', '/interfacing/shell/screens.json'), 'shell', null, 60),
                new InterfaceShellNavItem('shell.layout.preview', 'Layout preview', $this->safeUrl('interfacing_shell_layout_preview', '/interfacing/shell/layout-preview'), 'shell', null, 70),
                new InterfaceShellNavItem('shell.layout.preview.json', 'Layout preview JSON', $this->safeUrl('interfacing_shell_layout_preview_json', '/interfacing/shell/layout-preview.json'), 'shell', null, 80),
            ]),
            new InterfaceShellNavGroup('quick-crud', 'Quick CRUD', array_slice($this->crudSectionItems(), 0, 12)),
        ];
    }

    /**
     * @return array<string,mixed>
     */
    private function applicationDashboard(): array
    {
        return $this->cache->get('interfacing.shell.chrome.application-dashboard.v3', function (ItemInterface $item): array {
            $item->expiresAfter(3600);

            $components = [];
            $statusCounts = [
                'connected' => 0,
                'canonical' => 0,
                'planned' => 0,
                'other' => 0,
            ];
            $operationTotal = 0;

            foreach ($this->crudResourceExplorerProvider->provide() as $resource) {
                $component = $resource->component();
                $status = $resource->status();
                $statusKey = array_key_exists($status, $statusCounts) ? $status : 'other';
                ++$statusCounts[$statusKey];

                if (!isset($components[$component])) {
                    $components[$component] = [
                        'component' => $component,
                        'status' => $status,
                        'statusCounts' => [
                            'connected' => 0,
                            'canonical' => 0,
                            'planned' => 0,
                            'other' => 0,
                        ],
                        'resourceCount' => 0,
                        'operationCount' => 0,
                        'firstIndexUrl' => $resource->indexUrl(),
                        'resources' => [],
                    ];
                }

                ++$components[$component]['statusCounts'][$statusKey];
                ++$components[$component]['resourceCount'];
                $components[$component]['status'] = $this->strongerStatus((string) $components[$component]['status'], $status);

                $operations = $resource->operationUrls();
                $operationTotal += count($operations);
                $components[$component]['operationCount'] += count($operations);
                $components[$component]['resources'][] = [
                    'id' => $resource->id(),
                    'component' => $component,
                    'label' => $resource->label(),
                    'resourcePath' => $resource->resourcePath(),
                    'status' => $status,
                    'indexUrl' => $resource->indexUrl(),
                    'newUrl' => $resource->newUrl(),
                    'showSampleUrl' => $resource->showSampleUrl(),
                    'editSampleUrl' => $resource->editSampleUrl(),
                    'deleteSampleUrl' => $resource->deleteSampleUrl(),
                    'operations' => $operations,
                ];
            }

            $componentList = array_values($components);
            usort($componentList, static fn (array $left, array $right): int => [$left['component']] <=> [$right['component']]);

            return [
                'schema' => 'smart-responsor.interfacing.application-dashboard.v1',
                'summary' => [
                    'componentCount' => count($componentList),
                    'resourceCount' => array_sum(array_map(static fn (array $component): int => (int) $component['resourceCount'], $componentList)),
                    'operationCount' => $operationTotal,
                    'connectedResources' => $statusCounts['connected'],
                    'canonicalResources' => $statusCounts['canonical'],
                    'plannedResources' => $statusCounts['planned'],
                    'otherResources' => $statusCounts['other'],
                ],
                'statusCounts' => $statusCounts,
                'components' => $componentList,
                'contract' => [
                    'topPanelRequired' => true,
                    'leftPanelsRequired' => true,
                    'footerRequired' => true,
                    'crudHandoffPatternRequired' => true,
                    'note' => 'Connected, canonical and planned Smart Responsor components are intentionally visible so the host application can validate real CRUD address-bar patterns early.',
                ],
            ];
        });
    }

    private function strongerStatus(string $current, string $candidate): string
    {
        $priority = [
            'connected' => 300,
            'canonical' => 200,
            'planned' => 100,
        ];

        return ($priority[$candidate] ?? 0) > ($priority[$current] ?? 0) ? $candidate : $current;
    }

    /**
     * @return list<array{id:string,component:string,label:string,resourcePath:string,status:string,indexUrl:string,newUrl:string,showSampleUrl:string,editSampleUrl:string,deleteSampleUrl:string}>
     */
    private function knownCrudResources(): array
    {
        return $this->cache->get('interfacing.shell.chrome.known-crud-resources.v3', function (ItemInterface $item): array {
            $item->expiresAfter(3600);

            $resources = [];
            foreach ($this->crudResourceExplorerProvider->provide() as $resource) {
                $resources[] = [
                    'id' => $resource->id(),
                    'component' => $resource->component(),
                    'label' => $resource->label(),
                    'resourcePath' => $resource->resourcePath(),
                    'status' => $resource->status(),
                    'indexUrl' => $resource->indexUrl(),
                    'newUrl' => $resource->newUrl(),
                    'showSampleUrl' => $resource->showSampleUrl(),
                    'editSampleUrl' => $resource->editSampleUrl(),
                    'deleteSampleUrl' => $resource->deleteSampleUrl(),
                ];
            }

            return $resources;
        });
    }

    /**
     * @param array<string, string> $parameters
     */
    private function safeUrl(string $route, string $fallback, array $parameters = []): string
    {
        $cacheKey = $route.'|'.md5(json_encode($parameters, JSON_THROW_ON_ERROR));

        if (array_key_exists($cacheKey, $this->generatedUrlCache)) {
            return $this->generatedUrlCache[$cacheKey];
        }

        if (array_key_exists($route, $this->routeExistsCache) && !$this->routeExistsCache[$route]) {
            return $this->generatedUrlCache[$cacheKey] = $fallback;
        }

        if (null === $this->router->getRouteCollection()?->get($route)) {
            $this->routeExistsCache[$route] = false;

            return $this->generatedUrlCache[$cacheKey] = $fallback;
        }

        $this->routeExistsCache[$route] = true;

        try {
            return $this->generatedUrlCache[$cacheKey] = $this->router->generate($route, $parameters);
        } catch (\Throwable) {
            return $this->generatedUrlCache[$cacheKey] = $fallback;
        }
    }
}
