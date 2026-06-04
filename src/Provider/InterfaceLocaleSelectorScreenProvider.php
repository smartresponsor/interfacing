<?php

declare(strict_types=1);

namespace App\Interfacing\Provider;

use App\Interfacing\Contract\View\InterfaceLayoutBlockSpec;
use App\Interfacing\Contract\View\InterfaceLayoutScreenSpec;
use App\Interfacing\Contract\View\InterfaceScreenSpec;
use App\Interfacing\ProviderInterface\InterfaceScreenProviderInterface;
use App\Interfacing\ProviderInterface\Localization\InterfaceLocaleTemplateContextProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class InterfaceLocaleSelectorScreenProvider implements InterfaceScreenProviderInterface
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly InterfaceLocaleTemplateContextProviderInterface $localeTemplateContextProvider,
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

        $layout = new InterfaceLayoutScreenSpec([
            new InterfaceLayoutBlockSpec('collection', 'locale-selector', [
                'title' => 'Available locales',
                'subtitle' => sprintf(
                    'Current locale: %s. Default locale: %s. Fallback chain: %s.',
                    $context->currentLocaleCode,
                    $context->defaultLocaleCode,
                    implode(' → ', $context->fallbackLocaleCodes),
                ),
                'items' => $items,
            ]),
        ], id: 'localizing.locale.selector', title: 'Locale selector', navGroup: 'localizing', routePath: 'screen/localizing/locale-selector');

        return [
            new InterfaceScreenSpec(
                'localizing.locale.selector',
                'Locale selector',
                $layout,
                [],
                [],
                'Localizing locale selector rendered through the Interfacing shell.',
                'screen/localizing/locale-selector',
            ),
        ];
    }
}
