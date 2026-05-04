<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Interfacing\Crud;

use App\Interfacing\Contract\View\CrudResourceLinkSet;
use App\Interfacing\Service\Interfacing\Crud\CrudResourceExplorerProvider;
use App\Interfacing\Service\Interfacing\Crud\DefaultCrudOperationGrammarProvider;
use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceContributionInterface;
use PHPUnit\Framework\TestCase;

final class CrudResourceExplorerProviderTest extends TestCase
{
    public function testProvideMergesTaggedContributionsDeterministically(): void
    {
        $provider = new CrudResourceExplorerProvider([
            new class implements CrudResourceContributionInterface {
                public function provide(): array
                {
                    return [
                        new CrudResourceLinkSet(
                            id: 'sample.one',
                            component: 'Sample',
                            label: 'Sample planned',
                            resourcePath: 'sample',
                            indexUrl: '/sample',
                            newUrl: '/sample/new',
                            showPattern: '/sample/{id}',
                            editPattern: '/sample/edit/{id}',
                            deletePattern: '/sample/delete/{id}',
                            status: 'planned',
                        ),
                    ];
                }
            },
            new class implements CrudResourceContributionInterface {
                public function provide(): array
                {
                    return [
                        new CrudResourceLinkSet(
                            id: 'sample.one',
                            component: 'Sample',
                            label: 'Sample canonical',
                            resourcePath: 'sample',
                            indexUrl: '/sample-canonical',
                            newUrl: '/sample-canonical/new',
                            showPattern: '/sample-canonical/{id}',
                            editPattern: '/sample-canonical/edit/{id}',
                            deletePattern: '/sample-canonical/delete/{id}',
                            status: 'canonical',
                        ),
                    ];
                }
            },
        ], new DefaultCrudOperationGrammarProvider());

        $list = $provider->provide();

        self::assertCount(1, $list);
        self::assertSame('sample.one', $list[0]->id());
        self::assertSame('/sample-canonical', $list[0]->indexUrl());
        self::assertSame('canonical', $list[0]->status());
        self::assertSame('/sample-canonical/sample', $list[0]->showSampleUrl());
    }
}
