<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Shell;

use App\Interfacing\Contract\View\ShellFooterGroup;
use App\Interfacing\Contract\View\ShellFooterLink;
use App\Interfacing\ServiceInterface\Interfacing\Localization\LocaleTemplateSelectorProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Shell\ShellFooterProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

final class ShellFooterProvider implements ShellFooterProviderInterface
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
        private readonly LocaleTemplateSelectorProviderInterface $localeTemplateSelectorProvider,
    ) {
    }

    public function provide(): array
    {
        $request = $this->requestStack->getCurrentRequest();
        $currentLocale = null !== $request ? (string) $request->getLocale() : 'en';
        $selector = $this->localeTemplateSelectorProvider->provide($currentLocale);

        return [
            new ShellFooterGroup('commerce-core', 'Commerce core', [
                new ShellFooterLink('Catalog categories', '/catalog/category/'),
                new ShellFooterLink('Search index', '/index-record/'),
                new ShellFooterLink('Cart', '/cart/'),
                new ShellFooterLink('Orders', '/order/'),
                new ShellFooterLink('Payments', '/payment/'),
                new ShellFooterLink('Shipping', '/shipment/'),
                new ShellFooterLink('Taxation', '/taxation-api/'),
            ]),
            new ShellFooterGroup('commerce-finance', 'Commerce finance', [
                new ShellFooterLink('Currencies', '/currency/'),
                new ShellFooterLink('Money formats', '/money-format/'),
                new ShellFooterLink('Exchange rates', '/exchange-rate/'),
                new ShellFooterLink('Exchange quotes', '/exchange-quote/'),
                new ShellFooterLink('Subscriptions', '/subscription/'),
                new ShellFooterLink('Subscription plans', '/subscription-plan/'),
                new ShellFooterLink('Commission plans', '/commission-plan/'),
                new ShellFooterLink('Commission payouts', '/commission-payout/'),
            ]),
            new ShellFooterGroup('customer-account', 'Customer account', [
                new ShellFooterLink('My profile', '/profile/'),
                new ShellFooterLink('My security', '/security/'),
                new ShellFooterLink('My cart', '/cart/'),
                new ShellFooterLink('My orders', '/order/'),
                new ShellFooterLink('My subscription', '/subscription/'),
                new ShellFooterLink('Notifications', $this->screenUrl('message.notifications.inbox')),
            ]),
            new ShellFooterGroup('application-indexes', 'Application indexes', [
                new ShellFooterLink('Applications', $this->safeUrl('interfacing_application_dashboard', '/interfacing/applications')),
                new ShellFooterLink('Components', $this->safeUrl('interfacing_component_roadmap', '/interfacing/components')),
                new ShellFooterLink('CRUD Explorer', $this->safeUrl('interfacing_crud_explorer', '/interfacing/crud/explorer')),
                new ShellFooterLink('Screen Directory', $this->safeUrl('interfacing_screen_directory', '/interfacing/screens')),
                new ShellFooterLink('Screen Catalog', $this->safeUrl('interfacing_shell_screen_catalog', '/interfacing/shell/screens')),
                new ShellFooterLink('Operations', $this->safeUrl('interfacing_operation_workbench', '/interfacing/operations')),
            ]),
            new ShellFooterGroup('locale', 'Locale', $this->localeLinks($selector)),
            new ShellFooterGroup('system-links', 'System links', [
                new ShellFooterLink('Shell Guard', $this->safeUrl('interfacing_shell_diagnostics', '/interfacing/shell/diagnostics')),
                new ShellFooterLink('Shell Map', $this->safeUrl('interfacing_shell_navigation', '/interfacing/shell/navigation')),
                new ShellFooterLink('Layout Preview', $this->safeUrl('interfacing_shell_layout_preview', '/interfacing/shell/layout-preview')),
                new ShellFooterLink('Contracts', $this->safeUrl('interfacing_contract_registry', '/interfacing/contracts')),
                new ShellFooterLink('Schemas', $this->safeUrl('interfacing_field_schema_registry', '/interfacing/schemas')),
                new ShellFooterLink('Status', '#status'),
            ]),
            new ShellFooterGroup('support-policy', 'Support & policy', [
                new ShellFooterLink('FAQ', '#faq'),
                new ShellFooterLink('Support', '#support'),
                new ShellFooterLink('Privacy', '#privacy'),
                new ShellFooterLink('Terms', '#terms'),
                new ShellFooterLink('Security policy', '#security'),
            ]),
        ];
    }

    /**
     * @param list<\App\Interfacing\Contract\Localization\LocaleTemplateSelectorOption> $selector
     *
     * @return list<ShellFooterLink>
     */
    private function localeLinks(array $selector): array
    {
        $links = [
            new ShellFooterLink('Locale selector', $this->screenUrl('localizing.locale.selector')),
        ];

        foreach ($selector as $option) {
            $label = sprintf('%s · %s', $option->name, $option->code);
            if ($option->current) {
                $label .= ' · current';
            }
            if ($option->default) {
                $label .= ' · default';
            }

            $links[] = new ShellFooterLink($label, $this->localeUrl($option->code));
        }

        return $links;
    }

    private function screenUrl(string $screenId): string
    {
        return $this->safeUrl('interfacing_screen', '/interfacing/screen/'.$screenId, ['id' => $screenId]);
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
