<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\Test\Service;

use PHPUnit\Framework\TestCase;
use App\Domain\Interfacing\Action\ActionId;
use App\Domain\Interfacing\Action\ActionRequest;
use App\Domain\Interfacing\Action\ActionResult;
use App\Domain\Interfacing\Screen\ScreenId;
use App\DomainInterface\Interfacing\Action\ActionEndpointInterface;
use App\Service\Interfacing\Action\ActionRunner;
use App\Service\Interfacing\Telemetry\NullTelemetry;

/**
 *
 */

/**
 *
 */
final class ActionRunnerTest extends TestCase
{
    /**
     * @return void
     */
    public function testItRunsEndpointAndEmitsOk(): void
    {
        $endpoint = new class implements ActionEndpointInterface {
            /**
             * @return string
             */
            public function actionId(): string { return 'ping'; }

            /**
             * @param \App\Domain\Interfacing\Action\ActionRequest $request
             * @return \App\Domain\Interfacing\Action\ActionResult
             */
            public function handle(ActionRequest $request): ActionResult
            {
                return ActionResult::ok(['pong' => true]);
            }
        };

        $runner = new ActionRunner([$endpoint], new NullTelemetry());
        $res = $runner->run(new ActionRequest(
            new ScreenId('interfacing-doctor'),
            new ActionId('ping'),
            ['x' => 1],
            ['tenantId' => 'demo']
        ));

        self::assertSame('ok', $res->type());
        self::assertTrue($res->data()['pong']);
    }

    /**
     * @return void
     */
    public function testItMapsExceptionToFail(): void
    {
        $endpoint = new class implements ActionEndpointInterface {
            /**
             * @return string
             */
            public function actionId(): string { return 'boom'; }

            /**
             * @param \App\Domain\Interfacing\Action\ActionRequest $request
             * @return \App\Domain\Interfacing\Action\ActionResult
             */
            public function handle(ActionRequest $request): ActionResult
            {
                throw new \RuntimeException('nope');
            }
        };

        $runner = new ActionRunner([$endpoint], new NullTelemetry());
        $res = $runner->run(new ActionRequest(
            new ScreenId('interfacing-doctor'),
            new ActionId('boom'),
            [],
            []
        ));

        self::assertSame('fail', $res->type());
        self::assertNotEmpty($res->error());
    }
}
