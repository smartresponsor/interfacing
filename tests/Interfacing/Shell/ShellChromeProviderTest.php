<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Interfacing\Shell;

use App\Interfacing\Contract\View\CrudResourceLinkSet;
use App\Interfacing\Service\Interfacing\Shell\ShellChromeProvider;
use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceExplorerProviderInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class ShellChromeProviderTest extends TestCase
{
    public function testProvideIncludesLegacyPageIndexKeys(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(Request::create('/interfacing'));

        $url = new class implements UrlGeneratorInterface {
            public function generate(string $name, array $parameters = [], int $referenceType = self::ABSOLUTE_PATH): string
            {
                return '/'.$name.'/'.($parameters['id'] ?? '');
            }

            public function setContext(\Symfony\Component\Routing\RequestContext $context): void
            {
            }

            public function getContext(): \Symfony\Component\Routing\RequestContext
            {
                return new \Symfony\Component\Routing\RequestContext();
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

        $provider = new ShellChromeProvider($requestStack, $url, $crudResources);
        $shell = $provider->provide('workspace.home');

        self::assertArrayHasKey('itemTotal', $shell);
        self::assertArrayHasKey('group', $shell);
        self::assertGreaterThan(0, $shell['itemTotal']);
        self::assertNotEmpty($shell['group']);

        $urls = [];
        foreach ($shell['group'] as $group) {
            foreach ($group['item'] as $item) {
                $urls[] = $item['url'];
            }
        }

        self::assertContains('/interfacing_screen/message.notifications.inbox', $urls);
        self::assertContains('/interfacing_screen/interfacing-doctor', $urls);
        self::assertNotContains('/interfacing/screen/message.notifications.inbox', $urls);
    }
}
