<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Provider;

use App\Interfacing\Contract\View\LayoutBlockSpec;
use App\Interfacing\Contract\View\LayoutScreenSpec;
use App\Interfacing\Contract\View\ScreenSpec;
use App\Interfacing\ServiceInterface\Interfacing\Provider\ScreenProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Localization\LocaleTemplateContextProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class LocaleSelectorScreenProvider implements ScreenProviderInterface
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly LocaleTemplateContextProviderInterface $localeTemplateContextProvider,
    ) {
    }

    public function provide(): array
    {
        $request = $this->requestStack->getCurrentRequest();
        $currentLocale = null !== $request ? (string) $request->getLocale() : 'en';
        $context = $this->localeTemplateContextProvider->provide($currentLocale);

        $items = [];
        foreach ($context->selectorOptions as $option) {
            $items[] = [
                'title' => $option->name.' ('.$option->code.')',
                'subtitle' => $option->nativeName,
                'meta' => [
                    'code' => $option->code,
                    'current' => $option->current ? 'yes' : 'no',
                    'default' => $option->default ? 'yes' : 'no',
                ],
            ];
        }

        $layout = new LayoutScreenSpec([
            new LayoutBlockSpec('collection', 'locale-selector', [
                'title' => 'Available locales',
                'subtitle' => sprintf(
                    'Current locale: %s. Default locale: %s. Fallback chain: %s.',
                    $context->currentLocaleCode,
                    $context->defaultLocaleCode,
                    implode(' → ', $context->fallbackLocaleCodes),
                ),
                'items' => $items,
            ]),
        ], id: 'localizing.locale.selector', title: 'Locale selector', navGroup: 'localizing', routePath: 'interfacing/screen/localizing/locale-selector');

        return [
            new ScreenSpec(
                'localizing.locale.selector',
                'Locale selector',
                $layout,
                [],
                [],
                'Localizing locale selector rendered through the Interfacing shell.',
                'interfacing/screen/localizing/locale-selector',
            ),
        ];
    }
}
