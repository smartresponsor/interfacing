<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Mapper\Ui;

use App\Interfacing\Contract\Error\InterfaceDomainOperationFailed;
use App\Interfacing\Contract\Ui\InterfaceUiError;
use App\Interfacing\Contract\Ui\InterfaceUiErrorBag;
use App\Interfacing\MapperInterface\Ui\InterfaceDomainErrorMapperInterface;

final class InterfaceDomainErrorMapper implements InterfaceDomainErrorMapperInterface
{
    public function fromDomainOperationFailed(InterfaceDomainOperationFailed $error): InterfaceUiErrorBag
    {
        $bag = new InterfaceUiErrorBag();

        $bag->addGlobal(new InterfaceUiError(
            'domain',
            null,
            $error->getMessage(),
            0 !== $error->getCode() ? (string) $error->getCode() : null,
        ));

        foreach ($error->fieldMessage() as $field => $message) {
            $bag->addField((string) $field, new InterfaceUiError('domain', (string) $field, (string) $message));
        }

        return $bag;
    }
}
