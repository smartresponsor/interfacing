<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Service\Interfacing\Ui;

use App\Domain\Interfacing\Ui\UiError;
use App\Domain\Interfacing\Ui\UiErrorBag;
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
            $code = (string) ($v->getCode() ?? 'validation');

            $error = new UiError($code, $message, $path !== '' ? $path : null, [
                'invalid' => is_scalar($v->getInvalidValue()) ? $v->getInvalidValue() : null,
            ]);

            if ($path !== '') {
                $bag->addField($path, $error);
            } else {
                $bag->addGlobal($error);
            }
        }

        return $bag;
    }
}
