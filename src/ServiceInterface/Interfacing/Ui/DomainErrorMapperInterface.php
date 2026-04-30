<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\ServiceInterface\Interfacing\Ui;

use App\Interfacing\Contract\Error\DomainOperationFailed;
use App\Interfacing\Contract\Ui\UiErrorBag;

interface DomainErrorMapperInterface
{
    public function fromDomainOperationFailed(DomainOperationFailed $error): UiErrorBag;
}
