<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Ui;

use SmartResponsor\Interfacing\Domain\Interfacing\Error\DomainOperationFailed;
use SmartResponsor\Interfacing\Domain\Interfacing\Ui\UiErrorBag;

interface DomainErrorMapperInterface
{
    public function fromDomainOperationFailed(DomainOperationFailed $error): UiErrorBag;
}
