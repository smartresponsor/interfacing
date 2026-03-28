<?php

declare(strict_types=1);

namespace App\Service\Interfacing\Action;

use App\Contract\Action\ActionResult;
use App\Contract\Action\ActionRuntime;
use App\Contract\Ui\UiError;
use App\Contract\ValueObject\ActionIdInterface;
use App\ServiceInterface\Interfacing\Action\ActionCatalogInterface;
use App\ServiceInterface\Interfacing\Action\InterfacingActionRunnerInterface;
use App\ServiceInterface\Interfacing\Action\InterfacingActionRunResultInterface;
use App\ServiceInterface\Support\Telemetry\InterfacingTelemetryInterface;

final readonly class InterfacingActionRunner implements InterfacingActionRunnerInterface
{
    public function __construct(
        private ActionCatalogInterface $catalog,
        private InterfacingTelemetryInterface $telemetry,
    ) {
    }

    public function run(ActionIdInterface $id, array $input): InterfacingActionRunResultInterface
    {
        $start = microtime(true);
        $runtime = new ActionRuntime();

        try {
            $endpoint = $this->catalog->get($id);
            $result = $endpoint->run($input, $runtime);
        } catch (\Throwable $e) {
            $runtime->addError(new UiError('action', null, 'Action failed: '.$e->getMessage(), 'action_failed'));
            $result = ActionResult::fail([
                new UiError('action', null, 'Action failed: '.$e->getMessage(), 'action_failed'),
            ]);
        } finally {
            $ms = (microtime(true) - $start) * 1000.0;
            $this->telemetry->timing('action.run', $ms, ['actionId' => $id->value()]);
        }

        return new InterfacingActionRunResult($result, $runtime->errorItem(), $runtime->messageItem());
    }
}
