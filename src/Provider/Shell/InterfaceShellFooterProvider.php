<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Shell;

use App\Interfacing\Contract\View\InterfaceShellFooterGroup;
use App\Interfacing\Contract\View\InterfaceShellFooterLink;
use App\Interfacing\ProviderInterface\Localization\InterfaceLocaleTemplateSelectorProviderInterface;
use App\Interfacing\ProviderInterface\Shell\InterfaceShellFooterProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

final class InterfaceShellFooterProvider implements InterfaceShellFooterProviderInterface
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
        private readonly InterfaceLocaleTemplateSelectorProviderInterface $localeTemplateSelectorProvider,
    ) {
    }

    public function provide(): array
    {
        $request = $this->requestStack->getCurrentRequest();
        $currentLocale = null !== $request ? (string) $request->getLocale() : 'en';
        $selector = $this->localeTemplateSelectorProvider->provide($currentLocale);

        return [
            new InterfaceShellFooterGroup('commerce-core', 'Commerce core', [
                new InterfaceShellFooterLink('Catalog', '/catalog/'),
                new InterfaceShellFooterLink('Search index', '/index-record/'),
                new InterfaceShellFooterLink('Cart', '/cart/'),
                new InterfaceShellFooterLink('Orders', '/order/'),
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
                new InterfaceShellFooterLink('My orders', '/order/'),
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
            new InterfaceShellFooterGroup('locale', 'Locale', $this->localeLinks($selector)),
            new InterfaceShellFooterGroup('system-links', 'System links', [
                new InterfaceShellFooterLink('Shell Guard', $this->safeUrl('interfacing_shell_diagnostics', '/interfacing/shell/diagnostics')),
                new InterfaceShellFooterLink('Shell Map', $this->safeUrl('interfacing_shell_navigation', '/interfacing/shell/navigation')),
                new InterfaceShellFooterLink('Layout Preview', $this->safeUrl('interfacing_shell_layout_preview', '/interfacing/shell/layout-preview')),
                new InterfaceShellFooterLink('Contracts', $this->safeUrl('interfacing_contract_registry', '/interfacing/contracts')),
                new InterfaceShellFooterLink('Schemas', $this->safeUrl('interfacing_field_schema_registry', '/interfacing/schemas')),
                new InterfaceShellFooterLink('Status', '#status'),
            ]),
            new InterfaceShellFooterGroup('support-policy', 'Support & policy', [
                new InterfaceShellFooterLink('FAQ', '#faq'),
                new InterfaceShellFooterLink('Support', '#support'),
                new InterfaceShellFooterLink('Privacy', '#privacy'),
                new InterfaceShellFooterLink('Terms', '#terms'),
                new InterfaceShellFooterLink('Security policy', '#security'),
            ]),
        ];
    }

    /**
     * @param list<\App\Interfacing\Contract\Localization\InterfaceLocaleTemplateSelectorOption> $selector
     *
     * @return list<InterfaceShellFooterLink>
     */
    private function localeLinks(array $selector): array
    {
        $links = [
            new InterfaceShellFooterLink('Locale selector', $this->screenUrl('localizing.locale.selector')),
        ];

        foreach ($selector as $option) {
            $label = sprintf('%s · %s', $option->name, $option->code);
            if ($option->current) {
                $label .= ' · current';
            }
            if ($option->default) {
                $label .= ' · default';
            }

            $links[] = new InterfaceShellFooterLink($label, $this->localeUrl($option->code));
        }

        return $links;
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

    private function localeUrl(string $localeCode): string
    {
        $request = $this->requestStack->getCurrentRequest();
        if (null === $request) {
            return '/?locale='.rawurlencode($localeCode);
        }

        $query = $request->query->all();
        $query['locale'] = $localeCode;

        $base = $request->getPathInfo();
        $queryString = http_build_query($query);

        return '' === $queryString ? $base : $base.'?'.$queryString;
    }
}
