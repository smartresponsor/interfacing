<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\MapperInterface\Ui;

use App\Interfacing\Contract\Error\InterfaceDomainOperationFailed;
use App\Interfacing\Contract\Ui\InterfaceUiErrorBag;

interface InterfaceDomainErrorMapperInterface
{
    public function fromDomainOperationFailed(InterfaceDomainOperationFailed $error): InterfaceUiErrorBag;
}
