<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Shell;

use App\Interfacing\Contract\View\ShellFooterGroup;
use App\Interfacing\Contract\View\ShellFooterLink;
use App\Interfacing\ServiceInterface\Interfacing\Localization\LocaleTemplateSelectorProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Interfacing\ServiceInterface\Interfacing\Shell\ShellFooterProviderInterface;

final class ShellFooterProvider implements ShellFooterProviderInterface
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly LocaleTemplateSelectorProviderInterface $localeTemplateSelectorProvider,
    ) {
    }

    public function provide(): array
    {
        $request = $this->requestStack->getCurrentRequest();
        $currentLocale = null !== $request ? (string) $request->getLocale() : 'en';
        $selector = $this->localeTemplateSelectorProvider->provide($currentLocale);

        return [
            new ShellFooterGroup('locale', 'Locale', $this->localeLinks($selector)),
            new ShellFooterGroup('help', 'Help', [
                new ShellFooterLink('FAQ', '#faq'),
                new ShellFooterLink('Support', '#support'),
                new ShellFooterLink('Docs', '#docs'),
            ]),
            new ShellFooterGroup('policy', 'Policy', [
                new ShellFooterLink('Privacy', '#privacy'),
                new ShellFooterLink('Terms', '#terms'),
                new ShellFooterLink('Security', '#security'),
            ]),
            new ShellFooterGroup('platform', 'Platform', [
                new ShellFooterLink('Status', '#status'),
                new ShellFooterLink('About', '#about'),
                new ShellFooterLink('Contact', '#contact'),
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
        try {
            return $this->urlGenerator->generate('interfacing_screen', ['screenId' => $screenId]);
        } catch (\Throwable) {
            return '/interfacing/screen/'.$screenId;
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
