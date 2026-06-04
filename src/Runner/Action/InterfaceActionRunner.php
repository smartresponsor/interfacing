<?php

declare(strict_types=1);

namespace App\Interfacing\Runner\Action;

use App\Interfacing\CatalogInterface\Action\InterfaceActionCatalogInterface;
use App\Interfacing\Contract\Action\InterfaceActionResult;
use App\Interfacing\Contract\Action\InterfaceActionRunResult;
use App\Interfacing\Contract\Action\InterfaceActionRunResultInterface;
use App\Interfacing\Contract\Action\InterfaceActionRuntime;
use App\Interfacing\Contract\Ui\InterfaceUiError;
use App\Interfacing\Contract\ValueObject\InterfaceActionIdInterface;
use App\Interfacing\RunnerInterface\Action\InterfaceActionRunnerInterface;
use App\Interfacing\TelemetryInterface\InterfaceTelemetryInterface;

final readonly class InterfaceActionRunner implements InterfaceActionRunnerInterface
{
    public function __construct(
        private InterfaceActionCatalogInterface $catalog,
        private InterfaceTelemetryInterface $telemetry,
    ) {
    }

    public function run(InterfaceActionIdInterface $id, array $input): InterfaceActionRunResultInterface
    {
        $start = microtime(true);
        $runtime = new InterfaceActionRuntime();

        try {
            $endpoint = $this->catalog->get($id);
            $result = $endpoint->run($input, $runtime);
        } catch (\Throwable $e) {
            $runtime->addError(new InterfaceUiError('action', null, 'Action failed: '.$e->getMessage(), 'action_failed'));
            $result = InterfaceActionResult::fail([
                new InterfaceUiError('action', null, 'Action failed: '.$e->getMessage(), 'action_failed'),
            ]);
        } finally {
            $ms = (microtime(true) - $start) * 1000.0;
            $this->telemetry->timing('action.run', $ms, ['actionId' => $id->value()]);
        }

        return new InterfaceActionRunResult($result, $runtime->errorItem(), $runtime->messageItem());
    }
}
