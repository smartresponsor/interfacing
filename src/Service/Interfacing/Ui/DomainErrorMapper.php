<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Service\Interfacing\Ui;

use App\Contract\Error\DomainOperationFailed;
use App\Contract\Ui\UiError;
use App\Contract\Ui\UiErrorBag;
use App\ServiceInterface\Interfacing\Ui\DomainErrorMapperInterface;

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
