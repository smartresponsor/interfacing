<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Shell;

use App\Interfacing\Contract\ValueObject\ShellSlot;
use App\Interfacing\Contract\View\ShellFooterGroup;
use App\Interfacing\Contract\View\ShellFooterLink;
use App\Interfacing\Contract\View\ShellNavGroup;
use App\Interfacing\Contract\View\ShellNavItem;
use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceExplorerProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Shell\ShellChromeProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class ShellChromeProvider implements ShellChromeProviderInterface
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly UrlGeneratorInterface $url,
        private readonly CrudResourceExplorerProviderInterface $crudResourceExplorerProvider,
    ) {
    }

    public function provide(?string $activeId = null): array
    {
        static $cache = [];
        $request = $this->requestStack->getCurrentRequest();
        $path = null !== $request ? (string) $request->getPathInfo() : '';
        $query = null !== $request ? (string) $request->query->get('q', '') : '';
        $cacheKey = implode('|', [
            null === $activeId ? '__default__' : $activeId,
            $path,
            $query,
        ]);

        if (array_key_exists($cacheKey, $cache)) {
            return $cache[$cacheKey];
        }

        $activeSection = $this->detectActiveSection($activeId, $path);
        $topLink = $this->topLink();
        $primaryGroup = $this->primaryGroup($activeSection);
        $sectionGroup = $this->sectionGroup($activeSection);
        $footerGroup = $this->footerGroup();

        return $cache[$cacheKey] = [
            'activeId' => $activeId,
            'activeSection' => $activeSection,
            'query' => $query,
            'topLink' => $topLink,
            'primaryGroup' => $primaryGroup,
            'sectionGroup' => $sectionGroup,
            'footerGroup' => $footerGroup,
            'rightPanelGroup' => $this->rightPanelGroup(),
            'rightPanelEnabled' => true,
            'knownCrudResources' => $this->knownCrudResources(),
            'applicationDashboard' => $this->applicationDashboard(),
            'slotMap' => ShellSlot::labelMap(),
            'itemTotal' => array_reduce(
                array_merge($primaryGroup, $sectionGroup),
                static fn (int $carry, ShellNavGroup $group): int => $carry + count($group->item()),
                0,
            ),
            'group' => array_merge(
                array_map([$this, 'legacyGroup'], $primaryGroup),
                array_map([$this, 'legacyGroup'], $sectionGroup),
            ),
        ];
    }

    /** @return list<ShellNavItem> */
    private function topLink(): array
    {
        return [
            new ShellNavItem('workspace', 'Workspace', $this->safeUrl('interfacing_index', '/interfacing'), 'workspace', null, 10),
            new ShellNavItem('applications.dashboard', 'Applications', $this->safeUrl('interfacing_application_dashboard', '/interfacing/applications'), 'workspace', null, 15),
            new ShellNavItem('notifications', 'Notifications', $this->screenUrl('message.notifications.inbox'), 'workspace', null, 20),
            new ShellNavItem('admin.launchpad', 'Launchpad', $this->safeUrl('interfacing_admin_launchpad', '/interfacing/launchpad'), 'workspace', null, 28),
            new ShellNavItem('crud.explorer', 'CRUD Explorer', $this->safeUrl('interfacing_crud_explorer', '/interfacing/crud/explorer'), 'workspace', null, 30),
            new ShellNavItem('screen.directory', 'Screens', $this->safeUrl('interfacing_screen_directory', '/interfacing/screens'), 'workspace', null, 35),
            new ShellNavItem('shell.screens', 'Screen Catalog', $this->safeUrl('interfacing_shell_screen_catalog', '/interfacing/shell/screens'), 'workspace', null, 36),
            new ShellNavItem('shell.layout.preview', 'Layout Preview', $this->safeUrl('interfacing_shell_layout_preview', '/interfacing/shell/layout-preview'), 'workspace', null, 365),
            new ShellNavItem('operation.workbench', 'Operations', $this->safeUrl('interfacing_operation_workbench', '/interfacing/operations'), 'workspace', null, 37),
            new ShellNavItem('admin.tables', 'Tables', $this->safeUrl('interfacing_admin_tables', '/interfacing/tables'), 'workspace', null, 38),
            new ShellNavItem('crud.frames', 'Forms', $this->safeUrl('interfacing_crud_frames', '/interfacing/forms'), 'workspace', null, 385),
            new ShellNavItem('crud.affordances', 'Affordances', $this->safeUrl('interfacing_crud_affordances', '/interfacing/affordances'), 'workspace', null, 386),
            new ShellNavItem('crud.readiness', 'Readiness', $this->safeUrl('interfacing_crud_readiness', '/interfacing/readiness'), 'workspace', null, 387),
            new ShellNavItem('component.obligations', 'Obligations', $this->safeUrl('interfacing_component_obligations', '/interfacing/obligations'), 'workspace', null, 388),
            new ShellNavItem('runtime.bridges', 'Runtime bridges', $this->safeUrl('interfacing_runtime_bridges', '/interfacing/bridges'), 'workspace', null, 389),
            new ShellNavItem('promotion.gates', 'Promotion gates', $this->safeUrl('interfacing_promotion_gates', '/interfacing/promotions'), 'workspace', null, 390),
            new ShellNavItem('evidence.registry', 'Evidence', $this->safeUrl('interfacing_evidence_registry', '/interfacing/evidence'), 'workspace', null, 391),
            new ShellNavItem('contract.registry', 'Contracts', $this->safeUrl('interfacing_contract_registry', '/interfacing/contracts'), 'workspace', null, 392),
            new ShellNavItem('field.schema.registry', 'Schemas', $this->safeUrl('interfacing_field_schema_registry', '/interfacing/schemas'), 'workspace', null, 393),
            new ShellNavItem('surface.audit', 'Surface Audit', $this->safeUrl('interfacing_surface_audit', '/interfacing/surface'), 'workspace', null, 39),
            new ShellNavItem('shell.diagnostics', 'Shell Guard', $this->safeUrl('interfacing_shell_diagnostics', '/interfacing/shell/diagnostics'), 'workspace', null, 395),
            new ShellNavItem('shell.navigation', 'Shell Map', $this->safeUrl('interfacing_shell_navigation', '/interfacing/shell/navigation'), 'workspace', null, 396),
            new ShellNavItem('component.roadmap', 'Components', $this->safeUrl('interfacing_component_roadmap', '/interfacing/components'), 'workspace', null, 40),
            new ShellNavItem('ecommerce.matrix', 'E-commerce Matrix', '/interfacing#ecommerce-screen-matrix', 'workspace', null, 42),
            new ShellNavItem('help', 'Help', '#help', 'workspace', null, 50),
            new ShellNavItem('account', 'Account', '#account', 'workspace', null, 60),
        ];
    }

    /** @return list<ShellNavGroup> */
    private function primaryGroup(string $activeSection): array
    {
        return [
            new ShellNavGroup('platform', 'Platform', [
                new ShellNavItem('workspace.home', 'Workspace', $this->safeUrl('interfacing_index', '/interfacing'), 'platform', null, 10),
                new ShellNavItem('applications.dashboard', 'Applications', $this->safeUrl('interfacing_application_dashboard', '/interfacing/applications'), 'platform', null, 15),
                new ShellNavItem('access', 'Access', '/access', 'platform', null, 20),
                new ShellNavItem('messaging', 'Messaging', $this->screenUrl('message.notifications.inbox'), 'platform', null, 30),
                new ShellNavItem('billing', 'Billing', $this->safeUrl('interfacing_billing_meter', '/interfacing/billing/meter'), 'platform', null, 40),
                new ShellNavItem('currencing', 'Currencies', '/currency/', 'platform', null, 42),
                new ShellNavItem('exchanging', 'Exchange rates', '/exchange-rate/', 'platform', null, 44),
                new ShellNavItem('subscripting', 'Subscriptions', '/subscription/', 'platform', null, 46),
                new ShellNavItem('commissioning', 'Commissions', '/commission-plan/', 'platform', null, 48),
                new ShellNavItem('orders', 'Orders', $this->safeUrl('interfacing_order_summary', '/interfacing/order/summary'), 'platform', null, 50),
                new ShellNavItem('catalog', 'Catalog', '/category/', 'platform', null, 60),
                new ShellNavItem('admin.launchpad', 'Launchpad', $this->safeUrl('interfacing_admin_launchpad', '/interfacing/launchpad'), 'platform', null, 68),
                new ShellNavItem('crud', 'CRUD', $this->safeUrl('interfacing_crud_explorer', '/interfacing/crud/explorer'), 'platform', null, 70),
                new ShellNavItem('screen.directory', 'Screens', $this->safeUrl('interfacing_screen_directory', '/interfacing/screens'), 'platform', null, 73),
                new ShellNavItem('shell.screens', 'Screen Catalog', $this->safeUrl('interfacing_shell_screen_catalog', '/interfacing/shell/screens'), 'platform', null, 735),
                new ShellNavItem('shell.layout.preview', 'Layout Preview', $this->safeUrl('interfacing_shell_layout_preview', '/interfacing/shell/layout-preview'), 'platform', null, 736),
                new ShellNavItem('operation.workbench', 'Operations', $this->safeUrl('interfacing_operation_workbench', '/interfacing/operations'), 'platform', null, 74),
                new ShellNavItem('admin.tables', 'Tables', $this->safeUrl('interfacing_admin_tables', '/interfacing/tables'), 'platform', null, 745),
                new ShellNavItem('crud.frames', 'Forms', $this->safeUrl('interfacing_crud_frames', '/interfacing/forms'), 'platform', null, 746),
                new ShellNavItem('crud.affordances', 'Affordances', $this->safeUrl('interfacing_crud_affordances', '/interfacing/affordances'), 'platform', null, 747),
                new ShellNavItem('crud.readiness', 'Readiness', $this->safeUrl('interfacing_crud_readiness', '/interfacing/readiness'), 'platform', null, 748),
                new ShellNavItem('component.obligations', 'Obligations', $this->safeUrl('interfacing_component_obligations', '/interfacing/obligations'), 'platform', null, 749),
                new ShellNavItem('runtime.bridges', 'Bridges', $this->safeUrl('interfacing_runtime_bridges', '/interfacing/bridges'), 'platform', null, 750),
                new ShellNavItem('promotion.gates', 'Promotion gates', $this->safeUrl('interfacing_promotion_gates', '/interfacing/promotions'), 'platform', null, 751),
                new ShellNavItem('contract.registry', 'Contracts', $this->safeUrl('interfacing_contract_registry', '/interfacing/contracts'), 'platform', null, 752),
                new ShellNavItem('field.schema.registry', 'Schemas', $this->safeUrl('interfacing_field_schema_registry', '/interfacing/schemas'), 'platform', null, 753),
                new ShellNavItem('ecommerce.matrix', 'E-commerce Matrix', '/interfacing#ecommerce-screen-matrix', 'platform', null, 75),
                new ShellNavItem('surface.audit', 'Surface Audit', $this->safeUrl('interfacing_surface_audit', '/interfacing/surface'), 'platform', null, 76),
                new ShellNavItem('shell.diagnostics', 'Shell Guard', $this->safeUrl('interfacing_shell_diagnostics', '/interfacing/shell/diagnostics'), 'platform', null, 765),
                new ShellNavItem('shell.navigation', 'Shell Map', $this->safeUrl('interfacing_shell_navigation', '/interfacing/shell/navigation'), 'platform', null, 766),
                new ShellNavItem('component.roadmap', 'Components', $this->safeUrl('interfacing_component_roadmap', '/interfacing/components'), 'platform', null, 77),
                new ShellNavItem('taxation', 'Taxation', '/taxation-api/', 'platform', null, 80),
            ]),
        ];
    }

    /** @return list<ShellNavGroup> */
    private function sectionGroup(string $activeSection): array
    {
        return match ($activeSection) {
            'messaging' => [new ShellNavGroup('messaging', 'Messaging', [
                new ShellNavItem('message.notifications.inbox', 'Inbox', $this->screenUrl('message.notifications.inbox'), 'messaging', null, 10),
                new ShellNavItem('message.rooms.collection', 'Rooms', $this->screenUrl('message.rooms.collection'), 'messaging', null, 20),
                new ShellNavItem('message.search.results', 'Search', $this->screenUrl('message.search.results'), 'messaging', null, 30),
                new ShellNavItem('message.threads.placeholder', 'Threads', '#message-threads', 'messaging', null, 40),
            ])],
            'orders' => [new ShellNavGroup('orders', 'Orders', [
                new ShellNavItem('interfacing.order.summary', 'Order summary', $this->safeUrl('interfacing_order_summary', '/interfacing/order/summary'), 'orders', null, 10),
            ])],
            'billing' => [new ShellNavGroup('billing', 'Billing', [
                new ShellNavItem('interfacing.billing.meter', 'Meters', $this->safeUrl('interfacing_billing_meter', '/interfacing/billing/meter'), 'billing', null, 10),
            ])],
            'commerce-finance' => [new ShellNavGroup('commerce-finance', 'Commerce finance', [
                new ShellNavItem('currencing.currency', 'Currencies', '/currency/', 'commerce-finance', null, 10),
                new ShellNavItem('currencing.money-format', 'Money formats', '/money-format/', 'commerce-finance', null, 20),
                new ShellNavItem('exchanging.exchange-rate', 'Exchange rates', '/exchange-rate/', 'commerce-finance', null, 30),
                new ShellNavItem('exchanging.exchange-quote', 'Exchange quotes', '/exchange-quote/', 'commerce-finance', null, 40),
                new ShellNavItem('subscripting.subscription', 'Subscriptions', '/subscription/', 'commerce-finance', null, 50),
                new ShellNavItem('subscripting.subscription-plan', 'Plans', '/subscription-plan/', 'commerce-finance', null, 60),
                new ShellNavItem('commissioning.commission-plan', 'Commission plans', '/commission-plan/', 'commerce-finance', null, 70),
                new ShellNavItem('commissioning.commission-payout', 'Commission payouts', '/commission-payout/', 'commerce-finance', null, 80),
            ])],
            'workspace', 'screens' => [new ShellNavGroup('workspace', 'Workspace', [
                new ShellNavItem('workspace.home', 'Overview', $this->safeUrl('interfacing_index', '/interfacing'), 'workspace', null, 10),
                new ShellNavItem('admin.launchpad', 'Admin launchpad', $this->safeUrl('interfacing_admin_launchpad', '/interfacing/launchpad'), 'workspace', null, 15),
                new ShellNavItem('applications.dashboard', 'Applications dashboard', $this->safeUrl('interfacing_application_dashboard', '/interfacing/applications'), 'workspace', null, 16),
                new ShellNavItem('interfacing.doctor', 'Doctor', $this->screenUrl('interfacing-doctor'), 'workspace', null, 20),
                new ShellNavItem('crud.explorer', 'CRUD explorer', $this->safeUrl('interfacing_crud_explorer', '/interfacing/crud/explorer'), 'workspace', null, 30),
                new ShellNavItem('screen.directory', 'Screen directory', $this->safeUrl('interfacing_screen_directory', '/interfacing/screens'), 'workspace', null, 33),
                new ShellNavItem('shell.screens', 'Shell screen catalog', $this->safeUrl('interfacing_shell_screen_catalog', '/interfacing/shell/screens'), 'workspace', null, 335),
                new ShellNavItem('operation.workbench', 'Operation workbench', $this->safeUrl('interfacing_operation_workbench', '/interfacing/operations'), 'workspace', null, 34),
                new ShellNavItem('admin.tables', 'Admin tables', $this->safeUrl('interfacing_admin_tables', '/interfacing/tables'), 'workspace', null, 345),
                new ShellNavItem('crud.frames', 'CRUD frames', $this->safeUrl('interfacing_crud_frames', '/interfacing/forms'), 'workspace', null, 346),
                new ShellNavItem('crud.affordances', 'CRUD affordances', $this->safeUrl('interfacing_crud_affordances', '/interfacing/affordances'), 'workspace', null, 347),
                new ShellNavItem('crud.readiness', 'CRUD readiness', $this->safeUrl('interfacing_crud_readiness', '/interfacing/readiness'), 'workspace', null, 348),
                new ShellNavItem('component.obligations', 'Component obligations', $this->safeUrl('interfacing_component_obligations', '/interfacing/obligations'), 'workspace', null, 349),
                new ShellNavItem('runtime.bridges', 'Runtime bridges', $this->safeUrl('interfacing_runtime_bridges', '/interfacing/bridges'), 'workspace', null, 350),
                new ShellNavItem('promotion.gates', 'Promotion gates', $this->safeUrl('interfacing_promotion_gates', '/interfacing/promotions'), 'workspace', null, 351),
                new ShellNavItem('evidence.registry', 'Evidence registry', $this->safeUrl('interfacing_evidence_registry', '/interfacing/evidence'), 'workspace', null, 352),
                new ShellNavItem('contract.registry', 'Contract registry', $this->safeUrl('interfacing_contract_registry', '/interfacing/contracts'), 'workspace', null, 353),
                new ShellNavItem('field.schema.registry', 'Field schema registry', $this->safeUrl('interfacing_field_schema_registry', '/interfacing/schemas'), 'workspace', null, 354),
                new ShellNavItem('ecommerce.matrix', 'E-commerce matrix', '/interfacing#ecommerce-screen-matrix', 'workspace', null, 35),
                new ShellNavItem('surface.audit', 'Surface audit', $this->safeUrl('interfacing_surface_audit', '/interfacing/surface'), 'workspace', null, 36),
                new ShellNavItem('shell.navigation', 'Shell navigation map', $this->safeUrl('interfacing_shell_navigation', '/interfacing/shell/navigation'), 'workspace', null, 365),
                new ShellNavItem('shell.layout.preview', 'Shell layout preview', $this->safeUrl('interfacing_shell_layout_preview', '/interfacing/shell/layout-preview'), 'workspace', null, 366),
                new ShellNavItem('component.roadmap', 'Component roadmap', $this->safeUrl('interfacing_component_roadmap', '/interfacing/components'), 'workspace', null, 37),
                new ShellNavItem('interfacing.health', 'Health', $this->safeUrl('interfacing_health', '/interfacing/health'), 'workspace', null, 40),
            ])],
            'access' => [new ShellNavGroup('access', 'Access', [
                new ShellNavItem('access.account.overview', 'Account overview', '#access-account-overview', 'access', null, 10),
                new ShellNavItem('access.sessions', 'Sessions', '#access-sessions', 'access', null, 20),
                new ShellNavItem('access.security.events', 'Security events', '#access-security-events', 'access', null, 30),
                new ShellNavItem('access.registration', 'Registration', '#access-registration', 'access', null, 40),
            ])],
            'crud' => [new ShellNavGroup('crud', 'Typical CRUD', $this->crudSectionItems())],
            default => [new ShellNavGroup('workspace', 'Workspace', [
                new ShellNavItem('workspace.home', 'Overview', $this->safeUrl('interfacing_index', '/interfacing'), 'workspace', null, 10),
                new ShellNavItem('message.notifications.inbox', 'Messaging inbox', $this->screenUrl('message.notifications.inbox'), 'workspace', null, 20),
                new ShellNavItem('interfacing.order.summary', 'Order summary', $this->safeUrl('interfacing_order_summary', '/interfacing/order/summary'), 'workspace', null, 30),
                new ShellNavItem('interfacing.billing.meter', 'Billing meter', $this->safeUrl('interfacing_billing_meter', '/interfacing/billing/meter'), 'workspace', null, 40),
            ])],
        };
    }

    /** @return list<ShellFooterGroup> */
    private function footerGroup(): array
    {
        return [
            new ShellFooterGroup('help', 'Help', [
                new ShellFooterLink('FAQ', '#faq'),
                new ShellFooterLink('Docs', '#docs'),
                new ShellFooterLink('Support', '#support'),
            ]),
            new ShellFooterGroup('policy', 'Policy', [
                new ShellFooterLink('Privacy', '#privacy'),
                new ShellFooterLink('Terms', '#terms'),
                new ShellFooterLink('Security', '#security'),
            ]),
            new ShellFooterGroup('explore', 'Explore', [
                new ShellFooterLink('Messaging', $this->screenUrl('message.notifications.inbox')),
                new ShellFooterLink('Orders', $this->safeUrl('interfacing_order_summary', '/interfacing/order/summary')),
                new ShellFooterLink('Billing', $this->safeUrl('interfacing_billing_meter', '/interfacing/billing/meter')),
                new ShellFooterLink('Currencies', '/currency/'),
                new ShellFooterLink('Exchange rates', '/exchange-rate/'),
                new ShellFooterLink('Subscriptions', '/subscription/'),
                new ShellFooterLink('Commissions', '/commission-plan/'),
                new ShellFooterLink('Catalog category', '/category/'),
                new ShellFooterLink('Admin Launchpad', $this->safeUrl('interfacing_admin_launchpad', '/interfacing/launchpad')),
                new ShellFooterLink('Applications', $this->safeUrl('interfacing_application_dashboard', '/interfacing/applications')),
                new ShellFooterLink('CRUD Explorer', $this->safeUrl('interfacing_crud_explorer', '/interfacing/crud/explorer')),
                new ShellFooterLink('Screen Directory', $this->safeUrl('interfacing_screen_directory', '/interfacing/screens')),
                new ShellFooterLink('Shell Screen Catalog', $this->safeUrl('interfacing_shell_screen_catalog', '/interfacing/shell/screens')),
                new ShellFooterLink('Shell Screen Catalog JSON', $this->safeUrl('interfacing_shell_screen_catalog_json', '/interfacing/shell/screens.json')),
                new ShellFooterLink('Operation Workbench', $this->safeUrl('interfacing_operation_workbench', '/interfacing/operations')),
                new ShellFooterLink('Admin Tables', $this->safeUrl('interfacing_admin_tables', '/interfacing/tables')),
                new ShellFooterLink('CRUD Frames', $this->safeUrl('interfacing_crud_frames', '/interfacing/forms')),
                new ShellFooterLink('CRUD Affordances', $this->safeUrl('interfacing_crud_affordances', '/interfacing/affordances')),
                new ShellFooterLink('CRUD Readiness', $this->safeUrl('interfacing_crud_readiness', '/interfacing/readiness')),
                new ShellFooterLink('Component Obligations', $this->safeUrl('interfacing_component_obligations', '/interfacing/obligations')),
                new ShellFooterLink('Runtime Bridges', $this->safeUrl('interfacing_runtime_bridges', '/interfacing/bridges')),
                new ShellFooterLink('Promotion Gates', $this->safeUrl('interfacing_promotion_gates', '/interfacing/promotions')),
                new ShellFooterLink('Evidence Registry', $this->safeUrl('interfacing_evidence_registry', '/interfacing/evidence')),
                new ShellFooterLink('Contract Registry', $this->safeUrl('interfacing_contract_registry', '/interfacing/contracts')),
                new ShellFooterLink('Field Schema Registry', $this->safeUrl('interfacing_field_schema_registry', '/interfacing/schemas')),
                new ShellFooterLink('Component Roadmap', $this->safeUrl('interfacing_component_roadmap', '/interfacing/components')),
                new ShellFooterLink('Shell Guard', $this->safeUrl('interfacing_shell_diagnostics', '/interfacing/shell/diagnostics')),
                new ShellFooterLink('Shell Map', $this->safeUrl('interfacing_shell_navigation', '/interfacing/shell/navigation')),
                new ShellFooterLink('Shell Layout Preview', $this->safeUrl('interfacing_shell_layout_preview', '/interfacing/shell/layout-preview')),
                new ShellFooterLink('Shell Layout JSON', $this->safeUrl('interfacing_shell_layout_preview_json', '/interfacing/shell/layout-preview.json')),
            ]),
        ];
    }

    /** @return list<ShellNavItem> */
    private function crudSectionItems(): array
    {
        $items = [
            new ShellNavItem('crud.explorer', 'CRUD explorer', $this->safeUrl('interfacing_crud_explorer', '/interfacing/crud/explorer'), 'crud', null, 10),
        ];

        $order = 20;
        foreach ($this->crudResourceExplorerProvider->provide() as $resource) {
            $items[] = new ShellNavItem(
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
        if (str_starts_with($needle, 'message.') || str_contains($path, '/message/')) {
            return 'messaging';
        }
        if (str_contains($path, '/order/') || str_contains($needle, 'order')) {
            return 'orders';
        }
        if (str_contains($path, '/billing/') || str_contains($needle, 'billing')) {
            return 'billing';
        }
        if ($this->isCommerceFinancePath($path, $needle)) {
            return 'commerce-finance';
        }
        if (str_contains($path, '/crud/') || str_contains($needle, 'crud')) {
            return 'crud';
        }
        if ((str_contains($path, '/interfacing/shell/diagnostics') || str_contains($path, '/interfacing/shell/navigation') || str_contains($path, '/interfacing/shell/screens') || str_contains($path, '/interfacing/shell/layout-preview')) || str_contains($needle, 'shell.diagnostics') || str_contains($needle, 'shell.navigation') || str_contains($needle, 'shell.screens') || str_contains($needle, 'shell.layout.preview') || str_contains($path, '/interfacing/launchpad') || str_contains($path, '/interfacing/applications') || str_contains($path, '/interfacing/screens') || str_contains($path, '/interfacing/operations') || str_contains($path, '/interfacing/tables') || str_contains($path, '/interfacing/forms') || str_contains($path, '/interfacing/affordances') || str_contains($path, '/interfacing/readiness') || str_contains($path, '/interfacing/obligations') || str_contains($path, '/interfacing/bridges') || str_contains($path, '/interfacing/promotions') || str_contains($path, '/interfacing/contracts') || str_contains($path, '/interfacing/schemas') || str_contains($path, '/interfacing/evidence') || str_contains($path, '/interfacing/components') || str_contains($needle, 'admin.launchpad') || str_contains($needle, 'applications.dashboard') || str_contains($needle, 'screen-directory') || str_contains($needle, 'operation.workbench') || str_contains($needle, 'admin.tables') || str_contains($needle, 'crud.frames') || str_contains($needle, 'crud.affordances') || str_contains($needle, 'crud.readiness') || str_contains($needle, 'component.obligations') || str_contains($needle, 'runtime.bridges') || str_contains($needle, 'promotion.gates') || str_contains($needle, 'contract.registry') || str_contains($needle, 'field.schema.registry') || str_contains($needle, 'evidence.registry') || str_contains($needle, 'component.roadmap')) {
            return 'screens';
        }
        if (str_contains($path, '/access') || str_contains($needle, 'access')) {
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
     * @return list<ShellNavGroup>
     */
    private function rightPanelGroup(): array
    {
        return [
            new ShellNavGroup('application-dashboard', 'Application dashboard', [
                new ShellNavItem('applications.dashboard', 'Applications UI', $this->safeUrl('interfacing_application_dashboard', '/interfacing/applications'), 'applications', null, 10),
                new ShellNavItem('applications.dashboard.json', 'Applications JSON', $this->safeUrl('interfacing_application_dashboard_json', '/interfacing/applications.json'), 'applications', null, 20),
            ]),
            new ShellNavGroup('crud-exports', 'CRUD exports', [
                new ShellNavItem('crud.links.json', 'Links JSON', $this->safeUrl('interfacing_crud_explorer_links', '/interfacing/crud/explorer/links.json'), 'crud', null, 10),
                new ShellNavItem('crud.route.expectations', 'Route expectations', $this->safeUrl('interfacing_crud_explorer_route_expectations', '/interfacing/crud/explorer/route-expectations.json'), 'crud', null, 20),
                new ShellNavItem('crud.operations.json', 'Operations JSON', $this->safeUrl('interfacing_crud_explorer_operations', '/interfacing/crud/explorer/operations.json'), 'crud', null, 30),
                new ShellNavItem('crud.screens.json', 'Screens JSON', $this->safeUrl('interfacing_crud_explorer_screens', '/interfacing/crud/explorer/screens.json'), 'crud', null, 40),
            ]),
            new ShellNavGroup('shell-guard', 'Shell guard', [
                new ShellNavItem('shell.diagnostics', 'Panel diagnostics', $this->safeUrl('interfacing_shell_diagnostics', '/interfacing/shell/diagnostics'), 'shell', null, 10),
                new ShellNavItem('shell.diagnostics.json', 'Diagnostics JSON', $this->safeUrl('interfacing_shell_diagnostics_json', '/interfacing/shell/diagnostics.json'), 'shell', null, 20),
                new ShellNavItem('shell.navigation', 'Navigation map', $this->safeUrl('interfacing_shell_navigation', '/interfacing/shell/navigation'), 'shell', null, 30),
                new ShellNavItem('shell.navigation.json', 'Navigation JSON', $this->safeUrl('interfacing_shell_navigation_json', '/interfacing/shell/navigation.json'), 'shell', null, 40),
                new ShellNavItem('shell.screens', 'Screen catalog', $this->safeUrl('interfacing_shell_screen_catalog', '/interfacing/shell/screens'), 'shell', null, 50),
                new ShellNavItem('shell.screens.json', 'Screen catalog JSON', $this->safeUrl('interfacing_shell_screen_catalog_json', '/interfacing/shell/screens.json'), 'shell', null, 60),
                new ShellNavItem('shell.layout.preview', 'Layout preview', $this->safeUrl('interfacing_shell_layout_preview', '/interfacing/shell/layout-preview'), 'shell', null, 70),
                new ShellNavItem('shell.layout.preview.json', 'Layout preview JSON', $this->safeUrl('interfacing_shell_layout_preview_json', '/interfacing/shell/layout-preview.json'), 'shell', null, 80),
            ]),
            new ShellNavGroup('quick-crud', 'Quick CRUD', array_slice($this->crudSectionItems(), 0, 12)),
        ];
    }

    /**
     * @return array<string,mixed>
     */
    private function applicationDashboard(): array
    {
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
                'crudBridgePatternRequired' => true,
                'note' => 'Connected, canonical and planned Smart Responsor components are intentionally visible so the host application can validate real CRUD address-bar patterns early.',
            ],
        ];
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
    }

    /**
     * @param array<string, string> $parameters
     */
    private function safeUrl(string $route, string $fallback, array $parameters = []): string
    {
        try {
            return $this->url->generate($route, $parameters);
        } catch (\Throwable) {
            return $fallback;
        }
    }

    /**
     * @return array{id:string,title:string,item:list<array{id:string,title:string,url:string}>}
     */
    private function legacyGroup(ShellNavGroup $group): array
    {
        return [
            'id' => $group->id(),
            'title' => $group->title(),
            'item' => array_map(
                static fn (ShellNavItem $item): array => [
                    'id' => $item->id(),
                    'title' => $item->title(),
                    'url' => $item->url(),
                ],
                $group->item(),
            ),
        ];
    }
}
