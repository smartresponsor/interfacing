<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\Service\Interfacing\Action;

use App\Domain\Interfacing\Action\ActionRequest;
use App\Domain\Interfacing\Action\ActionResult;
use App\Domain\Interfacing\Error\UiError;
use App\Domain\Interfacing\Error\UiMessage;
use App\DomainInterface\Interfacing\Action\ActionEndpointInterface;
use App\DomainInterface\Interfacing\Telemetry\TelemetryInterface;
use App\ServiceInterface\Interfacing\Action\ActionRunnerInterface;

/**
 *
 */

/**
 *
 */
final class ActionRunner implements ActionRunnerInterface
{
    /** @var array<string, ActionEndpointInterface>|null */
    private ?array $cache = null;

    /** @param iterable<ActionEndpointInterface> $endpoint */
    public function __construct(
        private readonly iterable $endpoint,
        private readonly TelemetryInterface $telemetry
    ) {}

    /**
     * @param \App\Domain\Interfacing\Action\ActionRequest $request
     * @return \App\Domain\Interfacing\Action\ActionResult
     */
    public function run(ActionRequest $request): ActionResult
    {
        $id = $request->actionId()->value();
        $start = microtime(true);
        try {
            $endpoint = $this->getEndpoint($id);
            $result = $endpoint->handle($request);
            $this->telemetry->event('action.run', [
                'actionId' => $id,
                'screenId' => $request->screenId()->value(),
                'type' => $result->type(),
                'ms' => (int)round((microtime(true) - $start) * 1000),
            ]);
            return $result;
        } catch (\Throwable $e) {
            $this->telemetry->event('action.run', [
                'actionId' => $id,
                'screenId' => $request->screenId()->value(),
                'type' => 'exception',
                'ms' => (int)round((microtime(true) - $start) * 1000),
                'exception' => $e::class,
            ]);

            return ActionResult::fail(
                [new UiError('action_failed', 'Action failed: ' . $e->getMessage())],
                [new UiMessage(UiMessage::LEVEL_ERROR, 'Action failed.')]
            );
        }
    }

    /**
     * @param string $actionId
     * @return \App\DomainInterface\Interfacing\Action\ActionEndpointInterface
     */
    private function getEndpoint(string $actionId): ActionEndpointInterface
    {
        $map = $this->index();
        if (!isset($map[$actionId])) {
            throw new \OutOfBoundsException('Unknown action id: ' . $actionId);
        }
        return $map[$actionId];
    }

    /** @return array<string, ActionEndpointInterface> */
    private function index(): array
    {
        if ($this->cache !== null) {
            return $this->cache;
        }

        $map = [];
        foreach ($this->endpoint as $e) {
            $id = $e->actionId();
            if (isset($map[$id])) {
                throw new \LogicException('Duplicate action id: ' . $id);
            }
            $map[$id] = $e;
        }
        ksort($map);
        $this->cache = $map;
        return $map;
    }
}
