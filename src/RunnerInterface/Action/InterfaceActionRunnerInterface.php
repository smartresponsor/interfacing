<?php

declare(strict_types=1);

namespace App\Interfacing\RunnerInterface\Action;

use App\Interfacing\Contract\Action\InterfaceActionRunResultInterface;
use App\Interfacing\Contract\ValueObject\InterfaceActionIdInterface;

interface InterfaceActionRunnerInterface
{
    /** @param array<string, mixed> $input */
    public function run(InterfaceActionIdInterface $id, array $input): InterfaceActionRunResultInterface;
}
