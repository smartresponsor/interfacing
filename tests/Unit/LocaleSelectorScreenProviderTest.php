<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Unit;

use App\Interfacing\Service\Interfacing\Provider\LocaleSelectorScreenProvider;
use App\Interfacing\ServiceInterface\Interfacing\Localization\LocaleTemplateContextProviderInterface;
use App\Interfacing\Contract\Localization\LocaleTemplateContext;
use App\Interfacing\Contract\Localization\LocaleTemplateSelectorOption;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class LocaleSelectorScreenProviderTest extends TestCase
{
    public function testProvideBuildsLocaleSelectorScreen(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(Request::create('/interfacing/screen/localizing.locale.selector'));
        $requestStack->getCurrentRequest()?->setLocale('uk');

        $provider = new LocaleSelectorScreenProvider($requestStack, new class implements LocaleTemplateContextProviderInterface {
            public function provide(string $currentLocaleCode): LocaleTemplateContext
            {
                return new LocaleTemplateContext(
                    $currentLocaleCode,
                    'en',
                    ['uk', 'en'],
                    [
                        new LocaleTemplateSelectorOption('en', 'English', 'English', false, true),
                        new LocaleTemplateSelectorOption('uk', 'Ukrainian', 'Українська', true, false),
                    ],
                );
            }
        });

        $screens = $provider->provide();

        self::assertCount(1, $screens);
        self::assertSame('localizing.locale.selector', $screens[0]->id());
        self::assertSame('Locale selector', $screens[0]->title());
        self::assertSame('interfacing/screen/localizing/locale-selector', $screens[0]->viewId());
    }
}
