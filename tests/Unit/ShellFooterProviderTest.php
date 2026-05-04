<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Unit;

use App\Interfacing\Service\Interfacing\Shell\ShellFooterProvider;
use App\Interfacing\ServiceInterface\Interfacing\Localization\LocaleTemplateSelectorProviderInterface;
use App\Interfacing\Contract\Localization\LocaleTemplateSelectorOption;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class ShellFooterProviderTest extends TestCase
{
    public function testProvideAddsLocaleSelectorGroup(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(Request::create('/interfacing/screens?q=foo&status=all'));
        $requestStack->getCurrentRequest()?->setLocale('uk');

        $provider = new ShellFooterProvider(
            $requestStack,
            new class implements UrlGeneratorInterface {
                public function generate(string $name, array $parameters = [], int $referenceType = self::ABSOLUTE_PATH): string
                {
                    if ('interfacing_screen' === $name) {
                        return '/interfacing/screen/'.($parameters['screenId'] ?? '');
                    }

                    return '/'.$name;
                }

                public function setContext(\Symfony\Component\Routing\RequestContext $context): void
                {
                }

                public function getContext(): \Symfony\Component\Routing\RequestContext
                {
                    return new \Symfony\Component\Routing\RequestContext();
                }
            },
            new class implements LocaleTemplateSelectorProviderInterface {
                public function provide(string $currentLocaleCode): array
                {
                    return [
                        new LocaleTemplateSelectorOption('en', 'English', 'English', false, true),
                        new LocaleTemplateSelectorOption('uk', 'Ukrainian', 'Українська', true, false),
                    ];
                }
            },
        );

        $groups = $provider->provide();

        self::assertSame('locale', $groups[0]->id());
        self::assertSame('Locale', $groups[0]->title());
        self::assertGreaterThanOrEqual(3, count($groups[0]->link()));
        self::assertSame('Locale selector', $groups[0]->link()[0]->title());
        self::assertSame('/interfacing/screen/localizing.locale.selector', $groups[0]->link()[0]->url());
    }
}
