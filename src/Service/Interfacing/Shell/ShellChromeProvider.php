<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Shell;

use App\Interfacing\Contract\ValueObject\ShellSlot;
use App\Interfacing\Contract\View\ShellFooterGroup;
use App\Interfacing\Contract\View\ShellFooterLink;
use App\Interfacing\Contract\View\ShellNavGroup;
use App\Interfacing\Contract\View\ShellNavItem;
use App\Interfacing\ServiceInterface\Interfacing\Shell\ShellChromeProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class ShellChromeProvider implements ShellChromeProviderInterface
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly UrlGeneratorInterface $url,
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
            new ShellNavItem('workspace', 'Workspace', $this->safeUrl('interfacing_layout_index', '/interfacing'), 'workspace', null, 10),
            new ShellNavItem('notifications', 'Notifications', $this->screenUrl('message.notifications.inbox'), 'workspace', null, 20),
            new ShellNavItem('crud.explorer', 'CRUD Explorer', $this->safeUrl('interfacing_crud_explorer', '/interfacing/crud/explorer'), 'workspace', null, 30),
            new ShellNavItem('help', 'Help', '#help', 'workspace', null, 40),
            new ShellNavItem('account', 'Account', '#account', 'workspace', null, 50),
        ];
    }

    /** @return list<ShellNavGroup> */
    private function primaryGroup(string $activeSection): array
    {
        return [
            new ShellNavGroup('platform', 'Platform', [
                new ShellNavItem('workspace.home', 'Workspace', $this->safeUrl('interfacing_layout_index', '/interfacing'), 'platform', null, 10),
                new ShellNavItem('access', 'Access', '#access', 'platform', null, 20),
                new ShellNavItem('messaging', 'Messaging', $this->screenUrl('message.notifications.inbox'), 'platform', null, 30),
                new ShellNavItem('billing', 'Billing', $this->safeUrl('interfacing_billing_meter', '/interfacing/billing/meter'), 'platform', null, 40),
                new ShellNavItem('orders', 'Orders', $this->safeUrl('interfacing_order_summary', '/interfacing/order/summary'), 'platform', null, 50),
                new ShellNavItem('catalog', 'Catalog', $this->screenUrl('category-admin'), 'platform', null, 60),
                new ShellNavItem('crud', 'CRUD', $this->safeUrl('interfacing_crud_explorer', '/interfacing/crud/explorer'), 'platform', null, 70),
                new ShellNavItem('taxation', 'Taxation', '#taxation', 'platform', null, 80),
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
            'workspace' => [new ShellNavGroup('workspace', 'Workspace', [
                new ShellNavItem('workspace.home', 'Overview', $this->safeUrl('interfacing_layout_index', '/interfacing'), 'workspace', null, 10),
                new ShellNavItem('interfacing.doctor', 'Doctor', $this->screenUrl('interfacing-doctor'), 'workspace', null, 20),
                new ShellNavItem('category-admin', 'Category admin', $this->screenUrl('category-admin'), 'workspace', null, 30),
                new ShellNavItem('interfacing.health', 'Health', $this->safeUrl('interfacing_health', '/interfacing/health'), 'workspace', null, 40),
            ])],
            'access' => [new ShellNavGroup('access', 'Access', [
                new ShellNavItem('access.account.overview', 'Account overview', '#access-account-overview', 'access', null, 10),
                new ShellNavItem('access.sessions', 'Sessions', '#access-sessions', 'access', null, 20),
                new ShellNavItem('access.security.events', 'Security events', '#access-security-events', 'access', null, 30),
                new ShellNavItem('access.registration', 'Registration', '#access-registration', 'access', null, 40),
            ])],
            'crud' => [new ShellNavGroup('crud', 'Typical CRUD', [
                new ShellNavItem('crud.explorer', 'CRUD explorer', $this->safeUrl('interfacing_crud_explorer', '/interfacing/crud/explorer'), 'crud', null, 10),
                new ShellNavItem('crud.category.index', $this->routeLabel('admin_category_index', 'Category index'), $this->safeUrl('admin_category_index', '/admin/category'), 'crud', null, 20),
                new ShellNavItem('crud.category.new', $this->routeLabel('admin_category_new', 'Category new'), $this->safeUrl('admin_category_new', '/admin/category/new'), 'crud', null, 30),
                new ShellNavItem('crud.application.index', $this->routeLabel('applicating_application_index', 'Application index'), $this->safeUrl('applicating_application_index', '/admin/applications'), 'crud', null, 40),
                new ShellNavItem('crud.application.new', $this->routeLabel('applicating_application_new', 'Application new'), $this->safeUrl('applicating_application_new', '/admin/applications/new'), 'crud', null, 50),
                new ShellNavItem('crud.generic.category', $this->routeLabel('app_crud_index', 'Generic category index'), $this->safeUrl('app_crud_index', '/category/', ['resourcePath' => 'category']), 'crud', null, 60),
                new ShellNavItem('crud.generic.vendor', $this->routeLabel('app_crud_index', 'Generic vendor index'), $this->safeUrl('app_crud_index', '/vendor/', ['resourcePath' => 'vendor']), 'crud', null, 70),
            ])],
            default => [new ShellNavGroup('workspace', 'Workspace', [
                new ShellNavItem('workspace.home', 'Overview', $this->safeUrl('interfacing_layout_index', '/interfacing'), 'workspace', null, 10),
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
                new ShellFooterLink('Catalog', $this->screenUrl('category-admin')),
                new ShellFooterLink('CRUD Explorer', $this->safeUrl('interfacing_crud_explorer', '/interfacing/crud/explorer')),
            ]),
        ];
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

    private function routeLabel(string $route, string $fallback): string
    {
        return $fallback;
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
