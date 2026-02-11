<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Service\Interfacing\Ui;

use App\Domain\Interfacing\Error\DomainOperationFailed;
use App\Domain\Interfacing\Ui\UiError;
use App\Domain\Interfacing\Ui\UiErrorBag;
use App\ServiceInterface\Interfacing\Ui\DomainErrorMapperInterface;

final class DomainErrorMapper implements DomainErrorMapperInterface
{
    public function fromDomainOperationFailed(DomainOperationFailed $error): UiErrorBag
    {
        $bag = new UiErrorBag();

        $bag->addGlobal(new UiError(
            'domain',
            $error->getMessage(),
            null,
            ['code' => $error->getCode()],
        ));

        foreach ($error->fieldMessage() as $field => $message) {
            $bag->addField($field, new UiError('domain', $message, $field));
        }

        return $bag;
    }
}
