<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Action;

use App\Interfacing\Contract\Ui\InterfaceUiErrorInterface;
use App\Interfacing\Contract\Ui\InterfaceUiMessageInterface;

interface InterfaceActionRunResultInterface
{
    public function result(): InterfaceActionResultInterface;

    /** @return array<int, InterfaceUiErrorInterface> */
    public function errorItem(): array;

    /** @return array<int, InterfaceUiMessageInterface> */
    public function messageItem(): array;
}
