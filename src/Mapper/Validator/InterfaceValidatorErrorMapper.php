<?php

declare(strict_types=1);

namespace App\Interfacing\Mapper\Validator;

use App\Interfacing\Contract\Ui\InterfaceUiError;
use App\Interfacing\Contract\Ui\InterfaceUiErrorBag;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class InterfaceValidatorErrorMapper
{
    public function map(ConstraintViolationListInterface $violations): InterfaceUiErrorBag
    {
        $bag = new InterfaceUiErrorBag();
        foreach ($violations as $violation) {
            $field = trim((string) $violation->getPropertyPath());
            $error = new InterfaceUiError('validation', '' !== $field ? $field : null, (string) $violation->getMessage(), 'validation');
            if ('' === $field) {
                $bag->addGlobal($error);
            } else {
                $bag->addField($field, $error);
            }
        }

        return $bag;
    }
}
