<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Service\Interfacing\Action;

use App\Domain\Interfacing\Action\ActionRuntime;
use App\Domain\Interfacing\Action\ActionResult;
use App\Domain\Interfacing\Ui\UiError;
use App\DomainInterface\Interfacing\Action\ActionIdInterface;
use App\InfraInterface\Interfacing\Telemetry\InterfacingTelemetryInterface;
use App\ServiceInterface\Interfacing\Action\ActionCatalogInterface;
use App\ServiceInterface\Interfacing\Action\InterfacingActionRunnerInterface;

/**
 *
 */

/**
 *
 */
final readonly class InterfacingActionRunner implements InterfacingActionRunnerInterface
{
    /**
     * @param \App\ServiceInterface\Interfacing\Action\ActionCatalogInterface $catalog
     * @param \App\InfraInterface\Interfacing\Telemetry\InterfacingTelemetryInterface $telemetry
     */
    public function __construct(
        private ActionCatalogInterface        $catalog,
        private InterfacingTelemetryInterface $telemetry,
    ) {}

    /**
     * @param \App\DomainInterface\Interfacing\Action\ActionIdInterface $id
     * @param array $input
     * @return \App\ServiceInterface\Interfacing\Action\InterfacingActionRunResultInterface
     */
    public function run(ActionIdInterface $id, array $input): \App\ServiceInterface\Interfacing\Action\InterfacingActionRunResultInterface
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

