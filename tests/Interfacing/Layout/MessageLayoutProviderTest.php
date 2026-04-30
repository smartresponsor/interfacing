<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Interfacing\Layout;

use App\Interfacing\Service\Interfacing\Layout\Provider\MessageLayoutProvider;
use PHPUnit\Framework\TestCase;

final class MessageLayoutProviderTest extends TestCase
{
    public function testDigestLayoutIsRegistered(): void
    {
        $provider = new MessageLayoutProvider();
        $specs = $provider->provide();

        $ids = array_map(static fn ($spec): string => $spec->id(), $specs);

        self::assertContains('message.digest', $ids);
    }
}
