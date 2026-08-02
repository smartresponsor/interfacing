<?php

declare(strict_types=1);

namespace App\Interfacing\Tests;

use App\Interfacing\Service\Location\InterfaceLocationContextService;
use App\Interfacing\Service\Location\InterfaceLocationRenderService;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

final class InterfaceLocationRenderServiceTest extends TestCase
{
    public function testNavigationSlotsRenderProviderNativeMarkup(): void
    {
        $service = new InterfaceLocationRenderService($this->twig(), new InterfaceLocationContextService());

        $html = $service->render([
            'interface' => [
                'locations' => [
                    'shell.left.middle' => [
                        [
                            'type' => 'link',
                            'label' => 'Vendor',
                            'href' => '/vendor/index',
                            'icon' => 'ShopOutlined',
                        ],
                    ],
                ],
            ],
        ], 'shell.left.middle');

        self::assertStringContainsString('interfacing-location-bucket', $html);
        self::assertStringContainsString('interfacing-location-provider', $html);
        self::assertStringContainsString('interfacing-location-item', $html);
        self::assertStringContainsString('interfacing-location-link', $html);
        self::assertStringNotContainsString('interfacing-navigation-provider', $html);
        self::assertStringNotContainsString('ant-menu', $html);
    }

    public function testPrecomputedShellLocationsOverrideRawInterfaceLocations(): void
    {
        $service = new InterfaceLocationRenderService($this->twig(), new InterfaceLocationContextService());

        $html = $service->render([
            'shellLocations' => [
                'shell.left.middle' => [
                    [
                        'type' => 'link',
                        'label' => 'Precomputed vendor',
                        'href' => '/vendor/index',
                    ],
                ],
            ],
            'interface' => [
                'locations' => [
                    'shell.left.middle' => [
                        [
                            'type' => 'link',
                            'label' => 'Raw vendor',
                            'href' => '/vendor/raw',
                        ],
                    ],
                ],
            ],
        ], 'shell.left.middle');

        self::assertStringContainsString('Precomputed vendor', $html);
        self::assertStringNotContainsString('Raw vendor', $html);
    }

    public function testNonNavigationSlotsKeepGenericBucketMarkup(): void
    {
        $service = new InterfaceLocationRenderService($this->twig(), new InterfaceLocationContextService());

        $html = $service->render([
            'interface' => [
                'locations' => [
                    'shell.context.top' => [
                        [
                            'type' => 'label',
                            'label' => 'Context',
                        ],
                    ],
                ],
            ],
        ], 'shell.context.top');

        self::assertStringContainsString('interfacing-location-bucket', $html);
        self::assertStringContainsString('interfacing-location-item', $html);
        self::assertStringNotContainsString('interfacing-navigation-provider', $html);
    }

    private function twig(): Environment
    {
        $loader = new FilesystemLoader();
        $loader->addPath('D:/PhpstormProjects/www/Interfacing/templates', 'Interfacing');

        $twig = new Environment($loader);
        $twig->addExtension(new class extends AbstractExtension {
            /**
             * @return list<TwigFunction>
             */
            public function getFunctions(): array
            {
                return [
                    new TwigFunction('interface_style_provider', static function (string $key): array {
                        return [
                            'key' => $key,
                            'location_class' => 'interfacing-location-provider--'.$key,
                        ];
                    }),
                ];
            }
        });

        return $twig;
    }
}
