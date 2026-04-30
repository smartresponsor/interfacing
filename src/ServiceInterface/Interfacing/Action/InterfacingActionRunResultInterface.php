<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Action;

use App\Interfacing\Contract\Action\ActionResultInterface;
use App\Interfacing\Contract\Ui\UiErrorInterface;
use App\Interfacing\Contract\Ui\UiMessageInterface;

interface InterfacingActionRunResultInterface
{
    public function result(): ActionResultInterface;

    /** @return array<int, UiErrorInterface> */
    public function errorItem(): array;

    /** @return array<int, UiMessageInterface> */
    public function messageItem(): array;
}
