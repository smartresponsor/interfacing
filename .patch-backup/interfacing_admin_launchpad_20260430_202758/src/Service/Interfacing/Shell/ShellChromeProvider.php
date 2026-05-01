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
        $request = $this->requestStack->getCurrentRequest();
        $path = null !== $request ? (string) $request->getPathInfo() : '';
        $activeSection = $this->detectActiveSection($activeId, $path);
        $topLink = $this->topLink();
        $primaryGroup = $this->primaryGroup($activeSection);
        $sectionGroup = $this->sectionGroup($activeSection);
        $footerGroup = $this->footerGroup();

        return [
            'activeId' => $activeId,
            'activeSection' => $activeSection,
            'query' => null !== $request ? (string) $request->query->get('q', '') : '',
            'topLink' => $topLink,
            'primaryGroup' => $primaryGroup,
            'sectionGroup' => $sectionGroup,
            'footerGroup' => $footerGroup,
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
            new ShellNavItem('notifications', 'Notifications', $this->screenUrl('message.notifications.inbox'), 'workspace', null, 20),
            new ShellNavItem('crud.explorer', 'CRUD Explorer', $this->safeUrl('interfacing_crud_explorer', '/interfacing/crud/explorer'), 'workspace', null, 30),
            new ShellNavItem('screen.directory', 'Screens', $this->safeUrl('interfacing_screen_directory', '/interfacing/screens'), 'workspace', null, 35),
            new ShellNavItem('operation.workbench', 'Operations', $this->safeUrl('interfacing_operation_workbench', '/interfacing/operations'), 'workspace', null, 37),
            new ShellNavItem('surface.audit', 'Surface Audit', $this->safeUrl('interfacing_surface_audit', '/interfacing/surface'), 'workspace', null, 39),
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
                new ShellNavItem('access', 'Access', '/access', 'platform', null, 20),
                new ShellNavItem('messaging', 'Messaging', $this->screenUrl('message.notifications.inbox'), 'platform', null, 30),
                new ShellNavItem('billing', 'Billing', $this->safeUrl('interfacing_billing_meter', '/interfacing/billing/meter'), 'platform', null, 40),
                new ShellNavItem('orders', 'Orders', $this->safeUrl('interfacing_order_summary', '/interfacing/order/summary'), 'platform', null, 50),
                new ShellNavItem('catalog', 'Catalog', '/category/', 'platform', null, 60),
                new ShellNavItem('crud', 'CRUD', $this->safeUrl('interfacing_crud_explorer', '/interfacing/crud/explorer'), 'platform', null, 70),
                new ShellNavItem('screen.directory', 'Screens', $this->safeUrl('interfacing_screen_directory', '/interfacing/screens'), 'platform', null, 73),
                new ShellNavItem('operation.workbench', 'Operations', $this->safeUrl('interfacing_operation_workbench', '/interfacing/operations'), 'platform', null, 74),
                new ShellNavItem('ecommerce.matrix', 'E-commerce Matrix', '/interfacing#ecommerce-screen-matrix', 'platform', null, 75),
                new ShellNavItem('surface.audit', 'Surface Audit', $this->safeUrl('interfacing_surface_audit', '/interfacing/surface'), 'platform', null, 76),
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
            'workspace', 'screens' => [new ShellNavGroup('workspace', 'Workspace', [
                new ShellNavItem('workspace.home', 'Overview', $this->safeUrl('interfacing_index', '/interfacing'), 'workspace', null, 10),
                new ShellNavItem('interfacing.doctor', 'Doctor', $this->screenUrl('interfacing-doctor'), 'workspace', null, 20),
                new ShellNavItem('crud.explorer', 'CRUD explorer', $this->safeUrl('interfacing_crud_explorer', '/interfacing/crud/explorer'), 'workspace', null, 30),
                new ShellNavItem('screen.directory', 'Screen directory', $this->safeUrl('interfacing_screen_directory', '/interfacing/screens'), 'workspace', null, 33),
                new ShellNavItem('operation.workbench', 'Operation workbench', $this->safeUrl('interfacing_operation_workbench', '/interfacing/operations'), 'workspace', null, 34),
                new ShellNavItem('ecommerce.matrix', 'E-commerce matrix', '/interfacing#ecommerce-screen-matrix', 'workspace', null, 35),
                new ShellNavItem('surface.audit', 'Surface audit', $this->safeUrl('interfacing_surface_audit', '/interfacing/surface'), 'workspace', null, 36),
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
                new ShellFooterLink('Catalog category', '/category/'),
                new ShellFooterLink('CRUD Explorer', $this->safeUrl('interfacing_crud_explorer', '/interfacing/crud/explorer')),
                new ShellFooterLink('Screen Directory', $this->safeUrl('interfacing_screen_directory', '/interfacing/screens')),
                new ShellFooterLink('Operation Workbench', $this->safeUrl('interfacing_operation_workbench', '/interfacing/operations')),
                new ShellFooterLink('Component Roadmap', $this->safeUrl('interfacing_component_roadmap', '/interfacing/components')),
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
        if (str_contains($path, '/crud/') || str_contains($needle, 'crud')) {
            return 'crud';
        }
        if (str_contains($path, '/interfacing/screens') || str_contains($path, '/interfacing/operations') || str_contains($path, '/interfacing/components') || str_contains($needle, 'screen-directory') || str_contains($needle, 'operation.workbench') || str_contains($needle, 'component.roadmap')) {
            return 'screens';
        }
        if (str_contains($path, '/access') || str_contains($needle, 'access')) {
            return 'access';
        }

        return 'workspace';
    }

    private function screenUrl(string $screenId): string
    {
        return $this->safeUrl('interfacing_screen', '/interfacing/'.$screenId, ['id' => $screenId]);
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
     * @param ShellNavGroup $group
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
