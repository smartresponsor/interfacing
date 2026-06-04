<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Mapper\Ui;

use App\Interfacing\Contract\Ui\InterfaceUiError;
use App\Interfacing\Contract\Ui\InterfaceUiErrorBag;
use App\Interfacing\MapperInterface\Ui\InterfaceUiErrorMapperInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class InterfaceSymfonyValidatorErrorMapper implements InterfaceUiErrorMapperInterface
{
    public function fromViolationList(ConstraintViolationListInterface $violation): InterfaceUiErrorBag
    {
        $bag = new InterfaceUiErrorBag();

        /** @var ConstraintViolationInterface $v */
        foreach ($violation as $v) {
            $path = (string) $v->getPropertyPath();
            $message = (string) $v->getMessage();
            $code = null !== $v->getCode() ? (string) $v->getCode() : null;

            $error = new InterfaceUiError(
                'validation',
                '' !== $path ? $path : null,
                $message,
                $code,
            );

            if ('' !== $path) {
                $bag->addField($path, $error);
            } else {
                $bag->addGlobal($error);
            }
        }

        return $bag;
    }
}
