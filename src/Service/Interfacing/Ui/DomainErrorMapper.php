<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\Service\Interfacing\Ui;

use SmartResponsor\Interfacing\Domain\Interfacing\Error\DomainOperationFailed;
use SmartResponsor\Interfacing\Domain\Interfacing\Ui\UiError;
use SmartResponsor\Interfacing\Domain\Interfacing\Ui\UiErrorBag;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Ui\DomainErrorMapperInterface;

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
