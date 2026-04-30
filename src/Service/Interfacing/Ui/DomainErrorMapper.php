<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Service\Interfacing\Ui;

use App\Interfacing\Contract\Error\DomainOperationFailed;
use App\Interfacing\Contract\Ui\UiError;
use App\Interfacing\Contract\Ui\UiErrorBag;
use App\Interfacing\ServiceInterface\Interfacing\Ui\DomainErrorMapperInterface;

final class DomainErrorMapper implements DomainErrorMapperInterface
{
    public function fromDomainOperationFailed(DomainOperationFailed $error): UiErrorBag
    {
        $bag = new UiErrorBag();

        $bag->addGlobal(new UiError(
            'domain',
            null,
            $error->getMessage(),
            0 !== $error->getCode() ? (string) $error->getCode() : null,
        ));

        foreach ($error->fieldMessage() as $field => $message) {
            $bag->addField((string) $field, new UiError('domain', (string) $field, (string) $message));
        }

        return $bag;
    }
}
