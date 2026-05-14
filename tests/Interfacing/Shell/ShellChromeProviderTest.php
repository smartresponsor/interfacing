<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Interfacing\Shell;

use App\Interfacing\Contract\View\CrudResourceLinkSet;
use App\Interfacing\Service\Interfacing\Shell\ShellChromeProvider;
use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceExplorerProviderInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RouterInterface;

final class ShellChromeProviderTest extends TestCase
{
    public function testProvideIncludesLegacyPageIndexKeys(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(Request::create('/interfacing'));

        $url = new class implements RouterInterface {
            public function generate(string $name, array $parameters = [], int $referenceType = self::ABSOLUTE_PATH): string
            {
                return '/'.$name.'/'.($parameters['id'] ?? '');
            }

            public function match(string $pathinfo): array
            {
                return [];
            }

            public function getRouteCollection(): RouteCollection
            {
                $routes = new RouteCollection();
                $routes->add('interfacing_screen', new Route('/interfacing/{id}'));

                return $routes;
            }

            public function setContext(RequestContext $context): void
            {
            }

            public function getContext(): RequestContext
            {
                return new RequestContext();
            }
        };

        $crudResources = new class implements CrudResourceExplorerProviderInterface {
            public function provide(): array
            {
                return [
                    new CrudResourceLinkSet(
                        id: 'sample.one',
                        component: 'Sample',
                        label: 'Sample',
                        resourcePath: 'sample',
                        indexUrl: '/sample/',
                        newUrl: '/sample/new/',
                        showPattern: '/sample/{id}',
                        editPattern: '/sample/edit/{id}',
                        deletePattern: '/sample/delete/{id}',
                    ),
                ];
            }
        };

        $provider = new ShellChromeProvider($requestStack, $url, $crudResources, new ArrayAdapter());
        $shell = $provider->provide('workspace.home');

        self::assertArrayHasKey('itemTotal', $shell);
        self::assertArrayHasKey('group', $shell);
        self::assertArrayHasKey('footerGroup', $shell);
        self::assertArrayHasKey('quickMenuGroup', $shell);
        self::assertGreaterThan(0, $shell['itemTotal']);
        self::assertNotEmpty($shell['group']);
        self::assertNotEmpty($shell['footerGroup']);
        self::assertNotEmpty($shell['quickMenuGroup']);

        $urls = [];
        foreach ($shell['group'] as $group) {
            foreach ($group['item'] as $item) {
                $urls[] = $item['url'];
            }
        }

        self::assertContains('/interfacing_screen/message.notifications.inbox', $urls);
        self::assertContains('/interfacing_screen/interfacing-doctor', $urls);
        self::assertNotContains('/interfacing/screen/message.notifications.inbox', $urls);

        $footerTitles = [];
        foreach ($shell['footerGroup'] as $group) {
            $footerTitles[] = $group->title();
        }

        self::assertContains('Commerce core', $footerTitles);
        self::assertContains('Commerce finance', $footerTitles);
        self::assertContains('Customer account', $footerTitles);
        self::assertContains('Application indexes', $footerTitles);

        $quickTitles = [];
        $quickIds = [];
        foreach ($shell['quickMenuGroup'] as $group) {
            $quickTitles[] = $group->title();
            foreach ($group->item() as $item) {
                $quickIds[] = $item->id();
            }
        }

        self::assertContains('My account', $quickTitles);
        self::assertContains('My commerce', $quickTitles);
        self::assertContains('System shortcuts', $quickTitles);
        self::assertContains('quick.switch-account', $quickIds);
        self::assertContains('quick.sign-out', $quickIds);
    }
}
