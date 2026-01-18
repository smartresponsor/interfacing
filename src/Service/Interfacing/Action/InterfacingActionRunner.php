<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\Interfacing\Service\Interfacing\Action;

use SmartResponsor\Interfacing\Domain\Interfacing\Action\ActionRuntime;
use SmartResponsor\Interfacing\Domain\Interfacing\Action\ActionResult;
use SmartResponsor\Interfacing\Domain\Interfacing\Ui\UiError;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Action\ActionIdInterface;
use SmartResponsor\Interfacing\InfraInterface\Interfacing\Telemetry\InterfacingTelemetryInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Action\ActionCatalogInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Action\InterfacingActionRunnerInterface;

final class InterfacingActionRunner implements InterfacingActionRunnerInterface
{
    public function __construct(
        private readonly ActionCatalogInterface $catalog,
        private readonly InterfacingTelemetryInterface $telemetry,
    ) {}

    public function run(ActionIdInterface $id, array $input): \SmartResponsor\Interfacing\ServiceInterface\Interfacing\Action\InterfacingActionRunResultInterface
    {
        $start = microtime(true);
        $runtime = new ActionRuntime();

        try {
            $endpoint = $this->catalog->get($id);
            $result = $endpoint->run($input, $runtime);
        } catch (\Throwable $e) {
            $runtime->addError(new UiError('action', null, 'Action failed: ' . $e->getMessage(), 'action_failed'));
            $result = ActionResult::fail(['actionId' => $id->value()]);
        } finally {
            $ms = (microtime(true) - $start) * 1000.0;
            $this->telemetry->timing('action.run', $ms, ['actionId' => $id->value()]);
        }

        return new InterfacingActionRunResult($result, $runtime->errorItem(), $runtime->messageItem());
    }
}

