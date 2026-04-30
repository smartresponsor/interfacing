<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Interfacing\Crud;

use App\Interfacing\Contract\View\CrudResourceLinkSet;
use App\Interfacing\Service\Interfacing\Crud\CrudResourceExplorerProvider;
use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceContributionInterface;
use PHPUnit\Framework\TestCase;

final class CrudResourceExplorerProviderTest extends TestCase
{
    public function testProvideMergesTaggedContributions(): void
    {
        $provider = new CrudResourceExplorerProvider([
            new class implements CrudResourceContributionInterface {
                public function provide(): array
                {
                    return [
                        new CrudResourceLinkSet(
                            id: 'sample.one',
                            component: 'Sample',
                            label: 'Sample',
                            resourcePath: 'sample',
                            indexUrl: '/sample',
                            newUrl: '/sample/new',
                            showPattern: '/sample/{id}',
                            editPattern: '/sample/edit/{id}',
                            deletePattern: '/sample/delete/{id}',
                        ),
                    ];
                }
            },
        ]);

        $list = $provider->provide();

        self::assertCount(1, $list);
        self::assertSame('sample.one', $list[0]->id());
        self::assertSame('/sample', $list[0]->indexUrl());
    }
}
