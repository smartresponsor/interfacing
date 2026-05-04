<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Interfacing\Contract;

use App\Interfacing\Contract\Action\ActionRequest;
use App\Interfacing\Contract\Action\ActionResult;
use App\Interfacing\Contract\ValueObject\ActionId;
use App\Interfacing\Contract\ValueObject\ScreenId;
use App\Interfacing\Service\Interfacing\ActionRunner;
use App\Interfacing\ServiceInterface\Interfacing\Catalog\ActionEndpointCatalogInterface;
use App\Interfacing\ServiceInterface\Interfacing\Catalog\ActionEndpointInterface;
use App\Interfacing\ServiceInterface\Interfacing\TelemetryBridgeInterface;
use App\Interfacing\Support\Telemetry\TelemetryEvent;
use PHPUnit\Framework\TestCase;

final class ActionRunnerContractTest extends TestCase
{
    public function testRunUsesCanonicalActionEndpointCatalog(): void
    {
        $screenId = ScreenId::fromString('contract.screen');
        $actionId = ActionId::fromString('contract-action');
        $seen = [];
        $telemetryEvents = [];

        $runner = new ActionRunner(
            new class($actionId, $seen) implements ActionEndpointCatalogInterface {
                public function __construct(
                    private readonly ActionId $expectedActionId,
                    private array &$seen,
                ) {
                }

                public function all(): array
                {
                    return [new class($this->expectedActionId, $this->seen) implements ActionEndpointInterface {
                        public function __construct(
                            private readonly ActionId $expectedActionId,
                            private array &$seen,
                        ) {
                        }

                        public function id(): ActionId
                        {
                            return $this->expectedActionId;
                        }

                        public function handle(ActionRequest $request): ActionResult
                        {
                            $this->seen[] = [
                                'screenId' => $request->screenId()->toString(),
                                'actionId' => $request->actionId()->toString(),
                                'payload' => $request->payload(),
                                'context' => $request->context(),
                            ];

                            return ActionResult::ok(['handled' => true]);
                        }
                    }];
                }

                public function get(ActionId $id): ActionEndpointInterface
                {
                    if (!$this->expectedActionId->equals($id)) {
                        throw new \RuntimeException('Unexpected action id.');
                    }

                    return $this->all()[0];
                }
            },
            new class($telemetryEvents) implements TelemetryBridgeInterface {
                public function __construct(private array &$events)
                {
                }

                public function emit(TelemetryEvent $event): void
                {
                    $this->events[] = [
                        'name' => $event->name(),
                        'tag' => $event->tag(),
                    ];
                }
            },
        );

        $result = $runner->run($screenId, $actionId, ['amount' => 42], ['tenant' => 'acme']);

        self::assertSame(ActionResult::TYPE_OK, $result->type());
        self::assertSame(['handled' => true], $result->data());
        self::assertSame([[
            'screenId' => 'contract.screen',
            'actionId' => 'contract-action',
            'payload' => ['amount' => 42],
            'context' => ['tenant' => 'acme'],
        ]], $seen);
        self::assertCount(1, $telemetryEvents);
        self::assertSame('action.run', $telemetryEvents[0]['name']);
        self::assertSame([
            'screenId' => 'contract.screen',
            'actionId' => 'contract-action',
        ], $telemetryEvents[0]['tag']);
    }
}
