<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Service\Interfacing\Ui;

use App\Interfacing\Contract\Ui\UiError;
use App\Interfacing\Contract\Ui\UiErrorBag;
use App\Interfacing\ServiceInterface\Interfacing\Ui\UiErrorMapperInterface;
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
