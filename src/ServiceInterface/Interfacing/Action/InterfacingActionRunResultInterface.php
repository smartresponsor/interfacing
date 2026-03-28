<?php

declare(strict_types=1);

namespace App\ServiceInterface\Interfacing\Action;

use App\Contract\Action\ActionResultInterface;
use App\Contract\Ui\UiErrorInterface;
use App\Contract\Ui\UiMessageInterface;

interface InterfacingActionRunResultInterface
{
    public function result(): ActionResultInterface;

    /** @return array<int, UiErrorInterface> */
    public function errorItem(): array;

    /** @return array<int, UiMessageInterface> */
    public function messageItem(): array;
}
