<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\ServiceInterface\Interfacing\Ui;

use App\Domain\Interfacing\Error\DomainOperationFailed;
use App\Domain\Interfacing\Ui\UiErrorBag;

/**
 *
 */

/**
 *
 */
interface DomainErrorMapperInterface
{
    /**
     * @param \App\Domain\Interfacing\Error\DomainOperationFailed $error
     * @return \App\Domain\Interfacing\Ui\UiErrorBag
     */
    public function fromDomainOperationFailed(DomainOperationFailed $error): UiErrorBag;
}
