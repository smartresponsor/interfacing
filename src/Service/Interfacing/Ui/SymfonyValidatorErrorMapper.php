<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Service\Interfacing\Ui;

use App\Contract\Ui\UiError;
use App\Contract\Ui\UiErrorBag;
use App\ServiceInterface\Interfacing\Ui\UiErrorMapperInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class SymfonyValidatorErrorMapper implements UiErrorMapperInterface
{
    public function fromViolationList(ConstraintViolationListInterface $violation): UiErrorBag
    {
        $bag = new UiErrorBag();

        /** @var ConstraintViolationInterface $v */
        foreach ($violation as $v) {
            $path = (string) $v->getPropertyPath();
            $message = (string) $v->getMessage();
            $code = null !== $v->getCode() ? (string) $v->getCode() : null;

            $error = new UiError(
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
