<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Action;

use App\Interfacing\Contract\ValueObject\ActionIdInterface;

interface InterfacingActionRunnerInterface
{
    /** @param array<string, mixed> $input */
    public function run(ActionIdInterface $id, array $input): InterfacingActionRunResultInterface;
}
